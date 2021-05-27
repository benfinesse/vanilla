<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Traits\Auth\AuthTrait;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AuthTrait;

    public function index(Request $request){
        $user = $request->user();
        $recent = Record::orderBy('id', 'desc')->take(4)->get();
        $user_id = $user->uuid;
        $pending =
            Record::query()
                ->whereIn('records.uuid',function(Builder $query) use ($user_id) {
                    $query->from('office_slips')
                        ->select('office_slips.record_id')
                        ->where('office_slips.status','=','pending')
                        ->whereIn('office_slips.office_id', function (Builder $q) use ($user_id){
                            $q->from('office_members')
                                ->select('office_members.office_id')
                                ->where('office_members.user_id', $user_id);
                        })
                    ;
                })
                ->where('completed', '!=',true)
                ->orderBy('id','desc')
                ->get();

        return view('pages.dashboard.index')->with(
            [
                'records'=>$recent,
                'pending'=>$pending
            ]
        );
    }
}

<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Traits\Email\Mailer;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;

class TestController extends Controller
{
    use Mailer;
    public function email($email){
        $data = [
            'name'=>'guest'
        ];
        $this->sendMail('', 'Test Email',$email,'Testing the email','Ben Ice',$data,'emails.test');
        return response()->json(['completed']);
    }

    public function pending($user_id){
        $pending =
            Record::query()
                ->whereIn('records.uuid',function(Builder $query) use ($user_id) {
                    $query->from('office_slips')
                        ->select('office_slips.record_id')
                        ->where('office_slips.status','=','pending')
                        ->where('office_slips.current','=',true)
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
        $output = [];
        foreach ($pending as $record){
            array_push($output, [
                'record'=>$record,
                'slips'=>$record->slips,
                'current_slip'=>$record->CurrentOfficeSlip,
                'current_slip_office'=>!empty($record->CurrentOfficeSlip)?$record->CurrentOfficeSlip->office:'no data found'
            ]);
        }
        return $output;
    }
}

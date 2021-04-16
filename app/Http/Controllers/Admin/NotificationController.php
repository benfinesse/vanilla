<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request){
        $type = $request->input('type');
        $user = $request->user();
        $query = Notice::query()
            ->orderBy('id', 'desc')
            ->where('user_id', $user->uuid);
        $data = [];
        if(empty($type)){
            $type = 'unread';
            $data = $query->where('seen', false)->paginate(20);
        }else{
            if($type==='seen'){
                $data = $query->where('seen', true)->paginate(20);
            }elseif($type==='all'){
                $data = $query->paginate(20);
            }else{
                $type = 'unread';
                $data = $query->where('seen', false)->paginate(20);
            }
        }

        return view('pages.notice.index')->with(['data'=>$data,'type'=>$type]);

    }

    public function preview(Request $request, $uuid){
        $user = $request->user();
        $notice = Notice::whereUuid($uuid)->where('user_id', $user->uuid)->first();
        if(!empty($notice)){
            if(!$notice->seen){
                $data['seen'] = true;
                DB::beginTransaction();
                $notice->update($data);
                DB::commit();
            }

            return redirect($notice->url);
        }
        return back()->withErrors(['Could not complete request. Refresh and try again.']);
    }
}

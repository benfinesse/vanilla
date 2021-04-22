<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\OfficeSlip;
use App\Models\Record;
use Illuminate\Http\Request;

class AuditProcessController extends Controller
{
    public function show(Request $request, $uuid){
        $msg = $request->input('message');
        $user = $request->user();
        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            if($record->completed){
                return redirect()->route('record.history', $record->uuid)->withMessage("Record completed already.");
            }
            //ensure that only the record has not moved to another office
            $office_slip = OfficeSlip::where('record_id', $record->uuid)->where('office_id', $record->office_id)->where('current', true)->first();
            if(!empty($office_slip)){
                $office = $record->office;
                if(!empty($office)){
                    //ensure only office members can view
                    if($office->isMember){
                        return view('pages.audit.preview')->with([
                            'record'=>$record,
                            'message'=>$msg
                        ]);
                    }else{
                        return redirect()->route('notice.index', ['type'=>'all'])->withErrors(['You do not have valid access to the resource.']);
                    }
                }
                return redirect()->route('record.history', $record->uuid)->withMessage('Sorry. The file has been moved.');
            }
        }
        return back()->withErrors(['Resource not found.']);


    }

}

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
        $user = $request->user();
        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            //ensure that only the record has not moved to another office
            $office_slip = OfficeSlip::where('record_id', $record->uuid)->where('office_id', $record->office_id)->where('current', true)->first();
            if(!empty($office_slip)){
                $office = $record->office;
                if(!empty($office)){
                    //ensure only office members can view
                    if($office->isMember){
                        return view('pages.audit.preview')->with([
                            'record'=>$record
                        ]);
                    }else{
                        return redirect()->route('notice.index', ['type'=>'all'])->withErrors(['You do not have valid access to the resource.']);
                    }
                }
                return redirect()->route('notice.index', ['type'=>'all'])->withErrors(['Sorry. The file has been moved.']);
            }
        }
        return back()->withErrors(['Resource not found.']);


    }

}

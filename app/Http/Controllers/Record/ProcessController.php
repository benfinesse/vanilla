<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeSlip;
use App\Models\Record;
use App\Services\Record\ProcessService;
use App\Traits\Auth\AuthTrait;
use App\Traits\General\MailAttachment;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcessController extends Controller
{
    use Utility, AuthTrait, MailAttachment;

    protected $service;

    public function __construct(ProcessService $service)
    {
        $this->service = $service;
    }

    public function start(Request $request, $record_id){
        $user = $request->user();
        if(!$user->hasAccess('create_record')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        $record = Record::whereUuid($record_id)->first();
        if(!empty($record)){
            $office_process = $record->process;
            if(!empty($office_process)){
                $office = Office::where('process_id', $office_process->uuid)->orderBy('id', 'asc')->first();

                //stage
                if(!empty($office)){

                    $user = $request->user();
                    $this->service->startStage($record, $office, $user);
                    $n = $record->process->name;

                    return redirect()->route('record.index')->withMessage("One record submitted for {$n}.");

                }
            }
        }
    }

    /**
     * @param Request $request
     * @param $record_id
     * @param $dir - direction i.e next || prev
     */
    public function moveOffice(Request $request, $record_id, $dir){
        $comment = $request->input('comment');
        $record = Record::whereUuid($record_id)->first();
        $coffice_id = $request->input('coffice');
        $approvable = $request->input('approvable');


        if(!empty($coffice_id)){
            if(!empty($record)){
                $office = $record->office;
                if(!empty($office)){
                    if($dir==='next'){
                        $nextOffice = $record->nextOffice;
                        if(!empty($nextOffice)){
                            //conditions to prevent shift and error by confirming position and current office id
                            if(($office->position+1) === $nextOffice->position && $coffice_id === $office->uuid){

//                                return $this->sendPdfToOfficeMembers($nextOffice, $record);

                                $res = $this->service->nextOffice($office, $record, $comment);
                                if($res[0]){

                                    //if request has approve, send PDF of record to all mailbox in the next office
                                    if($approvable==='yes'){
                                        if(!empty($nextOffice)){
                                            $this->sendPdfToOfficeMembers($nextOffice, $record);
                                        }
                                    }

                                    return redirect()->route('notice.index',['type'=>'all'])->withMessage("You have submitted one item to {$nextOffice->name}.");
                                }else{
                                    return back()->withErrors($res[1]);
                                }
                            }
                            return redirect()->route('notice.index')->withErrors(["This request may have already been taken care of. Kindly refresh and try again"]);
                        }
                    }elseif ($dir==='prev'){
                        // todo - handle moving to previous office

                        $prevOffice = $record->prevOffice;
                        if(!empty($prevOffice)){
                            //conditions to prevent shift and error by confirming position and current office id
                            if(($office->position -1) === $prevOffice->position && $coffice_id === $office->uuid ){
                                $res = $this->service->prevOffice($office, $record, $comment);
                                if($res[0]){
                                    return redirect()->route('notice.index',['type'=>'all'])->withMessage("You have returned one item to {$prevOffice->name}.");
                                }else{
                                    return back()->withErrors($res[1]);
                                }
                            }
                            return redirect()->route('notice.index')->withErrors(["This request may have already been taken care of. Kindly refresh and try again"]);
                        }
                    }else{
                        return back()->withErrors(['Could not complete request. refresh and try again']);
                    }
                }
            }
        }
        return redirect()->route('notice.index')->withErrors(["This request may have already been taken care of. Kindly refresh and try again"]);
    }

    public function close(Request $request, $uuid){
        $user = $this->loggedInUser();
        $comment = $request->input('comment');
        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $record_data['completed'] = true;
            $currentOfficeSlip = $record->currentOfficeSlip;

            DB::beginTransaction();
            //update current slip
            if(!empty($currentOfficeSlip)){
                $os['comment'] = empty($comment)?"Approved by {$user->names}":$comment;
                $os['user_id_2'] = $user->uuid;
                $currentOfficeSlip->update($os);
            }
            $record->update($record_data);
            DB::commit();
            // $this->service->sendOfficeNotice()

            return redirect()->route('record.history', $record->uuid)->withMessage("One record completed successfully.");
        }

        return back()->withErrors(['Could not complete request. refresh and try again']);
    }

    public function history(Request $request, $record_id){
        $user = $request->user();
        if(!$user->hasAccess('view_record')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        $record = Record::whereUuid($record_id)
            ->with([
                'slips'
            ])
            ->first();
        if(!empty($record)){
            return view('pages.records.history.index')->with(['record'=>$record]);
        }

        return back()->withErrors(['Could not complete request. refresh and try again']);
    }
}

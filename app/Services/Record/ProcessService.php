<?php

namespace App\Services\Record;

use App\Models\Notice;
use App\Models\Office;
use App\Models\OfficeSlip;
use App\Models\Record;
use App\Traits\Auth\AuthTrait;
use App\Traits\Email\Mailer;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Support\Facades\DB;

class ProcessService
{
    use Utility, Mailer, AuthTrait;

    public function sendOfficeNotice(Office $office, $url, $message, $title="New Notice."){
        foreach ($office->members as $member){

            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $member->uuid;
            $data['title'] = $title;
            $data['message'] = $message;
            $data['url'] = $url;
            $data['icon'] = '';
            $data['seen'] = false;
            $data['active'] = true;

            DB::beginTransaction();
            Notice::create($data);
            DB::commit();

            //send email


            $data = [
                'user'=>$member,
                'process'=>$office->process,
                'date'=>date('F d, Y'),
            ];
            $this->sendMail('', $title, $member->email, $message, $member->names, $data, 'emails.new_notice');

        }
    }

    public function startStage(Record $record, Office $office, User $user){

        $slip_data['uuid'] = $this->makeUuid();
        $slip_data['user_id'] = $user->uuid;
        $slip_data['record_id'] = $record->uuid;
        $slip_data['office_id'] = $office->uuid;
        $slip_data['status'] = 'pending';
        $slip_data['current'] = true;
        $slip_data['approved'] = false;

        DB::beginTransaction();
        OfficeSlip::create($slip_data);

        //update record
        $record_data['office_id'] = $office->uuid;
        $record_data['stage'] = $office->position;
        $record->update($record_data);
        $dname = $record->process->name;
        $title = "One new item submitted for {$dname}.";
        $url = route('record.audit', $record->uuid);
        DB::commit();

        $message = "One new item submitted to {$office->name} for the process : ".$office->process->name;
        $this->sendOfficeNotice($office, $url, $message, $title);
    }

    public function nextOffice(Office $office, Record $record){

        if(!empty($office)){
            $currentSlip = $record->currentOfficeSlip;
            if(!empty($currentSlip)){
                $nextOffice = $record->nextOffice;
                if(!empty($nextOffice)){
                    $user = $this->loggedInUser();
                    $this->buildStage($record, $nextOffice, $user, $currentSlip);
                    return [1, "Completed"];
                }
                //else proceed to completion
                else{
                    dd("do completion. Contact Support");
                }
            }
            return [0, "Could not complete. contact Support"];
        }
        return [0, "No office instance"];
    }

    public function buildStage(Record $record, Office $office, User $user, OfficeSlip $oldSlip){
        $slip_data['uuid'] = $this->makeUuid();
        $slip_data['user_id'] = $user->uuid;
        $slip_data['record_id'] = $record->uuid;
        $slip_data['office_id'] = $office->uuid;
        $slip_data['status'] = 'pending';
        $slip_data['current'] = true;
        $slip_data['approved'] = false;

        DB::beginTransaction();
        OfficeSlip::create($slip_data);
        $os['current'] = false;
        $oldSlip->update($os);

        //update record
        $record_data['office_id'] = $office->uuid;
        $record_data['stage'] = $office->position;
        $record->update($record_data);
        $dname = $record->process->name;
        $title = "One new item submitted for {$dname}.";
        $url = route('record.audit', $record->uuid);
        $message = "One new item submitted to {$office->name} for the process : ".$office->process->name;

        DB::commit();
        $this->sendOfficeNotice($office, $url, $message, $title);
    }
}
<?php

namespace App\Services\Record;

use App\Models\Notice;
use App\Models\Office;
use App\Models\OfficeSlip;
use App\Models\Record;
use App\Traits\Email\Mailer;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Support\Facades\DB;

class ProcessService
{
    use Utility, Mailer;

    public function sendOfficeNotice(Office $office, $url, $record_id, $title="New Notice."){
        foreach ($office->members as $member){

            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $member->uuid;
            $data['title'] = $title;
            $data['url'] = $url;
            $data['icon'] = '';
            $data['seen'] = false;
            $data['active'] = true;

            DB::beginTransaction();
            Notice::create($data);
            DB::commit();

            //send email
            $subject = "One new item to attend to for ".$office->process->name;
            $data = [
                'user'=>$member,
                'process'=>$office->process,
                'date'=>date('F d, Y'),
            ];
            $this->sendMail('', $title, $member->email, $subject, $member->names, $data, 'emails.new_notice');

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
        $this->sendOfficeNotice($office, $url, $record->uuid, $title);



    }
}
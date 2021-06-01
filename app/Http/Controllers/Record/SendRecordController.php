<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Traits\Email\Mailer;
use Illuminate\Http\Request;

class SendRecordController extends Controller
{
    use Mailer;
    public function sendRecord(Request $request){
        $edata = $request->input('emails');
        if(!empty($edata)){
            $count = 0;
            $emails = explode(",", $edata);
            $uuid = $request->input('record_id');
            $record = Record::whereUuid($uuid)->first();

            if(!empty($record)){

                foreach ($emails as $email){
                    if(!empty($email)){
                        $count++;
                        $data=[
                            'url'=>route('record.history', $record->uuid),
                        ];
                        $this->sendMail("", "Vanilla Purchase Record",$email,"Purchase Record for you","from vanilla",$data, "emails.send_record");
                    }
                }

                if($count>0){
                    $s = $count>1?'s':'';
                    return redirect()->back()->withMessage("{$count} email{$s} sent successfully.");
                }else{
                    return redirect()->back()->withErrors(["Nothing was sent via email."]);
                }
            }
        }
        return redirect()->back()->withErrors(['No email recipient(s).']);

    }
}

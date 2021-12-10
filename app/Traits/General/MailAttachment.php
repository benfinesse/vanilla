<?php

namespace App\Traits\General;

use App\Traits\Email\Mailer;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Str;

trait MailAttachment{
    use Mailer;
    public function sendPdfToOfficeMembers($office, $record){
//        dd($office->members, $record->groups);
        $pdfData = [
            "record"=>$record
        ];

//        return view("pdf.printable")->with($pdfData);

       try{
           $pdf = PDF::loadView("pdf.printable", $pdfData)->setPaper('a4', 'landscape');

           foreach ($office->members as $member){
               $data = [
                   'info'=>"Find attachment for approved document"
               ];
               $this->sendMail("", "Vanilla Purchase Attachment",$member->email,"Approved Attachment","from vanilla",$data, "emails.send_attachment", [$pdf->output()]);
           }
       }catch (\Exception $err){
           //send error notice

       }

//        return view("pdf.printable")->with($pdfData);
    }
}
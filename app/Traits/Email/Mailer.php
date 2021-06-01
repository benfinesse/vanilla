<?php

namespace App\Traits\Email;

use Illuminate\Support\Facades\Mail;

trait Mailer{
    public function sendEmail($to, $subject, $body, $from = null, $fromTitle = null){

        $mail = env('MAIL_FROM_ADDRESS', '');
        $title = !empty($fromTitle)?"$fromTitle":"Invoice Pod";
        $fromMail = "$title <$mail>";

        $headersMail = '';
        $headersMail .= "Reply-To:" . $fromMail . "\r\n";
        $headersMail .= "Return-Path: ". $fromMail ."\r\n";
        $headersMail .= 'From: ' . $fromMail . "\r\n";
        $headersMail .= "Organization: Invoice Pod \r\n";
        $headersMail .= 'MIME-Version: 1.0' . "\r\n";
        $headersMail .= "X-Priority: 3\r\n";
        $headersMail .= "X-Mailer: PHP". phpversion() ."\r\n" ;
        $headersMail .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
        $headersMail .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";

        @mail($to,$subject,$body, $headersMail);
    }

    public function sendMail($from, $title, $to, $subject, $names, $data, $view, array $attachment=[]){
        // dd($from, $title, $to, $subject, $names, $data, $view,$attachment);
        $live = config('app.is_live');

        if($live){
            try{
                $from = env('FROM_ADDRESS', '');
                Mail::send($view, $data, function ($mail) use ($from, $to, $title,$subject, $attachment) {
                    $mail->from($from, $title);
                    $mail->to($to)->subject($subject);
                    if(count($attachment) > 0){
                        foreach ($attachment as $file){
                            try{
                                $mail->attach($file);
                            }catch (\Exception $e){
                                session(['err'=>$e->getMessage()]);
                            }
                        }
                    }
                });
            }catch (\Exception $e){
                session(['err'=>"Failed to send mail ->".$e->getMessage()." | -{$to}-{$from}-"]);
                //todo - send error to developer
            }
        }else{
            //@mock send
        }

    }
}
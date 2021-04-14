<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Traits\Email\Mailer;
use Illuminate\Http\Request;

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
}

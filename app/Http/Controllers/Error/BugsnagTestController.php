<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 10/16/2021
 * Time: 8:52 PM
 */

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;
use App\Http\Controllers\Controller;

Class BugsnagTestController extends Controller{

    public function runtest(){
        Bugsnag::notifyException(new RuntimeException("Test error"));
    }
}


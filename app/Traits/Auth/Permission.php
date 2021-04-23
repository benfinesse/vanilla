<?php

namespace App\Traits\Auth;
use Illuminate\Support\Facades\Auth;

trait Permission{
    use AuthTrait;

    public function hasAccess($action){
        $access = Auth::user()->roles->where('active', true)->where($this->action($action), true)->first();
        return !empty($access)?true:false;
    }

    public function action($act){
        switch ($act){
            case 'settings':
                return 'settings';
                break;
            case 'admin':
                return 'administration';
                break;
            default:
                return '';
        }
    }

}
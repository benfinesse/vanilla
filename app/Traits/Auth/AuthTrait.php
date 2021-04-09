<?php

namespace App\Traits\Auth;
use Illuminate\Support\Facades\Auth;

trait AuthTrait{

    public function loggedInUser($guard=null){
        if(empty($guard)){
            return Auth::user();
        }
        try{
            return Auth::guard($guard)->user();
        }catch (\Exception $e){
            return null;
        }
    }

}
<?php

namespace App\Services\Account;


use App\Models\RoleMember;
use App\Traits\Auth\AuthTrait;
use App\Traits\Email\Mailer;
use App\Traits\General\Utility;
use Illuminate\Support\Facades\DB;

class AccountService
{
    use Utility, Mailer, AuthTrait;

    public function addToRole($member_id, $role_id){
        //check of member is already in office
        $exist = RoleMember::where('user_id', $member_id)->where('role_id', $role_id)->first();
        if(empty($exist)){
            // add member
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $member_id;
            $data['role_id'] = $role_id;
            DB::beginTransaction();
            RoleMember::create($data);
            DB::commit();

            return [1, "New member added to group."];
        }
        return [0, 'User already has an account with role.'];
    }
    public function removeFromRole($member_id, $role_id){
        $exist = RoleMember::where('user_id', $member_id)->where('role_id', $role_id)->first();
        if(!empty($exist)){
            $exist->delete();
            return [1,"Member removed from group"];
        }
        return [0,'Member not in group'];
    }
}
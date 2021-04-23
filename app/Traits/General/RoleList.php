<?php

namespace App\Traits\General;

use Illuminate\Support\Str;

trait RoleList{
    public function permissions(){
        return [
            'create_user',
            'edit_user',
            'delete_user',
            'create_role',
            'edit_role',
            'delete_role',
            'create_record',
            'edit_record',
            'delete_record',
            'create_group',
            'edit_group',
            'delete_group',
            'create_process',
            'edit_process',
            'delete_process',
            'create_measure',
            'edit_measure',
            'delete_measure',
            'create_office',
            'edit_office',
            'delete_office',
            'modify_office_member',
            'view_processes',
            'view_groups',
            'view_measure',
            'view_users',
            'view_roles',
            'administration',
            'settings',
        ];
    }
}
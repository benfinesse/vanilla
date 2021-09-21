<?php

namespace App\Traits\General;

use Illuminate\Support\Str;

trait RoleList{
    public function permissions(){
        return [
            'view_users',
            'create_user',
            'edit_user',
            'delete_user',
            'view_roles',
            'create_role',
            'edit_role',
            'delete_role',
            'view_record',
            'create_record',
            'edit_record',
            'delete_record',
            'view_groups',
            'create_group',
            'edit_group',
            'delete_group',
            'view_processes',
            'create_process',
            'edit_process',
            'delete_process',
            'view_measure',
            'create_measure',
            'edit_measure',
            'delete_measure',
            'create_product',
            'edit_product',
            'delete_product',
            'create_office',
            'edit_office',
            'delete_office',
            'modify_office_member',
            'administration',
            'settings',
            'procurement',
        ];
    }
}
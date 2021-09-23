<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
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
        'create_product',
        'edit_product',
        'delete_product',
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
        'procurement',
        'active',
        'view_record',

    ];

    public function getuserCountAttribute(){
        return $this->users->count();
    }

    public function users(){
        return $this->hasManyThrough(
            User::class,
                RoleMember::class,
                'role_id',
                'uuid',
                'uuid',
                'user_id');
    }
}

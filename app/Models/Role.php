<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'uuid',
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
        'active',
    ];
}

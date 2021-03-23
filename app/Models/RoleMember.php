<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMember extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'role_id',
    ];
}

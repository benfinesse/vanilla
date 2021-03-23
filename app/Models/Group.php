<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'active',
    ];
}

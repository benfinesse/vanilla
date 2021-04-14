<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeMember extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'office_id',
    ];
}

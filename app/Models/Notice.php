<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'message',
        'url',
        'icon',
        'seen',
        'active',
    ];
}

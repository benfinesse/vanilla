<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'url',
        'icon',
        'seen',
        'active',
    ];
}

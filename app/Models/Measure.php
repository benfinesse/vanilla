<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'active',
    ];
}

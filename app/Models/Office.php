<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'process_id',
        'name',
        'position',
        'active',
    ];
}

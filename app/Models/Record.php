<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'stage',
        'md_approved',
        'acc_approved',
        'md_verified',
        'procurement_verified',
        'completed',
        'active',
    ];
}

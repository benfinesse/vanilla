<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeSlip extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'record_id',
        'office_id',
        'status',
        'approved',
        'comment',
    ];
}

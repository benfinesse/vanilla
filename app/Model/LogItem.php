<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogItem extends Model
{
    protected $fillable = [
        'uuid',
        'log_group_id',
        'name',
        'old_price',
        'new_price',
        'old_qty',
        'new_qty',
        'action_taken',
        'info',
    ];
}

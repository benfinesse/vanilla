<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordItem extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'record_id',
        'measure_id',
        'type',
        'name',
        'qty',
        'price',
        'excluded',
        'true_qty',
        'true_price',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordItem extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'record_id',
        'record_group_id',
        'measure',
        'supplier',
        'stock_outside',
        'stock_store',
        'type',
        'name',
        'qty',
        'price',
        'excluded',
        'true_qty',
        'true_price',
    ];

    public function getTotalAttribute(){
        return floatval($this->qty)*floatval($this->price);
    }
}

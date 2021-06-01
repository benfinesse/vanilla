<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'group_id',
        'name',
        'price',
        'measure',
    ];

    public function group(){
        return $this->hasOne(Group::class, 'uuid', 'group_id');
    }
}

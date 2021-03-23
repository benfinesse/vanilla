<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OfficeProcess extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'active',
    ];

    public function stages(){
        return $this->hasMany(Office::class, 'process_id', 'uuid');
    }

    public function user(){
        return $this->hasOne(User::class, 'uuid', 'user_id');
    }
}

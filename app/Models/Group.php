<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'active',
    ];

    public function user(){
        return $this->hasOne(User::class, 'uuid', 'user_id');
    }
}

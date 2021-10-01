<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'contact',
        'phone',
        'email',
        'address',
        'active',
    ];

    public function user(){
        return $this->hasOne(User::class, 'uuid', 'user_id');
    }
}

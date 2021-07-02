<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LogGroup extends Model
{
    protected $fillable = [
        'uuid',
        'group_id',
        'record_id',
        'user_id',
    ];


    public function logs(){
        return $this->hasMany(LogItem::class, 'log_group_id', 'uuid');
    }

    public function user(){
        return $this->hasOne(User::class, 'uuid', 'user_id');
    }


}

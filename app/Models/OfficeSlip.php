<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class OfficeSlip extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'user_id_2',
        'record_id',
        'office_id',
        'status',
        'approved',
        'comment',
        'current'
    ];

    public function office(){
        return $this->hasOne(Office::class, 'uuid', 'office_id');
    }

    public function getLastUserAttribute(){
        $a = User::where('uuid', $this->user_id_2)->first();
        return !empty($a)?$a:User::where('uuid', $this->user_id)->first();
    }

    public function getUserAttribute(){
        return User::where('uuid', $this->user_id)->first();
    }
}

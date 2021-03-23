<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordGroup extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'record_id',
        'group_id',
    ];

    public function group(){
        return $this->hasOne(Group::class, 'uuid', 'group_id');
    }

    public function records(){

    }

    public function getTotalAttribute(){

    }
}

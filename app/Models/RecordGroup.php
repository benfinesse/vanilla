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

    public function getRecordItemsAttribute(){
        return RecordItem::where('record_id', $this->record_id)->where('record_group_id', $this->uuid)->get();
    }

    public function getTotalAttribute(){

    }
}

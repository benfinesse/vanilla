<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'office_id',
        'process_id',
        'stage',
        'completed',
        'active',
        'title',
    ];

    public function getstatusColorAttribute(){
        switch ($this->status){
            case "completed":
                return "success";
                break;
            case "edited":
                return "warning";
                break;
            default:
                return "primary";
                break;
        }
    }
    public function getStatusAttribute(){
        $status = "";
        if($this->completed){
            $status = "completed";
        }else{
            if(!empty($this->office)){
                $status = $this->office->name;
            }else{
                $status = "edited";
            }
        }
        return $status;
    }

    public function process(){
        return $this->hasOne(OfficeProcess::class, 'uuid', 'process_id');
    }



    public function office(){
        return $this->hasOne(Office::class, 'uuid', 'office_id');
    }

    public function groups(){
        return $this->hasMany(RecordGroup::class, 'record_id', 'uuid');
    }

    public function getNextOfficeAttribute(){
        $office = Office::where('uuid', $this->office_id)->where('process_id', $this->process_id)->first();
        if(!empty($office)){
            $next = Office::where('process_id', $this->process_id)->where('position','>',$office->position)->orderBy('position','asc')->first();
            if(!empty($next)){
                return $next;
            }
        }
        return null;
    }

    public function getPrevOfficeAttribute(){
        $office = Office::where('uuid', $this->office_id)->where('process_id', $this->process_id)->first();
        if(!empty($office)){
            $prev = Office::where('process_id', $this->process_id)->where('position','<',$office->position)->orderBy('position','asc')->first();
            if(!empty($prev)){
                return $prev;
            }
        }
        return null;
    }

    public function getCurrentOfficeSlipAttribute(){
        return OfficeSlip::where('record_id', $this->uuid)
            ->where('office_id', $this->office_id)
            ->where('current', true)
            ->first();
    }
}

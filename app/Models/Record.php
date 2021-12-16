<?php

namespace App\Models;

use App\Model\LogGroup;
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
        'fund_source',
        'amount_approved',
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

    public function slips(){
        return $this->hasMany(OfficeSlip::class, 'record_id', 'uuid');
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
            $prev = Office::where('process_id', $this->process_id)->where('position','<',$office->position)->orderBy('position','desc')->first();
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

    public function loggroup(){
        return $this->hasMany(LogGroup::class, 'record_id', 'uuid');
    }
}

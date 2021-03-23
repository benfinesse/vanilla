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
}

<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeSlip;
use App\Models\Record;
use App\Services\Record\ProcessService;
use App\Traits\Auth\AuthTrait;
use App\Traits\General\Utility;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    use Utility, AuthTrait;

    protected $service;

    public function __construct(ProcessService $service)
    {
        $this->service = $service;
    }

    public function start(Request $request, $record_id){
        $record = Record::whereUuid($record_id)->first();
        if(!empty($record)){
            $office_process = $record->process;
            if(!empty($office_process)){
                $office = Office::where('process_id', $office_process->uuid)->orderBy('id', 'asc')->first();

                //stage
                if(!empty($office)){

                    $user = $request->user();
                    $this->service->startStage($record, $office, $user);
                    $n = $record->process->name;

                    return redirect()->route('record.index')->withMessage("One record submitted for {$n}.");

                }
            }
        }
    }

    /**
     * @param Request $request
     * @param $record_id
     * @param $dir - direction i.e next || prev
     */
    public function moveOffice(Request $request, $record_id, $dir){
        $record = Record::whereUuid($record_id)->first();
        if(!empty($record)){
            $office = $record->office;
            if(!empty($office)){
//                dd($office);
            }
        }
    }

    public function close($uuid){

    }
}

<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function tryPositionMove($uuid, $dir){
        $item_1 = Office::whereUuid($uuid)->first();
        if(!empty($item_1)){
            $pos1 = intval($item_1->position);

            //try to get position 2
            if($dir==='up'){
                $item_2 = Office::where('process_id', $item_1->process_id)->where('position','<', $pos1)->orderBy('position','desc')->first();
            }else{
                $item_2 = Office::where('process_id', $item_1->process_id)->where('position','>', $pos1)->orderBy('position','asc')->first();
            }
            if(!empty($item_2)){
                $pos2 = intval($item_2->position);
                $data2['position'] = $pos1;
                $data1['position'] = $pos2;
                DB::beginTransaction();
                $item_1->update($data1);
                $item_2->update($data2);
                DB::commit();
                return back()->withMessage('Position Updated');
            }
        }
        return back()->withErrors(['Could not complete operation']);
    }
}

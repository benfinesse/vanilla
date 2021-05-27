<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\RecordItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{

    public function compliance(Request $request){
        $uuid = $request->input('item_id');
        $recordItem = RecordItem::whereUuid($uuid)->first();
        $price = $request->input('price');
        $qty = $request->input('qty');

        if(!empty($recordItem)){
            if(!empty($price) && !empty($qty)){
                $data['true_qty'] = floatval($qty);
                $data['true_price'] = floatval($price);
                $total = floatval($qty) * floatval($price);
                DB::beginTransaction();
                $recordItem->update($data);
                DB::commit();

                return response()->json(['success'=>true, 'item'=>$recordItem]);
            }
            return response()->json(['success'=>false, 'message'=>'One or more required fields are missing.']);
        }
        return response()->json(['success'=>false, 'message'=>'Resource not found', 'bdata'=>$request->all()]);
    }
    //
}

<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RecordGroup;
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
                $name = $recordItem->name;

                //attempt update on product
                $this->attemptUpdate($name, $price, $recordItem->record_group_id);
                DB::commit();

                return response()->json(['success'=>true, 'item'=>$recordItem]);
            }
            return response()->json(['success'=>false, 'message'=>'One or more required fields are missing.']);
        }
        return response()->json(['success'=>false, 'message'=>'Resource not found', 'bdata'=>$request->all()]);
    }

    public function toggleAvailability(Request $request){
        $uuid = $request->input('item_id');
        $recordItem = RecordItem::whereUuid($uuid)->first();

        if(!empty($recordItem)){
            if($recordItem->excluded){
                $data['excluded'] = false;
                $msg = "One line excluded from request. Totals Updated";
            }else{
                $data['excluded'] = true;
                $msg = "One line included to request. Totals Updated";
            }
            DB::beginTransaction();
            $recordItem->update($data);
            DB::commit();

            return back()->withMessage($msg);
        }
        return redirect()->route('home')->withErrors("Resource not found.");
    }

    public function attemptUpdate($name, $price, $rgid){
        $rg = RecordGroup::where('uuid', $rgid)->first();
        if(!empty($rg)){
            $product = Product::where('name', $name)->where('group_id', $rg->group_id)->first();
            if(!empty($product)){
                $data['price'] = $price;
                $product->update($data);
            }
        }
    }
    //
}

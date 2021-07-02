<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Model\LogGroup;
use App\Model\LogItem;
use App\Models\Group;
use App\Models\Product;
use App\Models\Record;
use App\Models\RecordGroup;
use App\Models\RecordItem;
use App\Traits\Auth\AuthTrait;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    use Utility, AuthTrait;
    public function store(Request $request, $uuid){

        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $dept_id = $request->input('dept_id');
            $group = Group::whereUuid($dept_id)->first();
            if(!empty($group)){
                $user = $this->loggedInUser();

                $items = $request->input('items');

                if(count($items)>0){

                    //create group
                    DB::beginTransaction();

                    $rg_id = $this->makeUuid();
                    $r_group['uuid'] = $rg_id;
                    $r_group['user_id'] = $user->uuid;
                    $r_group['record_id'] = $record->uuid;
                    $r_group['group_id'] = $group->uuid;

                    RecordGroup::create($r_group);

                    foreach ($items as $item){
                        $name = $item['name'];
                        //store name if not existing

                        $measure = $item['measure'];
                        $price = floatval($item['price']);
                        $this->attemptNewProduct($name, $group->uuid, $measure, $price);

                        $data['uuid'] = $this->makeUuid();
                        $data['user_id'] = $user->uuid;
                        $data['record_id'] = $record->uuid;
                        $data['record_group_id'] = $rg_id;
                        $data['measure'] = $measure;
                        $data['stock_outside'] = $item['stock_outside'];
                        $data['stock_store'] = $item['stock_store'];
                        $data['name'] = $name;
                        $data['qty'] = floatval($item['qty']);
                        $data['price'] = $price;
                        RecordItem::create($data);
                    }

                    DB::commit();

                    return response()->json([
                        'success'=>true,
                        'message'=>'record',
                        'redirect'=>route('record.list',$record->uuid)
                    ]);

                }

                return response()->json(['message'=>'Items might be empty, double check or refresh page.']);
            }
        }
        return response()->json(['message'=>'Could not complete request. Refresh page and try again.']);
    }


    public function update(Request $request, $uuid){

        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $dept_id = $request->input('dept_id');
            $group = Group::whereUuid($dept_id)->first();
            if(!empty($group)){

                $items = $request->input('items');


                if(count($items)>0){

                    $group_record_id = $request->input('group_record_id');
                    $group_record = RecordGroup::whereUuid($group_record_id)->first();

                    DB::beginTransaction();

                    $basket = [];
                    if(!empty($group_record)){
                        if(@$group_record->recordItems->count() > 0){
                            //delete old record
                            foreach ($group_record->recordItems as $item){
                                $basket[$item->name] = ['price'=>$item->price,'qty'=>$item->qty];
                                $item->delete();
                            }
                        }
                    }

                    $user = $this->loggedInUser();

                    //create group
                    $rg_id = $group_record->uuid;

                    $logs = [];
                    $record_id = $record->uuid;
                    $log_group_id = $this->makeUuid();
                    $log_group['uuid'] = $log_group_id;
                    $log_group['group_id'] = $group_record_id;
                    $log_group['record_id'] = $record_id;
                    $log_group['user_id'] = $user->uuid;
                    LogGroup::create($log_group);

//                    return response()->json($items, 500);
                    foreach ($items as $item){
                        $name = $item['name'];
                        $price = floatval($item['price']);
                        $qty = intval($item['qty']);
                        $key = $name;
                        //check if name exist in basket
                        //return response()->json([$basket], 500);

                        if(array_key_exists($key, $basket)){


                            $product = $basket[$key];
                            $msg = "";
                            $logItem = null;
                            //return response()->json($product, 500);
//                            return response()->json($item, 500);

                            if(floatval($product['price']) !== $price){
                                $oprice = $product['price'];
                                $nprice = $price;
                                $msg .= "{$key} price updated from {$oprice} to {$nprice}, ";

                                $logItem['old_price'] = $oprice;
                                $logItem['new_price'] =  $nprice;
                            }

                            if(intval($product['qty'])!== $qty){
                                $oldqty = $product['qty'];
                                $newqty = $qty;
                                $msg .= "{$key} quantity updated from {$oldqty} to {$newqty}, ";

                                $logItem['old_qty'] = $oldqty;
                                $logItem['new_qty'] =  $newqty;
                            }

                            if(floatval($product['price']) !== $price || intval($product['qty'])!==$qty){
                                $logItem['uuid'] = $this->makeUuid();
                                $logItem['log_group_id'] = $log_group_id;
                                $logItem['name'] = $key;
                                $logItem['action_taken'] = $msg;
                                $logItem['info'] = "Update";
                                LogItem::create($logItem);
                            }

                            //remove item from basket
                            unset($basket[$key]);

                        }else{

                            $logItem['uuid'] = $this->makeUuid();
                            $logItem['log_group_id'] = $log_group_id;
                            $logItem['name'] = $key;
                            $logItem['action_taken'] = "New item '{$key}' added.";
                            $logItem['old_price'] = 0;
                            $logItem['new_price'] = $price;
                            $logItem['old_qty'] = 0;
                            $logItem['new_qty'] =  $item->qty;
                            $logItem['info'] = "New Item";
                            LogItem::create($logItem);

                        }



                        //store name if not existing
                        $measure = $item['measure'];

                        $this->attemptNewProduct($name, $group->uuid, $measure, $price);

                        $data['uuid'] = $this->makeUuid();
                        $data['user_id'] = $user->uuid;
                        $data['record_id'] = $record_id;
                        $data['record_group_id'] = $rg_id;
                        $data['measure'] = $measure;
                        $data['stock_outside'] = $item['stock_outside'];
                        $data['stock_store'] = $item['stock_store'];
                        $data['name'] = $name;
                        $data['qty'] = floatval($item['qty']);
                        $data['price'] = $price;
                        RecordItem::create($data);
                    }

                    foreach($basket as $key=>$val){
                        $logItem = null;
                        $logItem['uuid'] = $this->makeUuid();
                        $logItem['log_group_id'] = $log_group_id;
                        $logItem['name'] = $key;
                        $logItem['old_price'] = $val['price'];
                        $logItem['new_price'] = 0;
                        $logItem['old_qty'] = $val['qty'];
                        $logItem['new_qty'] =  0;
                        $logItem['action_taken'] = "Item '{$key}' removed.";
                        $logItem['info'] = "Deleted";
                        LogItem::create($logItem);
                        unset($basket[$key]);
                    }

                    //todo - delete empty log groups
                    $log_groups = LogGroup::has('logs', '<', 1)->get();
                    foreach ($log_groups as $lg){
                        $lg->delete();
                    }

                    DB::commit();

                    return response()->json([
                        'success'=>true,
                        'message'=>'record updated',
                        'redirect'=>'back'
                    ]);

                }

                return response()->json(['message'=>'Items might be empty, double check or refresh page.']);
            }
        }
        return response()->json(['message'=>'Could not complete request. Refresh page and try again.']);
    }

    function attemptNewProduct($name, $group_id, $measure, $price){
        $user = $this->loggedInUser();
        $exist = Product::where('name', $name)->where('group_id', $group_id)->first();
        if(empty($exist)){
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $user->uuid;
            $data['group_id'] = $group_id;
            $data['name'] = $name;
            $data['price'] = $price;
            $data['measure'] = $measure;
            Product::create($data);
        }
    }
}

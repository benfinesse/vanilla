<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
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
                        $this->attemptNewProduct($name, $group->uuid);

                        $data['uuid'] = $this->makeUuid();
                        $data['user_id'] = $user->uuid;
                        $data['record_id'] = $record->uuid;
                        $data['record_group_id'] = $rg_id;
                        $data['measure'] = $item['measure'];
                        $data['name'] = $name;
                        $data['qty'] = intval($item['qty']);
                        $data['price'] = floatval($item['price']);
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
                $group_record_id = $request->input('group_record_id');
                $group_record = RecordGroup::whereUuid($group_record_id)->first();

                if(!empty($group_record)){
                    if($group_record->recordItems->count() > 0){
                        //delete old record
                        foreach ($group_record->recordItems as $item){
                            $item->delete();
                        }
                    }
                }

                $user = $this->loggedInUser();

                $items = $request->input('items');

                if(count($items)>0){

                    //create group
                    DB::beginTransaction();

                    $rg_id = $group_record->uuid;

                    foreach ($items as $item){
                        $name = $item['name'];
                        //store name if not existing
                        $this->attemptNewProduct($name, $group->uuid);

                        $data['uuid'] = $this->makeUuid();
                        $data['user_id'] = $user->uuid;
                        $data['record_id'] = $record->uuid;
                        $data['record_group_id'] = $rg_id;
                        $data['measure'] = $item['measure'];
                        $data['name'] = $name;
                        $data['qty'] = intval($item['qty']);
                        $data['price'] = floatval($item['price']);
                        RecordItem::create($data);
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

    function attemptNewProduct($name, $group_id){
        $user = $this->loggedInUser();
        $exist = Product::where('name', $name)->where('group_id', $group_id)->first();
        if(empty($exist)){
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $user->uuid;
            $data['group_id'] = $group_id;
            $data['name'] = $name;
            Product::create($data);
        }
    }
}

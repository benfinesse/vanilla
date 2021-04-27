<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Product;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use Utility;
    public function index()
    {
        $measures = Product::get();
        return view('pages.product.index')->with([
            'data'=>$measures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::get();
        return view('pages.product.create')->with([
            'groups'=>$groups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'=>'required',
                'group_id'=>'required',
            ]
        );

        $name = $request->input('name');
        $group_id = $request->input('group_id');

        $exist = Product::where('name', $name)->where('group_id', $group_id)->first();
        if(empty($exist)){

            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $request->user()->uuid;
            $data['group_id'] = $group_id;
            $data['name'] = $name;
            DB::beginTransaction();
            Product::create($data);
            DB::commit();
            return redirect()->route('product.index')->withMessage("One new product added successfully");
        }
        return back()->withErrors(["Product with {$name} already exist with selected group."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($uuid)
    {
        $prod = Product::whereUuid($uuid)->first();
        if(!empty($prod)){
            $prod->delete();
            return redirect()->route('product.index')->withMessage("One item deleted");
        }
        return back()->withErrors(["Resource not found. Could not complete."]);
        //
    }
}

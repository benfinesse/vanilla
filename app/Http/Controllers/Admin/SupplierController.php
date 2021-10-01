<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Traits\General\Utility;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('view_supplier')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $suppliers = Supplier::orderBy('id','desc')->where('active', true)->get();
        return view('pages.supplier.index')->with([
            'data'=>$suppliers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('create_supplier')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        return view('pages.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('create_supplier')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $name = $request->input('name');
        if(empty($name)){
            return back()->withErrors(['Name field is required!']);
        }
        $ex = Supplier::where('name', $name)->where('active', true)->first();
        if(!empty($ex)){
            return back()->withErrors(["The name '{$name}' is already in use."]);
        }
        $data = $request->all();
        $data['uuid'] = $this->makeUuid();
        $data['active'] = true;
        $data['user_id'] = $request->user()->uuid;

        Supplier::create($data);
        return redirect()->route('supplier.index')->withMessage("One item added to supplier list.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('edit_supplier')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $item = Supplier::whereUuid($uuid)->first();
        if(!empty($item)){
            return view('pages.supplier.edit', compact('item'));
        }

        return back()->withErrors(['Could not find resources.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('edit_supplier')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $item = Supplier::whereUuid($uuid)->where('active', true)->first();
        if(empty($item)){
            return back()->withErrors(['Failed to complete. Resource not found.']);
        }

        $name = $request->input('name');
        if(empty($name)){
            return back()->withErrors(['Name field is required!']);
        }
        $ex = Supplier::where('name', $name)->where('uuid', '!=' , $uuid)->where('active', true)->first();
        if(!empty($ex)){
            return back()->withErrors(["The name '{$name}' is already in use."]);
        }
        $data = $request->all();

        $item->update($data);
        return redirect()->route('supplier.index')->withMessage("One item updated successfully.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    public function pop(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('view_supplier')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $item = Supplier::whereUuid($uuid)->first();
        if(!empty($item)){
            $data['active'] = false;
            $item->update($data);
            return back()->withMessage("One item removed");
        }

        return back()->withErrors(['Could not complete request']);
        //
    }
}

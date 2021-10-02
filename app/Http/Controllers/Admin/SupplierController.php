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

    public function seedSupply(Request $request){
        $suppliers = [
            'Market', 'Sinolat', 'Josien', 'Edhino', 'Prince', 'Bonavee',
            'Baraka Tarris', 'Jokmani empire', 'Joss coral foods', 'Paper packaging company', 'Zealot Apex Meridian', 'Seafood Hub',
            'First Todesa', 'Brightways', 'British American Tobacco', 'A.C. Ventures', 'Amasco Divine Favour Inv', 'Banrut Rolls Nigeria LTD',
            'Felak meat shop', 'China', 'Ansi Global Investment lTD', 'Seafood Cluster', 'The One Spirit Company', 'Khaliyat',
            'Susan Frozen Foods', 'Zartech', 'Grandex Plus', 'Ledrop', 'Nigerian Bottling Company', 'Prymo',
            'UTO Mayonaise', 'Mando INV', 'Fan Milk', 'Abbatoir', 'Lois packaging company', 'Salmars Veg Supply',
            'Earthfreshfoods', 'Valcez international', 'Gauge Nigeria LTD', 'D Wine Bank', 'Enstore', 'Okad Seafood',
            'Wine House', 'Noble hill wines', 'Malway farms LTD', 'Fish Shop', 'Babangida Muazu', 'Amics stores',
            'Ub_Hanfari -farmers market', 'Bbq Butchers', 'Hum-so concerns', 'Zurich Ventures', 'Drinks and Foods warehouse (lag)', 'Fresh Veggie Plus',
            'Paper Cup Factory',
        ];
        $count = 0;
        foreach ($suppliers as $name){
            $ex = Supplier::where('name', $name)->where('active', true)->first();
            if(empty($ex)){
                $data['name'] = $name;
                $data['uuid'] = $this->makeUuid();
                $data['active'] = true;
                $data['user_id'] = $request->user()->uuid;
                Supplier::create($data);
                $count++;
            }
        }
        return ["completed {$count} records"];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Measure;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeasureController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('view_measure')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $measures = Measure::get();
        return view('pages.measure.index')->with([
            'data'=>$measures
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
        if(!$user->hasAccess('create_measure')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        return view('pages.measure.create');
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
        if(!$user->hasAccess('create_measure')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        $request->validate(['name'=>'required']);
        $name = $request->input('name');
        $exist = Measure::where('name', $name)->first();
        if(empty($exist)){
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $request->user()->uuid;
            $data['name'] = $name;
            $data['active'] = true;
            DB::beginTransaction();
            Measure::create($data);
            DB::commit();
            return redirect()->route('measure.index')->withMessage('New measure added.');
        }
        return back()->withErrors(["A measure with the name '{$name}' already exist."])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function show(Measure $measure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function edit(Measure $measure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Measure $measure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Measure  $measure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measure $measure)
    {
        //
    }

    public function delete(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('delete_measure')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $mea = Measure::whereUuid($uuid)->first();
        if(!empty($mea)){
            $mea->delete();
            return redirect()->route('measure.index')->withMessage("One item deleted");
        }
        return back()->withErrors(["Resource not found. Could not complete."]);
        //
    }


}

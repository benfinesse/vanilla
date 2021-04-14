<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeProcess;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeProcessController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $process = OfficeProcess::orderBy('id','desc')->get();
        return view('pages.process.index')->with([
            'data'=>$process
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.process.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        if(!empty($name)){
            $exist = OfficeProcess::where('name', $name)->first();
            if(empty($exist)){
                $data['uuid'] = $this->makeUuid();
                $data['user_id'] = $request->user()->uuid;
                $data['name'] = $name;
                $data['active'] = true;
                DB::beginTransaction();
                OfficeProcess::create($data);
                DB::commit();
                return redirect()->route('process.index')->withMessage("New Office Process Created.");
            }

            return back()->withErrors(['Name already in use. Select another name.'])->withInput();
        }
        return back()->withErrors(['Name filed is empty.'])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeProcess  $officeProcess
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeProcess $officeProcess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeProcess  $officeProcess
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeProcess $officeProcess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeProcess  $officeProcess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfficeProcess $officeProcess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeProcess  $officeProcess
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeProcess $officeProcess)
    {
        //
    }

    public function listItems($uuid){
        $process = OfficeProcess::whereUuid($uuid)->first();
        if(!empty($process)){
            $data = Office::where('process_id', $process->uuid)->orderBy('position','asc')->get();
            return view('pages.process.list')->with([
                'data'=>$data,
                'process'=>$process
            ]);
        }
        return redirect()->route('process.index')->withErrors(['Resource not found']);
    }

    public function addItemToList(Request $request){

    }
}

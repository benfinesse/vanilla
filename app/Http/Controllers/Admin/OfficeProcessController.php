<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficeProcess;
use Illuminate\Http\Request;

class OfficeProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $process = OfficeProcess::get();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}

<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Measure;
use App\Models\OfficeProcess;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $records = Record::where('active', true)->orderBy('id', 'desc')->paginate(30);
        return view('pages.records.index')->with([
            'records'=>$records
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $measure = Measure::get();
        $depts = Group::get();
        $processes = OfficeProcess::get();
        return view('pages.records.create')->with([
            'measures'=>$measure,
            'depts'=>$depts,
            'processes'=>$processes,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }
}

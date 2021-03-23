<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Measure;
use App\Models\OfficeProcess;
use App\Models\Record;
use App\Models\RecordGroup;
use App\Models\RecordItem;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    use Utility;
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
        $processes = OfficeProcess::get();
        return view('pages.records.create')->with([
            'measures'=>$measure,
            'processes'=>$processes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $process_id = $request->input('process_id');
        $process = OfficeProcess::whereUuid($process_id)->first();
        if(!empty($process)){
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $user->uuid;
            $data['process_id'] = $process_id;
            $data['active'] = true;
            $data['title'] = $user->names. " created record on ". date("M d, Y");
            DB::beginTransaction();
            $record = Record::create($data);
            DB::commit();

            return redirect()->route('record.manage', $record->uuid)->withMessage("Record created. Enter details of records.");
        }
        return redirect()->route('record.index')->withErrors(['Resource not found']);
    }

    public function manage($uuid){
        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $groups = Group::get();
            $measure = Measure::get();
            return view('pages.records.manage.record')->with([
                'measures'=>$measure,
                'depts'=>$groups,
                'record'=>$record
            ]);
        }
        return redirect()->route('record.index')->withErrors(['Resource not found']);
    }

    public function listItems($uuid){


        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $data = RecordGroup::where('record_id', $record->uuid)->get();
            return view('pages.records.manage.list')->with([
                'data'=>$data,
                'record'=>$record
            ]);
        }
        return redirect()->route('record.index')->withErrors(['Resource not found']);
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

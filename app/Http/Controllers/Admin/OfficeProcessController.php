<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeMember;
use App\Models\OfficeProcess;
use App\Models\OfficeSlip;
use App\Models\Record;
use App\Models\RecordGroup;
use App\Models\RecordItem;
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
    public function index(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('view_processes')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $process = OfficeProcess::orderBy('id','desc')->get();
        return view('pages.process.index')->with([
            'data'=>$process
        ]);
    }

    public function popItem(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('delete_process')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $process = OfficeProcess::whereUuid($uuid)->first();
        if(!empty($process)){
            DB::beginTransaction();
            $process_id = $process->uuid;



            //remove office from the process
            $offices = Office::where('process_id', $process_id)->get();
            foreach ( $offices as $office){
                $office_id = $office->uuid;

                //get members hook
                $office_member_anchor = OfficeMember::where('office_id', $office_id)->get();
                foreach ($office_member_anchor as $anchor){
                    $anchor->delete();
                }

                //delete slips
                $office_slips = OfficeSlip::where('office_id', $office_id)->get();
                foreach ($office_slips as $anchor){
                    $anchor->delete();
                }

                $records = Record::where('process_id', $process_id)->get();
                foreach ( $records as $record){
                    $record_id = $record->uuid;

                    $office_slips = OfficeSlip::where('record_id', $record_id)->get();
                    foreach ($office_slips as $anchor){
                        $anchor->delete();
                    }

                    $rec_items = RecordItem::where('record_id', $record_id)->get();
                    foreach ($rec_items as $anchor){
                        $anchor->delete();
                    }

                    $record->delete();
                    //delete the record groups related to the record
                    $rgs = RecordGroup::where('record_id', $record_id)->get();
                    foreach ($rgs as $rg){
                        $rg->delete();
                    }

                }

                $office->delete();
            }
            //delete process
            $process->delete();

            //delete records



            DB::commit();
        }
        return back()->withMessage("One item deleted successfully");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('create_process')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
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
        $user = $request->user();
        if(!$user->hasAccess('create_process')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $user = $request->user();
        if(!$user->hasAccess('create_process')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

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
    public function edit(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('edit_process')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        $process = OfficeProcess::whereUuid($uuid)->first();
        if(!empty($process)){
            return view('pages.process.edit')->with(['process'=>$process]);
        }
        return back()->withErrors(['Resource not found']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeProcess  $officeProcess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('create_process')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        $process = OfficeProcess::whereUuid($uuid)->first();
        if(!empty($process)){
            $name = $request->input('name');
            $exist = OfficeProcess::where('name', $name)->where('uuid', '!=', $uuid)->first();
            if(empty($exist)){
                $data['name'] = $name;
                DB::beginTransaction();
                $process->update($data);
                DB::commit();
                return redirect()->route('process.index')->withMessage("Process updated");
            }
            return back()->withErrors(["Process with the name {$name} already exist."]);
        }
        return back()->withErrors(['Resource not found']);
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

    public function toggleVerification(Request $request, $uuid){

        $office = Office::whereUuid($uuid)->first();
        if(!empty($office)){
            $msg = "";
            if($office->verifiable){
                $data['verifiable'] = false;
                $msg = "Audit removed from {$office->name}";
            }else{
                $data['verifiable'] = true;
                $msg = "Audit added to {$office->name}";
            }
            DB::beginTransaction();
            $office->update($data);
            DB::commit();

            return back()->withMessage($msg);
        }
        return back()->withErrors(['Resource not found']);
    }
}

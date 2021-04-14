<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeMember;
use App\Models\OfficeProcess;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function create($process_id)
    {
        $process = OfficeProcess::whereUuid($process_id)->first();
        if(!empty($process)){
            return view('pages.process.stage_create')->with(['process'=>$process]);
        }
        return back()->withErrors(['Could not complete request']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $process_id)
    {
        $name = $request->input('name');
        $process = OfficeProcess::whereUuid($process_id)->first();
        if(!empty($process)){
            if(!empty($name)){
                $exist = Office::where('name', $name)->where('process_id', $process_id)->first();
                $pos = Office::where('process_id', $process_id)->select(['id'])->get()->count();
                if(empty($exist)){
                    $data['uuid'] = $this->makeUuid();
                    $data['user_id'] = $request->user()->uuid;
                    $data['name'] = $name;
                    $data['active'] = true;
                    $data['process_id'] =  $process_id;
                    $data['position'] = intval($pos)+1;
                    DB::beginTransaction();
                    Office::create($data);
                    DB::commit();
                    return redirect()->route('process.list', $process_id)->withMessage("New Office added to list");
                }

                return back()->withErrors(['Name already in use. Select another name.'])->withInput();
            }
            return back()->withErrors(['Name filed is empty.'])->withInput();
        }
        return back()->withErrors(['Process not found'])->withInput();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }

    public function pop($uuid){
        $office = Office::whereUuid($uuid)->first();
        if(!empty($office)){
            $office->delete();
            return back()->withMessage("One office item deleted");
        }

        return back()->withErrors(['Could not complete request']);
    }

    public function manage(Request $request, $uuid){
        $office = Office::whereUuid($uuid)->first();
        if(!empty($office)){
            $members = User::where('active', true)->select([
                'uuid',
                'first_name',
                'last_name',
                'email',
            ])->get();
            return view('pages.process.list_manage')->with([
                'office'=>$office,
                'process'=>$office->process,
                'members'=>$members
            ]);
        }
        return back()->withErrors(['Unable to complete request']);
    }

    public function addMember(Request $request){
        $member_id = $request->input('uuid');
        $office_id = $request->input('office_id');
        $office = Office::whereUuid($office_id)->first();
        if(!empty($office)){
            $user = User::whereUuid($member_id)->first();
            if(!empty($user)){
                //check of member is already in office
                $exist = OfficeMember::where('user_id', $member_id)->where('office_id', $office_id)->first();
                if(empty($exist)){
                    // add member
                    $data['uuid'] = $this->makeUuid();
                    $data['user_id'] = $member_id;
                    $data['office_id'] = $office_id;
                    DB::beginTransaction();
                    OfficeMember::create($data);
                    DB::commit();
                    return back()->withMessage("New member added to office");
                }
                return back()->withErrors(['Member already in group']);
            }
        }
        return back()->withErrors(['Could not complete request.']);
    }

    public function removeMember(Request $request){
        $member_id = $request->input('uuid');
        $office_id = $request->input('office_id');
        $office = Office::whereUuid($office_id)->first();
        if(!empty($office)) {
            $exist = OfficeMember::where('user_id', $member_id)->where('office_id', $office_id)->first();
            if(!empty($exist)){
                $exist->delete();
                return back()->withMessage("Member removed from group");
            }
            return back()->withErrors(['Member not in group']);
        }
        return back()->withErrors(['Could not complete request.']);
    }
}

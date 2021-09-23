<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
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
        if(!$user->hasAccess('view_groups')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $data = Group::get();
        return view('pages.group.index')->with([
            'data'=>$data
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
        if(!$user->hasAccess('create_group')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        return view('pages.group.create');
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
        if(!$user->hasAccess('create_group')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $name = $request->input('name');
        $exist = Group::where('name', $name)->first();
        if(empty($exist)){
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $request->user()->uuid;
            $data['name'] = $name;
            $data['active'] = true;
            DB::beginTransaction();
            Group::create($data);
            DB::commit();
            return redirect()->route('group.index')->withMessage("New Department added.");
        }
        return back()->withErrors(["The name already exist. If not, contact support"])->withInput();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('edit_groups')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $user = $request->user();
        if(!$user->hasAccess('create_group')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $group)
    {

        $user = $request->user();
        if(!$user->hasAccess('delete_group')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
    }

    public function pop(Request $request, $uuid)
    {

        $user = $request->user();
        if(!$user->hasAccess('delete_group')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $group = Group::whereUuid($uuid)->first();
        if(empty($group)){
            return back()->withErrors(['Could not complete. Resource not found']);
        }

        $group->delete();
        return back()->withMessage("One item deleted successfully");


    }
}

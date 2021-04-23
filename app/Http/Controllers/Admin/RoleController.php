<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleMember;
use App\Services\Account\AccountService;
use App\Traits\General\RoleList;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    use RoleList, Utility;

    protected $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id','desc')->paginate(20);
        return view('pages.roles.index')
            ->with(
                [
                    'data'=>$roles
                ]
            );
    }

    /**
     * Show the form for creating a new resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->permissions();
        return view('pages.roles.create')->with(['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required'
        ]);

        $fields = $this->permissions();
        $data['uuid'] = $this->makeUuid();
        $data['user_id'] = $request->user()->uuid;
        $data['title'] = $request->input('title');
        $data['active'] = true;
        foreach ($fields as $field){
            $data[$field] = $request->input($field)==='on'?true:false;
        }

        DB::beginTransaction();
        Role::create($data);
        DB::commit();

        return redirect()->route('role.index')->withMessage("New role created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $role = Role::whereUuid($uuid)->first();
        if (!empty($role)){
            $roles = $this->permissions();
            return view('pages.roles.edit')->with(['role'=>$role, 'roles'=>$roles]);
        }
        return back()->withErrors(['Resource not found']);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $role = Role::whereUuid($uuid)->first();
        if (!empty($role)){

            $request->validate([
                'title'=>'required'
            ]);

            $fields = $this->permissions();
            $data['title'] = $request->input('title');
            foreach ($fields as $field){
                $data[$field] = $request->input($field)==='on'?true:false;
            }

            DB::beginTransaction();
            $role->update($data);
            DB::commit();

            return redirect()->route('role.index')->withMessage("Role Updated.");

        }
        return back()->withErrors(['Resource not found']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    public function manage(Request $request, $uuid){
        $role = Role::whereUuid($uuid)->first();
        if(!empty($role)){
            $users = User::orderBy('id','desc')->select(['uuid', 'first_name','last_name'])->get();

//            return $role->users;
            return view('pages.roles.manage')->with(['members'=>$users,'role'=>$role]);
        }
        return back()->withErrors(['Resource not found']);
    }

    public function addMember(Request $request){
        $member_id = $request->input('uuid');
        $role_id = $request->input('role_id');
        $role = Role::whereUuid($role_id)->first();
        if(!empty($role)){

            $user = User::whereUuid($member_id)->first();
            if(!empty($user)){

                $res = $this->service->addToRole($member_id, $role_id);
                if($res[0]){
                    return back()->withMessage($res[1]);
                }else{
                    return back()->withErrors([$res[1]]);
                }

            }
        }
        return back()->withErrors(['Could not complete request.']);
    }

    public function removeMember(Request $request){
        $member_id = $request->input('uuid');
        $role_id = $request->input('role_id');
        $role = Role::whereUuid($role_id)->first();
        if(!empty($role)) {
            $res = $this->service->removeFromRole($member_id, $role_id);
            if($res[0]){
                return back()->withMessage($res[1]);
            }else{
                return back()->withErrors([$res[1]]);
            }
        }
        return back()->withErrors(['Could not complete request.']);
    }
}

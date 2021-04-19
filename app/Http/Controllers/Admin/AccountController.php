<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\Email\Mailer;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    use Utility, Mailer;
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $query = User::query()->orderBy('id', 'desc');
        $account = [];

        if(empty($type)){
            $type = 'all';
            $account = $query->paginate(20);
        }else{
            if($type==='active'){
                $account = $query->where('active', true)->paginate(20);
            }elseif($type==='inactive'){
                $account = $query->where('active', false)->paginate(20);
            }else{
                $type = 'all';
                $account = $query->paginate(20);
            }
        }
        return view('pages.users.index')
            ->with(
                [
                    'data'=>$account,
                    'type'=>$type

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
        $roles = Role::get();
        return view('pages.users.create')->with(['roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|unique:users',
        ]);

        $role = Role::whereUuid($request->input('role_id'))->first();
        if(!empty($role)){
            $data['uuid'] = $this->makeUuid();
            $data['first_name'] = $request->input('first_name');
            $data['last_name'] = $request->input('last_name');
            $data['email'] = $request->input('email');
            $data['token'] = $this->randomName(35);
            DB::beginTransaction();
            $user = User::create($data);
            DB::commit();

            //send email to user with access to new role
            $rdata = [
                'user'=>$user,
                'role'=>$role
            ];

            $this->sendMail('', "Vanilla Account Invite", $user->email, "Your new account with Vanilla", $user->names, $rdata, 'emails.new_account');

            return redirect()->route('account.index')->withMessage("New account setup");

        }
        return back()->withErrors(['Could not complete. Resource not found']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

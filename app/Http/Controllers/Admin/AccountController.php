<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\Account\AccountService;
use App\Traits\Email\Mailer;
use App\Traits\General\Utility;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    use Utility, Mailer;

    protected $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

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
            'email'=>'required',
        ]);

        $role = Role::whereUuid($request->input('role_id'))->first();
        if(!empty($role)){
            $email = $request->input('email');
            $user = User::where('email', $email)->first();
            if(empty($user)){
                $data['uuid'] = $this->makeUuid();
                $data['first_name'] = $request->input('first_name');
                $data['last_name'] = $request->input('last_name');
                $data['email'] = $email;
                $data['token'] = $this->randomName(35);
                $data['active'] = false;
                DB::beginTransaction();
                $user = User::create($data);
                DB::commit();

                $rdata = [
                    'user'=>$user,
                    'role'=>$role
                ];

                $this->sendMail('', "Vanilla Account Invite", $user->email, "Your new account with Vanilla", $user->names, $rdata, 'emails.new_account');

                return redirect()->route('account.index')->withMessage("New account setup completed. Email sent to {$user->email}.");

            }else{
                if(!$user->active){
                    //send email to user with access to new role
                    $rdata = [
                        'user'=>$user,
                        'role'=>$role
                    ];

                    $this->sendMail('', "Vanilla Account Invite", $user->email, "Your new account with Vanilla", $user->names, $rdata, 'emails.new_account');

                    return redirect()->route('account.index')->withMessage("New account setup completed. Email sent to {$user->email}.");
                }
            }
            return back()->withErrors(['Account is already existing and is active.'])->withInput();
        }
        return back()->withErrors(['Could not complete. Resource not found']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $uuid)
    {
        $user = $request->user();
        if($user->uuid !== $uuid){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        return view('pages.users.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::whereUuid($id)->first();
        if(!empty($user)){
            return view('pages.users.edit')->with(['user'=>$user]);
        }

        return back()->withErrors(['Resource not found']);
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
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
//            'email'=>'required',
        ]);

        $user = User::whereUuid($id)->first();
        if(!empty($user)){
            $dt['first_name'] = $request->input('first_name');
            $dt['last_name'] = $request->input('last_name');
            DB::beginTransaction();
            $user->update($dt);
            DB::commit();
            return back()->withMessage("Account updated successfully.");
        }

        return back()->withErrors(['Resource not found']);
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

    public function complete($t, $r){
        $user = User::where('token', $t)->where('active',false)->first();
        if(!empty($user)){
            $role = Role::where('uuid', $r)->first();
            if(!empty($role)){
                return view('auth.account')->with([
                    'user'=>$user,
                    'role'=>$role
                ]);
            }
        }

        return redirect()->route('login')->withMessage("Failed to process request. Retry from admin.");
    }

    public function completeAccount(Request $request, $t, $r){
        $request->validate([
            'password'=>'required',
            'confirm_password'=>'required',
        ]);

        $user = User::where('token', $t)->first();
        if(!empty($user)){
            $role = Role::where('uuid', $r)->first();
            if(!empty($role)){

                $pass1 = $request->input('password');
                $pass2 = $request->input('confirm_password');
                if($pass1!==$pass2){
                    return back()->withErrors(['Password does not match. Try again.'])->withInput();
                }

                $data['password'] = bcrypt($pass1);
                $data['active'] = true;
                $data['email_verified_at'] = now();
                $res = $this->service->addToRole($user->uuid, $role->uuid);
                if($res[0]){
                    DB::beginTransaction();
                    $user->update($data);
                    DB::commit();

                    return redirect()->route('login')->withMessage($res[1]);
                }else{
                    return redirect()->route('login')->withErrors([$res[1]]);
                }
            }
        }

        return redirect()->route('login')->withMessage("Failed to process request. Retry from admin.");
    }
}

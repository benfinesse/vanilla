<?php

use App\User;
use App\Models\Role;
use App\Models\RoleMember;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    use \App\Traits\General\Utility, \App\Traits\General\RoleList;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create([
            'email' => 'benjamin@finesseintegrated.com',
        ]);

        $user = User::where('email', 'benjamin@finesseintegrated.com')->first();
        if(!empty($user)){
            //create super admin role
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $user->uuid;
            $data['title'] = "Super Admin";
            $perms = $this->permissions();
            foreach ($perms as $perm){
                $data[$perm] = true;
            }
            $data['active'] = true;
            $role = Role::create($data);

            //add user to role
            $member['uuid'] = $this->makeUuid();
            $member['user_id'] = $user->uuid;
            $member['role_id'] = $role->uuid;
            RoleMember::create($member);

        }
    }
}

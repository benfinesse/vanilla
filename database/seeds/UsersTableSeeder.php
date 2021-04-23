<?php

use App\User;
use App\Models\Role;
use App\Models\RoleMember;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    use \App\Traits\General\Utility;
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
            $data['create_user'] = true;
            $data['edit_user'] = true;
            $data['delete_user'] = true;
            $data['create_role'] = true;
            $data['edit_role'] = true;
            $data['delete_role'] = true;
            $data['create_record'] = true;
            $data['edit_record'] = true;
            $data['delete_record'] = true;
            $data['create_group'] = true;
            $data['edit_group'] = true;
            $data['delete_group'] = true;
            $data['create_process'] = true;
            $data['edit_process'] = true;
            $data['delete_process'] = true;
            $data['create_measure'] = true;
            $data['edit_measure'] = true;
            $data['delete_measure'] = true;
            $data['create_office'] = true;
            $data['edit_office'] = true;
            $data['delete_office'] = true;
            $data['modify_office_member'] = true;
            $data['view_processes'] = true;
            $data['view_groups'] = true;
            $data['view_measure'] = true;
            $data['view_users'] = true;
            $data['view_roles'] = true;
            $data['administration'] = true;
            $data['settings'] = true;
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

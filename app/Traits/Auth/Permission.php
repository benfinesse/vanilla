<?php

namespace App\Traits\Auth;
use App\Models\Role;
use App\Models\RoleMember;
use App\Traits\General\RoleList;
use Illuminate\Database\Query\Builder;


trait Permission{
    use AuthTrait, RoleList;

    public function hasAccess($action){
        $access = $this->loggedInUser()->roles->where('active', true)->where($this->action($action), true)->first();
        return !empty($access)?true:false;
    }

    public function action($act){
        switch ($act){
            case 'settings':
                return 'settings';
                break;
            case 'admin':
                return 'administration';
                break;
            case 'procurement':
                return 'procurement';
                break;
            case 'records':
                return 'create_record';
                break;
            case 'processes':
                return 'create_process';
                break;
            case 'measures':
                return 'create_measure';
                break;
            case 'products':
                return 'create_product';
                break;
            case 'groups':
                return 'view_groups';
                break;
            case 'users':
                return 'view_users';
                break;
            case 'roles':
                return 'view_roles';
                break;
            default:
                return '';
        }
    }

    public function getIsSuperAdminAttribute(){
        $id = $this->loggedInUser()->uuid;
        $perms = $this->permissions();
        $query = Role::query();
        $query->whereIn('roles.uuid', function (Builder $q) use ($id) {
            $q->select('role_members.role_id')
                ->from('role_members')
                ->where('user_id', $id);
        });
        foreach ($perms as $perm){
            $query->where($perm,true);
        }
        $role = $query->first();
        return !empty($role)?true:false;

    }

}
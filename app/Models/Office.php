<?php

namespace App\Models;

use App\Traits\Auth\AuthTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Office extends Model
{
    use AuthTrait;
    protected $fillable = [
        'uuid',
        'user_id',
        'process_id',
        'name',
        'position',
        'active',
        'verifiable',
        'approvable'
    ];

    public function getMembersAttribute(){
        $uuid = $this->uuid;
        return User::query()
            ->whereIn('users.uuid', function (Builder $query) use($uuid){
                $query->from('office_members')
                    ->select('office_members.user_id')
                    ->where('office_members.office_id', $uuid);
            })->get();
    }

    public function process(){
        return $this->belongsTo(OfficeProcess::class, 'process_id', 'uuid');
    }

    public function getIsMemberAttribute(){
        $user = $this->loggedInUser();
        $member = OfficeMember::where('user_id', $user->uuid)->where('office_id', $this->uuid)->first();
        return !empty($member)?true:false;
    }
}

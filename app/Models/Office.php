<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Office extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'process_id',
        'name',
        'position',
        'active',
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
}

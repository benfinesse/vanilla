<?php

use App\Models\Group;
use App\User;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            "Bar",
            "Kitchen",
        ];
        $user = User::first();
        foreach ($items as $item){
            factory(Group::class, 1)->create(['name' => $item,'user_id'=>$user->uuid]);
        }
    }
}

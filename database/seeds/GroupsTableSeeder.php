<?php

use App\Models\Group;
use App\Models\Product;
use App\User;
use Illuminate\Database\Seeder;
use App\Traits\General\Utility;

class GroupsTableSeeder extends Seeder
{
    use Utility;
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

        $groups = Group::get();
        foreach ($groups as $group){
            $sets['bar']=[
                'vodka',
                'chapman',
                'don simon',
            ];
            $sets['kitchen']=[
                'maggi',
                'garri',
                'rice',
            ];
            foreach ($sets[strtolower($group->name)] as $name){
                Product::create(['name'=>$name, 'group_id'=>$group->uuid, 'user_id'=> $user->uuid, 'uuid'=>$this->makeUuid()]);
            }
        }
    }
}

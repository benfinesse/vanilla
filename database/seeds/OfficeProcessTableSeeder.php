<?php

use App\Models\OfficeProcess;
use App\Models\Office;
use App\User;
use Illuminate\Database\Seeder;

class OfficeProcessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            "CEO",
            "Manager",
            "Accountant",
            "Procurement",
        ];
        $user = User::first();
        factory(OfficeProcess::class, 1)->create(['name' => "Re-Stock Process",'user_id'=>$user->uuid]);
        $process = OfficeProcess::first();
        $pos = 0;
        foreach ($items as $item){
            $pos++;
            factory(Office::class, 1)->create(
                [
                    'name' => $item,
                    'user_id'=>$user->uuid,
                    'process_id'=>$process->uuid,
                    'position'=>$pos,
                ]);
        }
    }
}

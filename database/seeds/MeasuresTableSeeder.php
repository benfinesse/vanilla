<?php

use App\Models\Measure;
use Illuminate\Database\Seeder;

class MeasuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measures = [
            "pieces",
            "liters",
            "carton",
            "crate",
        ];
        $user = \App\User::first();
        foreach ($measures as $measure){
            factory(Measure::class, 1)->create(['name' => $measure,'user_id'=>$user->uuid]);
        }
    }
}

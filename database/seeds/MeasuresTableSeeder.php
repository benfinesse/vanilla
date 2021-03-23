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
        foreach ($measures as $measure){
            factory(Measure::class, 1)->create(['name' => $measure,]);
        }
    }
}

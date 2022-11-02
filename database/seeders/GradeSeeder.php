<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        School::get()->each(function ($item, $key) {
            // for ($i = 1; $i <= 10; $i++) {
            Grade::create(['name' => 1, 'school_id' => $item->id]);
            Grade::create(['name' => 2, 'school_id' => $item->id]);
            Grade::create(['name' => 3, 'school_id' => $item->id]);
            Grade::create(['name' => 4, 'school_id' => $item->id]);
            Grade::create(['name' => 5, 'school_id' => $item->id]);
            // }
        });
    }
}

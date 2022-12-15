<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CycleSeeder extends Seeder
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
            Cycle::create(['name' => 1, 'school_id' => $item->id, 'grade' => 1, 'is_active' => true]);
            Cycle::create(['name' => 2, 'school_id' => $item->id, 'grade' => 1, 'is_active' => true]);
            Cycle::create(['name' => 3, 'school_id' => $item->id, 'grade' => 2, 'is_active' => true]);
            Cycle::create(['name' => 4, 'school_id' => $item->id, 'grade' => 2, 'is_active' => true]);
            Cycle::create(['name' => 5, 'school_id' => $item->id, 'grade' => 3, 'is_active' => true]);
            Cycle::create(['name' => 6, 'school_id' => $item->id, 'grade' => 3, 'is_active' => true]);
            Cycle::create(['name' => 7, 'school_id' => $item->id, 'grade' => 4, 'is_active' => true]);
            Cycle::create(['name' => 8, 'school_id' => $item->id, 'grade' => 4, 'is_active' => true]);
            Cycle::create(['name' => 9, 'school_id' => $item->id, 'grade' => 5, 'is_active' => true]);
            Cycle::create(['name' => 10, 'school_id' => $item->id, 'grade' => 5, 'is_active' => true]);
            // }
        });
    }
}

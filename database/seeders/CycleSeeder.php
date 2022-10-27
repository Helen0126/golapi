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
            for ($i = 1; $i <= 10; $i++) {
                Cycle::create(['name' => $i, 'school_id' => $item->id]);
            }
        });
    }
}

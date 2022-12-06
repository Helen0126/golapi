<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // FIA
        School::create(['name' => 'E.P de Ingeniera de Sistemas']);
        School::create(['name' => 'E.P de Ingeniera Ambiental']);
        School::create(['name' => 'E.P de Arquitectura']);
    }
}

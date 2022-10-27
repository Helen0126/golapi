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
        School::create(['name' => 'Escuela de Ingeniera de Sistemas']);
        School::create(['name' => 'Escuela de Arquitectura']);
        School::create(['name' => 'Escuela de Ingeniera Ambiental']);
    }
}

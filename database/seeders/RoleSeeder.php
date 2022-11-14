<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => Role::ADMINISTRADOR]);
        Role::create(['name' => Role::CAPELLAN]);
        Role::create(['name' => Role::TUTOR]);
        Role::create(['name' => Role::PSICOLOGIA]);
        Role::create(['name' => Role::ESTUDIANTE]);
        Role::create(['name' => Role::LIDER]);
    }
}

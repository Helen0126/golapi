<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::factory()->count(100)->create();
    }
}

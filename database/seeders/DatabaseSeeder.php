<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TypeSeeder::class,
            RoleSeeder::class,
            SchoolSeeder::class,
            CycleSeeder::class,
            PersonSeeder::class,
            StudentSeeder::class,
            TutorSeeder::class,

        ]);

        // if (App::environment('local')) {
        //     $this->call(FakeDataSeeder::class);
        // }
    }
}

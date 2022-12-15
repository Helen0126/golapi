<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App;
use App\Models\Gol;
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
            GolSeeder::class,
            FakeDataSeeder::class,

        ]);

        // if (App::environment('local')) {
        //     $this->call(FakeDataSeeder::class);
        // }
    }
}

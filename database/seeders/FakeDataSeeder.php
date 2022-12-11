<?php

namespace Database\Seeders;

use App\Models\Gol;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gol::create(
            [
                'name' => 'xdxd',
                'motto' => 'xdxd',
                'verse' => 'xdxd',
                'chant' => 'xdxd',
                'cycle_id' => 6,
            ]
        );

        $week  = Week::create([
            'event_date' => Carbon::parse(now())->next(Carbon::FRIDAY),
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $week->topics()->create(['name' => 'xdxd', 'grade' => $i, 'is_active' => true]);
        }
    }
}

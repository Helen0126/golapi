<?php

namespace Database\Seeders;

use App\Models\Cycle;
use App\Models\Event;
use App\Models\Gol;
use App\Models\Type;
use App\Models\Week;
use Arr;
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
        $week1  = Week::create([
            'event_date' => '2022-12-02',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $week1->topics()->create(['name' => 'Tema de Semana 1', 'grade' => $i, 'is_active' => true]);
        }

        $week  = Week::create([
            'event_date' => '2022-12-09',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $week->topics()->create(['name' => 'Tema de Semana 2', 'grade' => $i, 'is_active' => true]);
        }

        $topic1 = $week1->topics->where('grade', '=', '3')->first();
        $event1 = Event::create([
            'name' => 'Evento 1',
            'gol_id' => 3,
            'topic_id' => $topic1->id,
            'start_at' => '08:00',
            'end_at' => '20:00',
            'programmed_at' => '2022-12-02',
            'status' => 'F',
        ]);

        $students = Cycle::find(6)->people()->whereTypeId(Type::ESTUDIANTE)->get();
        foreach ($students as $student) {
            $event1->people()->attach($student->id, ['present' => Arr::random([true, false])]);
        }
        $topic2 = $week->topics->where('grade', '=', '3')->first();
        $event2 = Event::create([
            'name' => 'Evento 2',
            'gol_id' => 3,
            'topic_id' => $topic2->id,
            'start_at' => '08:00',
            'end_at' => '20:00',
            'programmed_at' => '2022-12-09',
            'status' => 'F',
        ]);
        foreach ($students as $student) {
            $event2->people()->attach($student->id, ['present' => Arr::random([true, false])]);
        }
    }
}

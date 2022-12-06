<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ApiController;
use App\Models\Event;
use App\Models\Person;
use App\Models\Type;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class EventPersonController extends ApiController
{

    public function index()
    {
        $cycle = Auth::user()->person->cycle;
        $nextViernes = Carbon::parse(now())->next(Carbon::FRIDAY);
        $event = Event::with('people')->whereProgrammedAt($nextViernes)->whereGolId($cycle->gol->id)->first();
        return $event;
    }

    public function store()
    {
        $cycle = Auth::user()->person->cycle;
        $nextViernes = Carbon::parse(now())->next(Carbon::FRIDAY);
        $event = Event::whereProgrammedAt($nextViernes)->whereGolId($cycle->gol->id)->first();
        $students = Person::whereTypeId(Type::ESTUDIANTE)->whereCycleId($cycle->id)->get();

        if (!$event) {
            return $this->respondError("No hay evento :/.");
        }

        return DB::transaction(function () use ($students, $event) {
            foreach ($students as $student) {
                $event->people()->attach($student->id, ['present' => false]);
            }

            return $this->respondCreated("Alumnos registrados correctamente.");
        });
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

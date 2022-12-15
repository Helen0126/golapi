<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ApiController;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Person;
use App\Models\Role;
use App\Models\Topic;
use App\Models\Type;
use App\Models\User;
use App\Models\Week;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class EventController extends ApiController
{

    public function index()
    {
        if (Auth::user()->hasRole(Role::ADMINISTRADOR)) {
            return $this->respondWithResourceCollection(EventResource::collection(Event::with('topic')->get()));
        } else {
            return $this->respondWithResourceCollection(
                EventResource::collection(Event::with('topic')->whereGolId(Auth::user()->person->cycle->gol->id)->get())
            );
        }
    }

    public function store(EventStoreRequest $request)
    {
        $cycle = Auth::user()->person->cycle;
        $nextViernes = Carbon::parse(now())->next(Carbon::FRIDAY);
        $event = Event::whereProgrammedAt($nextViernes)->whereGolId($cycle->gol->id)->first();
        $week = Week::whereDate('event_date', '=', $nextViernes)->first();
        $topic = $week->topics()->whereGrade($cycle->grade)->where('is_active', '=', true)->first();

        if ($event) {
            return $this->respondError("El evento para esta semana ya ha sido registrado.");
        }

        if (!$week) {
            return $this->respondError("No se configuro temas para esta semana. Espere que el capellán configure el tema.");
        }

        if (!$topic) {
            return $this->respondError("No se subio el tema correspondiente. Espere que el capellán configure el tema.");
        }
        $data = [
            'gol_id' => $cycle->gol->id,
            'status' => 'P',
            'programmed_at' => $week->event_date,
            'name' => $request->name,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ];

        return DB::transaction(function () use ($topic, $data, $request, $cycle) {

            $event = $topic->events()->create($data);
            if ($request->banner != null) {
                $event->attachMedia($request->banner);
            }
            $students = $cycle->people()->whereTypeId(Type::ESTUDIANTE)->get();
            foreach ($students as $student) {
                $event->people()->attach($student->id, ['present' => false]);
            }
            return $this->respondCreated("Evento registrado correctamente");
        });
    }

    public function finishEvent()
    {
        $cycle = Auth::user()->person->cycle;
        $nextViernes = Carbon::parse(now())->next(Carbon::FRIDAY);
        $event = Event::whereProgrammedAt($nextViernes)
            ->whereGolId($cycle->gol->id)
            ->whereStatus('P')
            ->first();

        if (!$event) {
            return $this->respondError("No hay evento :/.");
        }

        return DB::transaction(function () use ($event, $cycle) {
            $event->update(['status' => 'F']);

            // ELIMINAR USUARIO LIDER
            $user = User::role([Role::LIDER])
                ->whereRelation('person', 'cycle_id', '=', $cycle->id)
                ->whereRelation('person', 'type_id', '=', Type::ESTUDIANTE)
                ->first();

            if ($user) {
                $user->syncRoles([]);
                $user->tokens()->delete();
                $user->delete();
            }

            return $this->respondSuccess('Evento finalizado correctamente');
        });
    }

    public function update(EventStoreRequest $request, Event $event)
    {
        return DB::transaction(function () use ($request, $event) {
            $event->update($request->validated());

            if ($request->banner != null) {
                $event->detachMedia();
                $event->attachMedia($request->banner);
            }
            return $this->respondSuccess("Evento actualizado correctamente.");
        });
    }

    public function destroy(Event $event)
    {
        return DB::transaction(function () use ($event) {
            $event->detachMedia();
            $event->delete();
            return $this->respondSuccess("Evento eliminado correctamente.");
        });
    }
}

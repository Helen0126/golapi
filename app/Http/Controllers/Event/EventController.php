<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ApiController;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Role;
use App\Models\Topic;
use App\Models\Type;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class EventController extends ApiController
{

    public function index()
    {
        if (Auth::user()->hasRole(Role::ADMINISTRADOR)) {
            return $this->respondWithResourceCollection(EventResource::collection(Event::get()));
        } else {
            return $this->respondWithResourceCollection(
                EventResource::collection(Event::whereGolId(Auth::user()->person->cycle->gol->id)->get())
            );
        }
    }

    public function store(EventStoreRequest $request)
    {
        $cycle = Auth::user()->person->cycle;
        $nextViernes = Carbon::parse(now())->next(Carbon::FRIDAY);
        $event = Event::whereProgrammedAt($nextViernes)->whereGolId($cycle->gol->id)->first();

        $topic = Topic::whereGrade($cycle->grade)->where('is_active', '=', true)
            ->with(['week' => function ($query) use ($nextViernes) {
                $query->where('event_date', '=', $nextViernes);
            }])->first();

        if ($event) {
            return $this->respondError("El evento para esta semana ya ha sido registrado.");
        }

        if (!$topic) {
            return $this->respondError("No hay un tema definido para esta semana. Espere que el capellán configure el tema.");
        }
        $data = [
            'gol_id' => $cycle->gol->id,
            'status' => 'P',
            'programmed_at' => $topic->week->event_date,
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

    public function finishEvent(Event $event)
    {
        $event->update(['status' => 'F']);
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

<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ApiController;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Topic;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class EventController extends ApiController
{

    public function index()
    {
        return $this->respondWithResourceCollection(EventResource::collection(Event::get()));
    }

    public function store(Request $request)
    {
        $cycle = Auth::user()->person->cycle;
        $nextViernes = Carbon::parse(now())->next('Friday');
        $event = Event::whereProgrammedAt($nextViernes)->whereGolId($cycle->gol->id)->first();
        $topic = Topic::whereGrade($cycle->grade)->where('is_active', '=', true)
        ->with(['week' => function ($query) use ($nextViernes) {
            $query->where('event_date', '=', $nextViernes);
        }])
        ->first();

        if ($event) {
            return $this->respondError("Un evento para la fecha " . $nextViernes . " ya ha sido registrado.");
        }

        if (!$topic) {
            return $this->respondError("No hay un tema definido para esta semana. Espere que el capellán configure el tema.");
        }
        $data = [
            'gol_id' => $cycle->gol->id,
            'status' => 'P',
            'programmed_at' => $topic->week->event_date,
        ];

        return DB::transaction(function () use ($topic, $data) {

            $topic->events()->create($data);
            return $this->respondCreated("Evento registrado correctamente");
        });
    }

    public function show(Event $event)
    {
        //
    }

    public function update(Request $request, Event $event)
    {
        //
    }

    public function destroy(Event $event)
    {
        //
    }
}

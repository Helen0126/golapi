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
        $nextViernes = Carbon::parse(now())->next(Carbon::FRIDAY);
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
        $new_event = new Event();
        $new_event->gol_id = $cycle->gol->id;
        $new_event->status = 'P';
        $new_event->programmed_at = $topic->week->event_date;



        return DB::transaction(function () use ($topic, $new_event) {

            $topic->events()->setModel($new_event)->save();
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

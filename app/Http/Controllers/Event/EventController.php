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

    public function store(EventStoreRequest $request)
    {
        $cycle = Auth::user()->person->cycle;
        $nextViernes = Carbon::parse(now())->next(Carbon::FRIDAY);
        $event = Event::whereProgrammedAt($nextViernes)->whereGolId($cycle->gol->id)->first();
        if ($event) {
            return $this->respondError("Un evento para la fecha " . $nextViernes . " ya ha sido registrado.");
        }

        $topic = Topic::whereGrade($cycle->grade)->where('is_active', '=', true)
            ->with(['week' => function ($query) use ($nextViernes) {
                $query->where('event_date', '=', $nextViernes);
            }])
            ->first();

        if (!$topic) {
            return $this->respondError("No hay un tema definido para esta semana. Espere que el capellán configure el tema.");
        }



        return DB::transaction(function () use ($request, $cycle) {

            $topic = Topic::whereGrade($cycle->grade)->first();
            $topic->events()->create($request->validated());
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

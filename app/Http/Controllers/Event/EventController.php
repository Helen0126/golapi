<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\ApiController;
use App\Http\Requests\EventStoreRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Topic;
use Auth;
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
        return DB::transaction(function () use ($request)
        {
            $user_grade = Auth::user()->person->cycle->grade;
            $topic = Topic::whereGrade($user_grade)->first();
            $topic->events()->create($request->validated());
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

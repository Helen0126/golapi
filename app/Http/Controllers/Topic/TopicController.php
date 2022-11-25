<?php

namespace App\Http\Controllers\Topic;

use App\Http\Controllers\ApiController;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->update($request->validated());
        return $this->respondSuccess("Tema actualizado correctamente!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $topic->is_active = false;
        $topic->save();
        return $this->respondSuccess("Tema eliminado correctamente!");
    }
}

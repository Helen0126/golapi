<?php

namespace App\Http\Controllers\Week;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\WeekRequest;
use App\Http\Resources\WeekResource;
use App\Models\Topic;
use App\Models\Week;
use DB;
use Illuminate\Http\Request;

class WeekController extends ApiController
{

    public function index()
    {
        return $this->respondWithResourceCollection(WeekResource::collection(Week::with('topics')
            ->orderBy('event_date', 'desc')->get()));
    }

    public function store(WeekRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $week = Week::create($request->validated());

            for ($i = 1; $i <= 5; $i++) {
                $week->topics()->create(['name' => ' ', 'grade' => $i, 'is_active' => false]);
                # code...
            }

            return $this->respondCreated("Temas registrados correctamente.");
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Week  $week
     * @return \Illuminate\Http\Response
     */
    public function destroy(Week $week)
    {
        $week->delete();
        return $this->respondSuccess("Temas eliminados correctamente");
    }
}

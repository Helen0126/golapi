<?php

namespace App\Http\Controllers\Gol;

use App\Http\Controllers\ApiController;
use App\Http\Requests\GolStoreRequest;
use App\Http\Resources\GolResource;
use App\Models\Gol;
use App\Models\Role;
use Auth;
use DB;
use Illuminate\Http\Request;

class GolController extends ApiController
{

    public function index()
    {
        return $this->respondWithResourceCollection(GolResource::collection(Gol::get()));
    }

    public function store(GolStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $gol = Gol::create($request->validated());
            if ($request->photo != null) {
                $gol->attachMedia($request->photo);
            }

            if (Auth::user()->hasRole(Role::TUTOR)) {
                $tutor = Auth::user()->person;
                $gol->people()->save($tutor);
            }
            return $this->respondCreated("Gol guardado correctamente.");
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gol  $gol
     * @return \Illuminate\Http\Response
     */
    public function show(Gol $gol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gol  $gol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gol $gol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gol  $gol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gol $gol)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Gol;

use App\Http\Controllers\ApiController;
use App\Http\Requests\GolStoreRequest;
use App\Http\Requests\GolUpdateRequest;
use App\Http\Resources\GolResource;
use App\Models\Cycle;
use App\Models\Gol;
use App\Models\Role;
use Auth;
use DB;
use Illuminate\Http\Request;

class GolController extends ApiController
{

    public function index()
    {
        return $this->respondWithResourceCollection(GolResource::collection(Gol::with('cycle')->get()));
    }

    public function store(GolStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $gol = Gol::create($request->validated());
            if ($request->photo != null) {
                $gol->attachMedia($request->photo);
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

    public function update(GolUpdateRequest $request, Gol $gol)
    {
        return DB::transaction(function () use ($request, $gol) {
            $gol->update($request->validated());

            if ($request->photo != null) {
                $gol->detachMedia();
                $gol->attachMedia($request->photo);
            }
            return $this->respondSuccess("Gol actualizado correctamente.");
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gol  $gol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gol $gol)
    {
        if ($gol->events) {
            return $this->respondError("Este gol tiene eventos relacionados.");
        }

        $gol->detachMedia();
        $gol->delete();
        return $this->respondSuccess("Gol eliminado correctamente");
    }
}

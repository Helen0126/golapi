<?php

namespace App\Http\Controllers\Student;

use DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Cycle;
use Illuminate\Http\Request;
use App\Actions\SaveUserFromPerson;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Requests\TutorStoreRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use App\Models\Type;

class StudentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentCollection = Person::with('cycle.school', 'cycle.gol')->whereRelation('type', 'id', '=', Type::ESTUDIANTE)->get();
        return $this->respondWithResourceCollection(PersonResource::collection($studentCollection));
    }


    public function store(TutorStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $cycle = Cycle::whereName($request->cycle)->whereSchoolId($request->school_id)->first();
            $person = $cycle->people()->create($request->validated());
            // $user = SaveUserFromPerson::make()->handle($person, false);
            // $user->assignRole(Role::ESTUDIANTE);
            return $this->respondCreated('OK!');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    public function update(StudentUpdateRequest $request, int $id)
    {
        $alumno = Person::findOrFail($id);
        $alumno->update($request->validated());
        return $this->respondSuccess("Alumno actualizado correctamente!");
    }

    public function destroy(int $id)
    {
        $person = Person::findOrFail($id);
        if ($person->user) {
            return $this->respondError("Este alumno tiene un usuario relacionado.");
        }

        $person->delete();
        return $this->respondSuccess("Alumno eliminado correctamente.");
    }
}

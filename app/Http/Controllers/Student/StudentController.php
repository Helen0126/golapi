<?php

namespace App\Http\Controllers\Student;

use App\Actions\SaveUserFromPerson;
use DB;
use App\Models\User;
use App\Models\Cycle;
use App\Http\Controllers\ApiController;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use App\Models\Role;
use App\Models\School;
use App\Models\Type;
use Auth;

class StudentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studentCollection = null;
        if (Auth::user()->hasRole([Role::ADMINISTRADOR, Role::CAPELLAN])) {
            $studentCollection = Person::with('cycle.school', 'cycle.gol', 'user')->whereRelation('type', 'id', '=', Type::ESTUDIANTE)->get();
        } else {
            $studentCollection = Person::with('cycle.school', 'cycle.gol', 'user')
                ->whereRelation('type', 'id', '=', Type::ESTUDIANTE)
                ->whereRelation('cycle', 'id', '=', Auth::user()->person->cycle_id)
                ->get();
        }
        return $this->respondWithResourceCollection(PersonResource::collection($studentCollection));
    }


    public function store(StudentStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $cycle = Cycle::whereName($request->cycle)->whereSchoolId($request->school_id)->first();
            $person = $cycle->people()->create($request->validated());
            // $user = SaveUserFromPerson::make()->handle($person, false);
            // $user->assignRole(Role::ESTUDIANTE);
            return $this->respondCreated('Alumno registrado correctamente');
        });
    }

    public function setLider(Person $person)
    {
        $user = SaveUserFromPerson::make()->handle($person, true);
        $user->syncRoles([Role::LIDER]);
        return $this->respondSuccess('Lider asignado correctamente');
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

    public function show(int $id)
    {
        $student = Person::whereCode($id)->first();
        if (!$student) {
            return $this->respondError("No se encontro al estudiante.");
        }
        return $this->respondWithResource(new PersonResource($student), "Estudiante encontrado.");
    }
}

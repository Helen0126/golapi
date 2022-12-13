<?php

namespace App\Http\Controllers\Tutor;

use App\Actions\SaveUserFromPerson;
use App\Http\Controllers\ApiController;
use App\Http\Requests\TutorStoreRequest;
use App\Http\Requests\TutorUpdateRequest;
use App\Http\Resources\PersonResource;
use App\Http\Resources\UserResource;
use App\Models\Cycle;
use App\Models\Person;
use App\Models\Role;
use App\Models\Type;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class TutorController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutorCollection = Person::with('cycle.school', 'cycle.gol')->whereRelation('type', 'id', '=', Type::TUTOR)->get();
        return $this->respondWithResourceCollection(PersonResource::collection($tutorCollection));
    }


    public function store(TutorStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $cycle = Cycle::whereName($request->cycle)->whereSchoolId($request->school_id)->first();
            $person = $cycle->people()->create($request->validated());

            if ($cycle->is_active) {
                $user = SaveUserFromPerson::make()->handle($person, true);
                $user->assignRole(Role::TUTOR);
            }

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


    public function update(TutorUpdateRequest $request, int $id)
    {
        $tutor = Person::findOrFail($id);
        $tutor->update($request->validated());
        return $this->respondSuccess("Tutor Actualizado correctamente!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $person = Person::findOrFail($id);
        if ($person->user) {
            $person->user->delete();
        }

        if ($person->events->contains($person->id)) {
            return $this->respondError("El tutor tiene eventos asociados.");
        }

        $person->delete();
        return $this->respondSuccess("Tutor eliminado correctamente.");


        // $user = User::findOrFail($id);
        // $user->person()->dissociate();
        // return $user->delete();
    }
}

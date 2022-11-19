<?php

namespace App\Http\Controllers\Tutor;

use DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Cycle;
use Illuminate\Http\Request;
use App\Actions\SaveUserFromPerson;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ApiController;
use App\Http\Requests\TutorStoreRequest;

class StudentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithResourceCollection(UserResource::collection(User::role(Role::ESTUDIANTE)->with('person.cycle')->get()));
    }


    public function store(TutorStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $cycle = Cycle::whereName($request->cycle)->whereSchoolId($request->school_id)->first();
            $person = $cycle->people()->create($request->validated());
            $user = SaveUserFromPerson::make()->handle($person, false);
            $user->assignRole(Role::ESTUDIANTE);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // $user = User::findOrFail($id);
        // $user->person()->dissociate();
        // return $user->delete();
    }
}

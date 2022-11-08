<?php

namespace App\Http\Controllers\Tutor;

use App\Actions\SaveUserFromPerson;
use App\Http\Controllers\ApiController;
use App\Http\Requests\TutorStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\Grade;
use App\Models\Person;
use App\Models\School;
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
        return $this->respondWithResourceCollection(UserResource::collection(User::role('Tutor')->with('person.grade')->get()));
    }


    public function store(TutorStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $grade = Grade::whereName($request->grade_name)->whereSchoolId($request->school_id)->first();
            $person = $grade->people()->create($request->validated());
            $user = SaveUserFromPerson::make()->handle($person);
            $user->assignRole('Tutor');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

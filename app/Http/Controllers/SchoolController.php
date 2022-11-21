<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolResource;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends ApiController
{

    public function index()
    {
        return $this->respondWithResourceCollection(SchoolResource::collection(School::with('cycles')->get()), "Lista de escuelas");
    }
}

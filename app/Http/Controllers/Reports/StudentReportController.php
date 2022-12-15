<?php

namespace App\Http\Controllers\Reports;

use App;
use App\Http\Controllers\ApiController;
use App\Models\Person;
use App\Models\Type;
use Illuminate\Http\Request;

class StudentReportController extends ApiController
{

    public function __invoke(Request $request, Person $person)
    {
        $student = $person->load('cycle.school', 'user', 'events');

        if (!$student) {
            return $this->respondError('No existe este estudiante.!');
        }

        if ($student->type_id != Type::ESTUDIANTE) {
            return $this->respondError('Esta persona no es un estudiante.!');
        }

        if (!$student->cycle->gol) {
            return $this->respondError('Este alumno no tiene GOL.!');
        }

        $pdf = app('dompdf.wrapper')->loadView('studentreport', ['student' => $student]);
        return $pdf->download($student->code . '-' . $student->cycle->gol->name . '.pdf');
    }
}

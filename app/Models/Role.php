<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    const ADMINISTRADOR = "Administrador";
    const CAPELLAN = "Capellán";
    const TUTOR = "Tutor";
    const ESTUDIANTE = "Estudiante";
    const LIDER = "Lider de Grupo";
    const PSICOLOGIA = "Area de Psicología";
}

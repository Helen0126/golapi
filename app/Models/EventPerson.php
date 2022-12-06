<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventPerson extends Pivot
{

    protected $casts = [
        'present' => 'boolean'
    ];
}

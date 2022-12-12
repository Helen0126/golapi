<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventPerson extends Pivot
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['present'];

    protected $casts = [
        'present' => 'boolean'
    ];
}

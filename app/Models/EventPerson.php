<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventPerson extends Pivot
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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

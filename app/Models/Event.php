<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function gol()
    {
        return $this->belongsTo(Gol::class);
    }

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }
}

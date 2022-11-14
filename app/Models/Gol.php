<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gol extends Model
{
    use HasFactory;

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function people()
    {
        return $this->hasMany(Person::class);
    }
}

<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gol extends Model
{
    use HasFactory, MediaAlly;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'motto', 'chant', 'verse', 'cycle_id'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // public function people()
    // {
    //     return $this->hasMany(Person::class);
    // }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function getPhoto(): string
    {
        return $this->fetchFirstMedia()->file_url ?? "";
    }
}

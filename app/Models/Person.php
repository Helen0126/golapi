<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Str;
use Znck\Eloquent\Traits\BelongsToThrough;

class Person extends Model
{
    use HasFactory, BelongsToThrough;

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
    protected $fillable = ['names', 'last_names', 'code', 'email', 'phone', 'type_id', 'gender'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class)->withDefault();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->withPivot(['present'])->using(EventPerson::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function getFirstNameAndLastNameBy(string $dotOrPlus)
    {
        $first_name = Str::of(Str::lower(trim($this->names)))->explode(' ')[0];
        $last_name  = Str::of(Str::lower(trim($this->last_names)))->explode(' ')[0];

        return $first_name . $dotOrPlus . $last_name;
    }
}

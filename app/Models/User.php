<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 *
 * @OA\Schema(
 *     title="Usuario",
 *     description="",
 *     required={"name", "password"},
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 * @OA\Property(
 *     property="name",
 *     title="name",
 *     description="Nombre de usuario",
 *     type="string",
 *     default="206461532"
 * )
 * @OA\Property(
 *     property="password",
 *     title="password",
 *     description="Contraseña",
 *     type="password",
 *     default=""
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, MediaAlly, HasRoles;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}

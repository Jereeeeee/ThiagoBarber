<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Normalizar el nombre del usuario al guardar.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: function (mixed $value): string {
                $name = trim((string) $value);

                if ($name === '') {
                    return '';
                }

                $lowercaseName = mb_strtolower($name, 'UTF-8');
                $firstLetter = mb_strtoupper(mb_substr($lowercaseName, 0, 1, 'UTF-8'), 'UTF-8');

                return $firstLetter.mb_substr($lowercaseName, 1, null, 'UTF-8');
            }
        );
    }

    /**
     * Obtener los cursos comprados por este usuario.
     */
    public function cursos(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'cursos_usuario', 'user_id', 'curso_id')
            ->withTimestamps();
    }

    /**
     * Obtener el rol asignado al usuario.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}

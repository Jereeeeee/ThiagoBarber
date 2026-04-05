<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curso extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'cursos';

    /**
     * Los atributos asignables masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'level',
        'price',
        'is_active',
    ];

    /**
     * Obtener los usuarios que compraron este curso.
     */
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cursos_usuario', 'curso_id', 'user_id')
            ->withTimestamps();
    }
}
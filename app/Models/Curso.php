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
        'titulo',
        'slug',
        'descripcion',
        'imagen_path',
        'imagen',
        'image_path',
        'precio',
        'is_active',
    ];

    /**
     * Convertir atributos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Obtener los usuarios que compraron este curso.
     */
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cursos_usuario', 'curso_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Compatibilidad: exponer imagen_path aunque la columna legacy sea `imagen`.
     */
    public function getImagenPathAttribute($value): ?string
    {
        if (is_string($value) && $value !== '') {
            return $value;
        }

        $legacy = $this->attributes['imagen'] ?? null;

        if (is_string($legacy) && $legacy !== '') {
            return $legacy;
        }

        $english = $this->attributes['image_path'] ?? null;

        return is_string($english) && $english !== '' ? $english : null;
    }

    /**
     * Compatibilidad: asumir activo cuando no exista/traiga null en esquemas antiguos.
     */
    public function getIsActiveAttribute($value): bool
    {
        if ($value === null) {
            return true;
        }

        return (bool) $value;
    }
}
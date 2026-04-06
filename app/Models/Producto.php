<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    /**
     * Los atributos asignables masivamente.
     *
     * @var list<string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'etiqueta',
        'precio',
        'imagen_path',
    ];
}

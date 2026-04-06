<?php

namespace Database\Seeders;

use App\Models\Corte;
use Illuminate\Database\Seeder;

class CorteSeeder extends Seeder
{
    /**
     * Ejecutar los datos iniciales de cortes.
     */
    public function run(): void
    {
        $cortes = [
            'Fade Clasico',
            'Low Fade',
            'Mid Fade',
            'High Fade',
            'Crop Texturizado',
            'Pompadour',
            'Mullet Moderno',
            'Buzz Cut',
            'Taper Fade',
        ];

        foreach ($cortes as $titulo) {
            Corte::query()->updateOrCreate(
                ['titulo' => $titulo],
                ['imagen_path' => 'images/placeholder-card.svg']
            );
        }
    }
}
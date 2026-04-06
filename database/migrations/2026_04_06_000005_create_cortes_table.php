<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migracion.
     */
    public function up(): void
    {
        Schema::create('cortes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->comment('Nombre comercial del corte de pelo');
            $table->string('imagen_path')->comment('Ruta relativa de la imagen del corte');
            $table->timestamps();
        });
    }

    /**
     * Revertir la migracion.
     */
    public function down(): void
    {
        Schema::dropIfExists('cortes');
    }
};
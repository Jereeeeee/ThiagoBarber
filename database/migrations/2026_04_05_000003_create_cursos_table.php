<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->comment('Nombre comercial del curso de barbería');
            $table->string('slug')->unique()->comment('Identificador de URL único basado en el título');
            $table->string('descripcion')->nullable()->comment('Descripción detallada del curso');
            $table->decimal('precio', 10, 2)->nullable()->comment('Precio en CLP (pesos chilenos)');
            $table->boolean('is_active')->default(true)->comment('0: Oculto, 1: Visible en la web');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
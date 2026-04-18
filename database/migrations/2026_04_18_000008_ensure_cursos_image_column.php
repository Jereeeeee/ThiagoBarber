<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('cursos')) {
            return;
        }

        if (! Schema::hasColumn('cursos', 'imagen_path')) {
            Schema::table('cursos', function (Blueprint $table): void {
                $table->string('imagen_path')->nullable()->after('descripcion');
            });
        }

        // Backfill from legacy columns if they exist.
        if (Schema::hasColumn('cursos', 'imagen') && Schema::hasColumn('cursos', 'imagen_path')) {
            DB::statement("UPDATE cursos SET imagen_path = imagen WHERE (imagen_path IS NULL OR imagen_path = '') AND imagen IS NOT NULL AND imagen <> ''");
        }

        if (Schema::hasColumn('cursos', 'image_path') && Schema::hasColumn('cursos', 'imagen_path')) {
            DB::statement("UPDATE cursos SET imagen_path = image_path WHERE (imagen_path IS NULL OR imagen_path = '') AND image_path IS NOT NULL AND image_path <> ''");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('cursos')) {
            return;
        }

        if (Schema::hasColumn('cursos', 'imagen_path')) {
            Schema::table('cursos', function (Blueprint $table): void {
                $table->dropColumn('imagen_path');
            });
        }
    }
};

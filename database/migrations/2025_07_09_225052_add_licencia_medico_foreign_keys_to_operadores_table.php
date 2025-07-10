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
        Schema::table('operadores', function (Blueprint $table) {

            $table->foreignId('licencia_id')
                  ->nullable()
                  ->constrained('licencias')
                  ->onDelete('set null')
                  ->after('nolicencia'); // O la columna anterior que desees

            $table->foreignId('medico_id')
                  ->nullable()
                  ->constrained('medicos')
                  ->onDelete('set null')
                  ->after('nomedico'); // O la columna anterior que desees

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operadores', function (Blueprint $table) {
            $table->dropForeign(['licencia_id']);
            $table->dropColumn('licencia_id'); // Elimina la columna licencia_id

            $table->dropForeign(['medico_id']);
            $table->dropColumn('medico_id'); // Elimina la columna medico_id
        });
    }
};

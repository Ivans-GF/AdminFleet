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
        Schema::create('operadores', function (Blueprint $table) {
            $table->id();
            $table->string('curp', 18)->unique();
            $table->string('rfc', 13)->unique();
            $table->string('nss', 12)->unique();
            // Columnas de texto para nombre y apellido.
            $table->string('nombre');
            $table->string('apellido');
            $table->string('telefono', 45);
            $table->string('domicilio', 450)->nullable();
            $table->date('fechanacimiento');
            $table->string('nota', 650)->nullable();
            // Columna para el estado, tipo entero con un valor predeterminado de 1.
            $table->integer('estado')->default(1);
            $table->string('nolicencia', 15);
            $table->integer('noexpediente')->nullable();
            $table->integer('documentosestatus')->nullable();
            // Columnas para los IDs de usuario que crearon y actualizaron el registro.
            // Si estos son claves foráneas a una tabla de `users`,
            $table->foreignId('created_iduser')->constrained('users')->onDelete('set null'); // Make sure this column is nullable if using set null
            $table->foreignId('updated_iduser')->nullable()->constrained('users')->onDelete('set null');
            // Columnas `created_at` y `updated_at` (timestamps)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operadores');
    }
};

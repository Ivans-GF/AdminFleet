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
            // Define el ID auto-incrementable como clave primaria.
            // Esto equivale a `id INT NOT NULL AUTO_INCREMENT PRIMARY KEY`.
            $table->id();

            // Columna para CURP, con una longitud de 18 caracteres y un índice único.
            $table->string('curp', 18)->unique();
            // Columna para RFC, con una longitud de 13 caracteres y un índice único.
            $table->string('rfc', 13)->unique();
            // Columna para NSS, con una longitud de 12 caracteres y un índice único.
            $table->string('nss', 12)->unique();

            // Columnas de texto para nombre y apellido.
            $table->string('nombre');
            $table->string('apellido');
            // Columna para teléfono, con una longitud de 45 caracteres.
            $table->string('telefono', 45);
            // Columna para domicilio, opcional (nullable), con una longitud de 450 caracteres.
            $table->string('domicilio', 450)->nullable();
            // Columna para fecha de nacimiento (solo fecha).
            $table->date('fechanacimiento');
            // Columna para notas, opcional (nullable), con una longitud de 650 caracteres.
            $table->string('nota', 650)->nullable();

            // Columna para el estado, tipo entero con un valor predeterminado de 1.
            $table->integer('estado')->default(1);
            // Columna para el estatus, tipo entero con un valor predeterminado de 0.
            $table->integer('estatus')->default(0);

            // Columnas para los IDs de usuario que crearon y actualizaron el registro.
            // Si estos son claves foráneas a una tabla de `users`,
            // podrías considerar `$table->foreignId('created_iduser')->constrained('users');`
            // Sin embargo, basado en tu SQL, se define como INT.
            $table->integer('created_iduser');
            $table->integer('updated_iduser');

            // Columnas `created_at` y `updated_at` (timestamps)
            // Laravel las gestiona automáticamente.
            $table->timestamps();

            // Nota sobre la clave primaria compuesta:
            // Tu SQL original tenía `PRIMARY KEY (id, curp, rfc, nss)`.
            // En Laravel, `$table->id()` ya define `id` como la clave primaria auto-incrementable.
            // Generalmente, si `id` es auto-incrementable, es la única clave primaria.
            // Si realmente necesitas una clave primaria compuesta que incluya `id` y otros campos,
            // no usarías `$table->id()`, sino que definirías `id` manualmente
            // `$table->increments('id');` y luego `$table->primary(['id', 'curp', 'rfc', 'nss']);`.
            // Sin embargo, para la mayoría de los casos de uso, usar `id()` y
            // añadir índices `unique()` a `curp`, `rfc`, y `nss` es la práctica recomendada y más flexible.
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
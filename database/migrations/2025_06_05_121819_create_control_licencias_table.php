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
        Schema::create('control_licencias', function (Blueprint $table) {
            // Define el ID auto-incrementable como clave primaria.
            $table->id();

            // Columna para el ID del operador.
            // Se define como foreignId y se restringe a la tabla 'operadores'.
            // Laravel automáticamente añade el índice y la restricción de clave foránea.
            // Las acciones ON DELETE NO ACTION y ON UPDATE NO ACTION son el comportamiento predeterminado
            // de muchas bases de datos si no se especifica otra cosa.
            $table->foreignId('idoperador')->constrained('operadores');

            // Columna para el número de licencia, con una longitud de 45 caracteres.
            $table->string('numero', 45);
            // Columna para la ruta del archivo, opcional (nullable), con una longitud de 800 caracteres.
            $table->string('archivo', 800)->nullable();
            // Columna para las categorías de la licencia, con una longitud de 45 caracteres.
            $table->string('categorias', 45);
            // Columna para la fecha de vigencia de la licencia (solo fecha).
            $table->date('fechavigencia');
            // Columna para la fecha de renovación de la licencia (solo fecha).
            $table->date('fecharenovacion');

            // Columna para el estado, tipo entero con un valor predeterminado de 1.
            // Los comentarios para la columna se manejan a nivel de código o en la documentación.
            $table->integer('estado')->default(1);

            // Columnas para los IDs de usuario que crearon y actualizaron el registro.
            // Puedes considerar añadir foreignId si estos referencian una tabla de `users`.
            $table->integer('created_iduser');
            $table->integer('updated_iduser');

            // Columnas `created_at` y `updated_at` (timestamps)
            // Laravel las gestiona automáticamente, usando el tipo TIMESTAMP.
            // Tu SQL original las define como VARCHAR, pero timestamps() es la forma estándar de Laravel.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_licencias');
    }
};

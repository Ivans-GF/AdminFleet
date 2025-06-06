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
        Schema::create('licencias', function (Blueprint $table) {
            // Define el ID auto-incrementable como clave primaria.
            $table->id();
            // Columna para el ID del operador.
            // Se define como foreignId y se restringe a la tabla 'operadores'.
            // Laravel automáticamente añade el índice y la restricción de clave foránea.
            // Las acciones ON DELETE NO ACTION y ON UPDATE NO ACTION son el comportamiento predeterminado
            // de muchas bases de datos si no se especifica otra cosa.
            $table->foreignId('idoperador')->constrained('operadores');
            // Columna para la ruta del archivo, opcional (nullable), con una longitud de 800 caracteres.
            //solo PDF
            $table->string('archivo', 800)->nullable();
            $table->string('categorias', 45);
            $table->date('fechavigencia');
            $table->date('fecharenovacion');
            // Columna para el estado, tipo entero con un valor predeterminado de 1.
            // 1 Activo se mantiene el archivo
            //0 Inactivo se borra el archivo.
            $table->integer('estado')->default(1);
            $table->integer('created_iduser')->constrained('users');
            $table->integer('updated_iduser')->constrained('users');
            // Columnas `created_at` y `updated_at` (timestamps)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencias');
    }
};

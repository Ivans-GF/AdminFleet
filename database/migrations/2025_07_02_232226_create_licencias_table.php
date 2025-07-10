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
             $table->id();
               // Clave foránea para el operador. Asume que 'operadores' tiene una columna 'id'.
            // onDelete('cascade') opcional: si un operador se elimina, sus licencias también.
            $table->foreignId('operador_id')->constrained('operadores')->onDelete('cascade');
            // Columna para la ruta del archivo, opcional (nullable), con una longitud de 800 caracteres.
            $table->string('archivo', 800)->nullable();
            $table->string('categoria', 45);
            $table->date('fechavigencia');
            $table->string('comentario', 450)->nullable();
            // Columna para el estado, tipo entero con un valor predeterminado de 1.
            // 1 Activo se mantiene el archivo
            //0 Inactivo se borra el archivo.
            $table->integer('estado')->default(1);
            $table->foreignId('created_iduser')->nullable()->constrained('users')->onDelete('set null');
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
        Schema::dropIfExists('licencias');
    }
};

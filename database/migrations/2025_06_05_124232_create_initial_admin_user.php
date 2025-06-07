<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\Hash; // Importa la fachada Hash

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crea un usuario por defecto.
        // Asegúrate de que tu tabla 'users' ya existe antes de ejecutar esta migración.
        // Este código asume que tu modelo User tiene las columnas 'name', 'email' y 'password'.
        User::create([
            'name' => 'Ivan Garcia Fraire', // Nombre del usuario
            'email' => 'ivans@laravel.com', // Correo electrónico único del usuario
            'password' => Hash::make('admin'), // Contraseña encriptada (¡cambia 'password' por una más segura!)
            // Puedes añadir otros campos si tu tabla 'users' los tiene, por ejemplo:
            // 'email_verified_at' => now(),
            // 'is_admin' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina el usuario creado en el método 'up()'.
        // Busca al usuario por su correo electrónico para asegurar que se elimina el correcto.
        User::where('email', 'ivans@laravel.com')->delete();
    }
};

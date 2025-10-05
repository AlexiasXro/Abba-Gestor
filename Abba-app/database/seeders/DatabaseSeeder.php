<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Talle;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Crea un usuario de prueba manualmente
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'facil@1234.com',
        //     'password' => bcrypt('1234'), // contraseña: 1234 (encriptada)
        // ]);

        // ✅ Ejecuta otros seeders que cargan datos base para el sistema
       

    $this->call([
        CategoriaConTallesSeeder::class,
    ]);
}

    
}

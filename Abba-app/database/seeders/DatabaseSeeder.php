<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Crea un usuario de prueba manualmente
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('1234'), // contraseña: 1234 (encriptada)
        ]);

        // ✅ Ejecuta otros seeders que cargan datos base para el sistema
        $this->call([
            TalleSeeder::class,     // Inserta talles como 35, 36, 37, etc.
            ProductoSeeder::class,  // Crea 5 productos y los vincula con los talles
            ClienteSeeder::class,   // Crea 5 clientes ficticios
             GastosSeeder::class,
        CierresCajaSeeder::class,
        VentasSeeder::class,
        ]);
    }
}

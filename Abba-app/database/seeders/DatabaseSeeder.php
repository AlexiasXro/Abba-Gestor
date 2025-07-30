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
            ProductoSeeder::class,  // Crea  productos y los vincula con los talles
            ClienteSeeder::class,   // Crea  clientes ficticios
             GastosSeeder::class,// Crea 20 gastos ficticios
        CierresCajaSeeder::class,// Crea 20 cierres de caja ficticios
        VentasSeeder::class,// Crea 20 ventas ficticias con productos y clientes
        ProveedorSeeder::class, // Crea 20 proveedores ficticios;

        ]);
    }
}

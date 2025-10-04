<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;
use Faker\Factory as Faker;

class ProveedorSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES'); // Para datos más locales

        $proveedores = [
            'Deportes Martínez',
            'Calzados Urbanos',
            'Ropa & Moda S.A.',
            'Zapatería Central',
            'Bazar y Hogar',
            'Tienda La Esquina',
            'Mundo Deportivo',
            'Boutique Elegant',
            'Alpargatas y Más',
            'Outlet Juvenil'
        ];

        foreach ($proveedores as $nombre) {
            Proveedor::create([
                'nombre' => $nombre,
                'cuit' => $faker->numerify('30#########'), // CUIT ficticio
                'email' => $faker->unique()->safeEmail(),
                'telefono' => $faker->phoneNumber(),
                'direccion' => $faker->address(),
                'observaciones' => $faker->optional()->sentence(),
            ]);
        }

        $this->command->info('Proveedores cargados con éxito.');
    }
}

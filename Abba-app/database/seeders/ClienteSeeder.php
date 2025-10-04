<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES'); // Datos en español

        for ($i = 0; $i < 50; $i++) {
            $nombre = $faker->firstName();
            $apellido = $faker->lastName();

            Cliente::create([
                'nombre' => $nombre,
                'apellido' => $apellido,
                'telefono' => $faker->numerify('11#########'), // Ej: 11xxxxxxxxx
                'email' => $faker->unique()->safeEmail(),
                'direccion' => $faker->address(),
            ]);
        }

        $this->command->info('Clientes simulados cargados con éxito.');
    }
}

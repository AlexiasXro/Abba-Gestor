<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gasto;
use Faker\Factory as Faker;
use Carbon\Carbon;

class GastoSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES');

        $categorias = ['Alquiler', 'Servicios', 'Compras', 'Sueldos', 'Otros'];
        $metodosPago = ['efectivo', 'tarjeta', 'transferencia'];

        // Generar 50 gastos de prueba
        for ($i = 0; $i < 50; $i++) {
            Gasto::create([
                'fecha' => $faker->dateTimeBetween('-12 months', 'now'),
                'monto' => $faker->randomFloat(2, 500, 50000),
                'descripcion' => $faker->sentence(6),
                'categoria' => $faker->randomElement($categorias),
                'metodo_pago' => $faker->randomElement($metodosPago),
                
            ]);
        }

        $this->command->info('Gastos generados sin user_id.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gasto;
use Carbon\Carbon;

class GastosSeeder extends Seeder
{
    public function run()
    {
        $categorias = ['Impuesto', 'Proveedor', 'Servicios', 'Otros'];
        $metodosPago = ['efectivo', 'transferencia', 'tarjeta'];

        for ($i = 1; $i <= 10; $i++) {
            Gasto::create([
                'fecha' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                'descripcion' => "Gasto prueba #$i",
                'monto' => rand(1000, 5000),
                'categoria' => $categorias[array_rand($categorias)],
                'metodo_pago' => $metodosPago[array_rand($metodosPago)],
                'proveedor' => 'Proveedor ' . chr(64 + $i),
            ]);
        }
    }
}

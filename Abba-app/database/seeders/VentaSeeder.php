<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\Cliente;
use Carbon\Carbon;

class VentaSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        if ($clientes->isEmpty()) {
            $this->command->info('No hay clientes para crear ventas.');
            return;
        }

        $metodosPago = ['Efectivo', 'Tarjeta', 'MercadoPago', 'Transferencia'];

        for ($i = 1; $i <= 10; $i++) {
            $cliente = $clientes->random();

            Venta::create([
                'cliente_id' => $cliente->id,
                'fecha_venta' => Carbon::now()->subDays(rand(0, 30)),
                'subtotal' => rand(1000, 5000),
                'descuento' => rand(0, 500),
                'total' => rand(1000, 5500),
                'metodo_pago' => $metodosPago[array_rand($metodosPago)],
                'notas' => 'Venta de prueba #' . $i,
            ]);
        }
    }
}

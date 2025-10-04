<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Cuota;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class VentaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_ES');

        $clientes = Cliente::all();
        $productos = Producto::all();

        if ($clientes->isEmpty() || $productos->isEmpty()) {
            $this->command->warn('No hay clientes o productos para generar ventas.');
            return;
        }

        // Generamos ventas diarias desde enero 2024 hasta hoy
        $period = CarbonPeriod::create(Carbon::create(2024, 1, 1), '1 day', Carbon::now());

        foreach ($period as $fecha) {
            // Generar entre 0 y 5 ventas por día
            $ventasHoy = rand(0, 5);

            for ($i = 0; $i < $ventasHoy; $i++) {
                $cliente = $clientes->random();
                $numProductos = rand(1, 5); // Cantidad de productos por venta
                $subtotal = 0;
                $descuento = 0;

                $venta = Venta::create([
                    'cliente_id' => $cliente->id,
                    'fecha_venta' => $fecha->toDateTimeString(),
                    'subtotal' => 0, // temporal, se actualizará después
                    'descuento' => 0,
                    'total' => 0,
                    'metodo_pago' => 'efectivo', // temporal, se actualizará
                    'monto_pagado' => 0, // temporal
                    'notas' => $faker->optional(0.2)->sentence(),
                ]);

                $ventaSubtotal = 0;

                for ($j = 0; $j < $numProductos; $j++) {
                    $producto = $productos->random();
                    $cantidad = rand(1, 3);

                    $detalle = VentaDetalle::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $producto->id,
                        'cantidad' => $cantidad,
                        'precio' => $producto->precio,
                    ]);

                    $ventaSubtotal += $producto->precio * $cantidad;
                }

                // Aplicar descuento aleatorio (0% a 10%)
                $descuento = rand(0, 10) / 100 * $ventaSubtotal;
                $total = $ventaSubtotal - $descuento;

                // Elegir método de pago aleatorio
                $metodosPago = ['efectivo', 'tarjeta', 'cuotas'];
                $metodoPago = $faker->randomElement($metodosPago);

                // Monto pagado depende del método
                if ($metodoPago === 'cuotas') {
                    $monto_pagado = rand(1, 3) * 1000; // ejemplo: entrega inicial
                } else {
                    $monto_pagado = $total;
                }

                // Actualizar la venta
                $venta->update([
                    'subtotal' => $ventaSubtotal,
                    'descuento' => $descuento,
                    'total' => $total,
                    'metodo_pago' => $metodoPago,
                    'monto_pagado' => $monto_pagado,
                ]);

                // Crear cuotas si corresponde
                if ($metodoPago === 'cuotas') {
                    $numCuotas = rand(2, 4);
                    $montoRestante = $total - $monto_pagado;
                    $montoCuota = round($montoRestante / $numCuotas, 2);

                    for ($k = 1; $k <= $numCuotas; $k++) {
                        Cuota::create([
                            'venta_id' => $venta->id,
                            'numero' => $k,
                            'monto' => $montoCuota,
                            'fecha_vencimiento' => Carbon::parse($fecha)->addMonths($k),
                            'pagada' => false,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Ventas simuladas generadas con éxito.');
    }
}

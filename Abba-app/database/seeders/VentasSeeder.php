<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Talle;
use Carbon\Carbon;

class VentasSeeder extends Seeder
{
    public function run()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $talles = Talle::all();
        $metodosPago = ['efectivo', 'cuotas', 'tarjeta'];

        for ($i = 0; $i < 10; $i++) {
            $cliente = $clientes->random();

            $randomDate = Carbon::now()
                ->subDays(rand(0, 30))
                ->setHour(rand(0, 23))
                ->setMinute(rand(0, 59))
                ->setSecond(rand(0, 59));

            $venta = Venta::create([
                'cliente_id' => $cliente->id,
                'fecha_venta' => $randomDate,
                'subtotal' => 0,
                'descuento' => 0,
                'total' => 0,
                'metodo_pago' => $metodosPago[array_rand($metodosPago)],
                'monto_pagado' => 0,
                'estado' => 'completada',
            ]);

            $subtotal = 0;

            // Agregar entre 1 y 3 productos por venta
            $numProductos = rand(1, 3);
            for ($j = 0; $j < $numProductos; $j++) {
                $producto = $productos->random();
                $talle = $talles->random();
                $cantidad = rand(1, 2);
                $precioUnitario = rand(5000, 20000);
                $descuentoDetalle = rand(0, 1000);

                $subtotalDetalle = ($precioUnitario * $cantidad) - $descuentoDetalle;
                $subtotal += $subtotalDetalle;

                VentaDetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'talle_id' => $talle->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'descuento' => $descuentoDetalle,
                    'subtotal' => $subtotalDetalle,
                ]);
            }

            // Actualizar totales en venta
            $descuentoGlobal = rand(0, 2000);
            $total = $subtotal - $descuentoGlobal;

            $venta->update([
                'subtotal' => $subtotal,
                'descuento' => $descuentoGlobal,
                'total' => $total,
                'monto_pagado' => $total, // asumimos pago completo
            ]);
        }
    }
}

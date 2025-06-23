<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Talle;
use App\Models\ProductoTalle;

class ProductoTalleSeeder extends Seeder
{
    public function run(): void
    {
        $productos = Producto::all();
        $talles = Talle::all();

        foreach ($productos as $producto) {
            foreach ($talles as $talle) {
                ProductoTalle::create([
                    'producto_id' => $producto->id,
                    'talle_id' => $talle->id,
                    'stock' => rand(1, 10), // Stock aleatorio entre 1 y 10
                ]);
            }
        }
    }
}

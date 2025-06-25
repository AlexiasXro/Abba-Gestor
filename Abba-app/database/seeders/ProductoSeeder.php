<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Talle;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        // ✅ Obtenemos todos los talles existentes en la tabla `talles` (ej: 35 al 40)
        $talles = Talle::pluck('id')->toArray(); // Devuelve un array con los IDs de los talles

        // ⚠️ Si no hay talles, mostramos un aviso y salimos
        if (count($talles) < 1) {
            $this->command->warn('No hay talles cargados. Ejecutá TalleSeeder antes.');
            return;
        }

        // ✅ Definimos 5 productos de ejemplo
        $productos = [
            ['nombre' => 'Zapatilla Urbana', 'codigo' => 'ZAP001', 'precio' => 15000],
            ['nombre' => 'Zapatilla Running', 'codigo' => 'ZAP002', 'precio' => 18000],
            ['nombre' => 'Zapatilla Alta', 'codigo' => 'ZAP003', 'precio' => 20000],
            ['nombre' => 'Zapatilla Deportiva', 'codigo' => 'ZAP004', 'precio' => 17000],
            ['nombre' => 'Zapatilla Clásica', 'codigo' => 'ZAP005', 'precio' => 16000],
        ];

        // 🔁 Recorremos cada producto y lo insertamos en la tabla `productos`
        foreach ($productos as $data) {
            $producto = Producto::create([
                'nombre' => $data['nombre'],
                'codigo' => $data['codigo'],
                'precio' => $data['precio'],
                'stock_minimo' => 3,
                'activo' => true,
            ]);

            // 🔁 Asociamos cada talle a este producto con 6 unidades de stock
            foreach ($talles as $talle_id) {
                // 👇 Esta línea llena la tabla intermedia `producto_talle`
                DB::table('producto_talle')->insert([
                    'producto_id' => $producto->id, // producto actual
                    'talle_id' => $talle_id,         // talle actual
                    'stock' => 6,                    // stock inicial por talle
                ]);
            }

            // 🔁 Resultado: cada producto queda vinculado con todos los talles disponibles,
            //     y cada combinación tiene un stock inicial de 6 unidades.
        }
    }
}

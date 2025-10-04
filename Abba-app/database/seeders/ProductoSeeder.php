<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Talle;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $talles = Talle::all();

        if ($talles->isEmpty()) {
            $this->command->warn('No hay talles cargados. Ejecutá TalleSeeder antes.');
            return;
        }

        $productos = [
            ['nombre' => 'Zapatilla Urbana', 'codigo' => 'ZAP001', 'precio' => 15000],
            ['nombre' => 'Zapatilla Running', 'codigo' => 'ZAP002', 'precio' => 18000],
            ['nombre' => 'Bota de Montaña', 'codigo' => 'BOT007', 'precio' => 25000],
            ['nombre' => 'Pantufla Invierno', 'codigo' => 'PAN011', 'precio' => 9000],
            ['nombre' => 'Ojota Verano', 'codigo' => 'OJO014', 'precio' => 7000],
            ['nombre' => 'Sandalia Confort', 'codigo' => 'SAN018', 'precio' => 13000],
            ['nombre' => 'Zapato Formal Hombre', 'codigo' => 'ZAP019', 'precio' => 21000],
            ['nombre' => 'Crocs Coloridas', 'codigo' => 'CRO022', 'precio' => 10000],
            ['nombre' => 'Alpargata Estampada', 'codigo' => 'ALP025', 'precio' => 10000],
            ['nombre' => 'Mocasín Cuero', 'codigo' => 'MOC026', 'precio' => 23000],
        ];

        foreach ($productos as $data) {
            $producto = Producto::create([
                'nombre' => $data['nombre'],
                'codigo' => $data['codigo'],
                'precio' => $data['precio'],
                'stock_minimo' => 1,
                'activo' => true,
            ]);

            // Asignar stock por talle
            foreach ($talles as $talle) {
                // Ejemplo: si es pantufla, menos stock; calzado deportivo más stock
                $stock = match(true) {
                    str_contains(strtolower($data['nombre']), 'pantufla') => rand(1, 5),
                    str_contains(strtolower($data['nombre']), 'ojota') => rand(1, 7),
                    str_contains(strtolower($data['nombre']), 'zapatilla') => rand(3, 10),
                    str_contains(strtolower($data['nombre']), 'bota') => rand(2, 8),
                    default => rand(1, 6),
                };

                $producto->talles()->attach($talle->id, [
                    'stock' => $stock,
                ]);
            }
        }

        $this->command->info('Productos y talles cargados con éxito.');
    }
}

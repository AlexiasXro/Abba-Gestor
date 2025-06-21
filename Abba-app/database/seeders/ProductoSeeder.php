<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['codigo' => 'PROD001', 'nombre' => 'Zapato Deportivo', 'descripcion' => 'Zapato cómodo para deporte', 'precio' => 3500, 'stock_minimo' => 3, 'activo' => true],
            ['codigo' => 'PROD002', 'nombre' => 'Zapatilla Casual', 'descripcion' => 'Zapatilla para uso diario', 'precio' => 2800, 'stock_minimo' => 5, 'activo' => true],
            ['codigo' => 'PROD003', 'nombre' => 'Sandalia Verano', 'descripcion' => 'Sandalia fresca para verano', 'precio' => 1500, 'stock_minimo' => 2, 'activo' => true],
            ['codigo' => 'PROD004', 'nombre' => 'Botas Invierno', 'descripcion' => 'Botas para clima frío', 'precio' => 5200, 'stock_minimo' => 4, 'activo' => true],
            ['codigo' => 'PROD005', 'nombre' => 'Zapato Formal', 'descripcion' => 'Zapato elegante para oficina', 'precio' => 4600, 'stock_minimo' => 3, 'activo' => true],
            ['codigo' => 'PROD006', 'nombre' => 'Zapatillas Running', 'descripcion' => 'Zapatillas para correr', 'precio' => 3900, 'stock_minimo' => 6, 'activo' => true],
            ['codigo' => 'PROD007', 'nombre' => 'Sandalias Playa', 'descripcion' => 'Sandalias para la playa', 'precio' => 1200, 'stock_minimo' => 2, 'activo' => true],
            ['codigo' => 'PROD008', 'nombre' => 'Zapatos Casual', 'descripcion' => 'Zapatos para uso casual', 'precio' => 3000, 'stock_minimo' => 3, 'activo' => true],
            ['codigo' => 'PROD009', 'nombre' => 'Botines Mujer', 'descripcion' => 'Botines para mujer', 'precio' => 4100, 'stock_minimo' => 5, 'activo' => true],
            ['codigo' => 'PROD010', 'nombre' => 'Zapatillas Hombre', 'descripcion' => 'Zapatillas deportivas para hombre', 'precio' => 3700, 'stock_minimo' => 4, 'activo' => true],
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate(['codigo' => $producto['codigo']], $producto);
        }
    }
}

<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Talle;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        // ✅ Obtenemos todos los talles existentes como colecciones (no solo IDs)
        $talles = Talle::all();

        // ⚠️ Si no hay talles, mostramos un aviso y salimos
        if ($talles->isEmpty()) {
            $this->command->warn('No hay talles cargados. Ejecutá TalleSeeder antes.');
            return;
        }

        // ✅ Lista de productos
        $productos = [
            ['nombre' => 'Zapatilla Urbana',        'codigo' => 'ZAP001', 'precio' => 15000],
            ['nombre' => 'Zapatilla Running',       'codigo' => 'ZAP002', 'precio' => 18000],
            ['nombre' => 'Zapatilla Alta',          'codigo' => 'ZAP003', 'precio' => 20000],
            ['nombre' => 'Zapatilla Deportiva',     'codigo' => 'ZAP004', 'precio' => 17000],
            ['nombre' => 'Zapatilla Clásica',       'codigo' => 'ZAP005', 'precio' => 16000],
            ['nombre' => 'Bota Corta Urbana',       'codigo' => 'BOT006', 'precio' => 22000],
            ['nombre' => 'Bota de Montaña',         'codigo' => 'BOT007', 'precio' => 25000],
            ['nombre' => 'Bota Negra Alta',         'codigo' => 'BOT008', 'precio' => 27000],
            ['nombre' => 'Borcego Militar',         'codigo' => 'BOR009', 'precio' => 26000],
            ['nombre' => 'Borcego Urbano',          'codigo' => 'BOR010', 'precio' => 24000],
            ['nombre' => 'Pantufla Invierno',       'codigo' => 'PAN011', 'precio' => 9000],
            ['nombre' => 'Pantufla Infantil',       'codigo' => 'PAN012', 'precio' => 8000],
            ['nombre' => 'Pantufla Animal Print',   'codigo' => 'PAN013', 'precio' => 9500],
            ['nombre' => 'Ojota Verano',            'codigo' => 'OJO014', 'precio' => 7000],
            ['nombre' => 'Ojota Hombre',            'codigo' => 'OJO015', 'precio' => 7500],
            ['nombre' => 'Sandalia Clásica',        'codigo' => 'SAN016', 'precio' => 11000],
            ['nombre' => 'Sandalia Dama',           'codigo' => 'SAN017', 'precio' => 12000],
            ['nombre' => 'Sandalia Confort',        'codigo' => 'SAN018', 'precio' => 13000],
            ['nombre' => 'Zapato Formal Hombre',    'codigo' => 'ZAP019', 'precio' => 21000],
            ['nombre' => 'Zapato Escolar',          'codigo' => 'ZAP020', 'precio' => 14000],
            ['nombre' => 'Zapato Dama Taco Bajo',   'codigo' => 'ZAP021', 'precio' => 19000],
            ['nombre' => 'Crocs Coloridas',         'codigo' => 'CRO022', 'precio' => 10000],
            ['nombre' => 'Crocs Negras',            'codigo' => 'CRO023', 'precio' => 10500],
            ['nombre' => 'Alpargata Lona',          'codigo' => 'ALP024', 'precio' => 9500],
            ['nombre' => 'Alpargata Estampada',     'codigo' => 'ALP025', 'precio' => 10000],
            ['nombre' => 'Mocasín Cuero',           'codigo' => 'MOC026', 'precio' => 23000],
            ['nombre' => 'Mocasín Casual',          'codigo' => 'MOC027', 'precio' => 21000],
            ['nombre' => 'Slipper Hombre',          'codigo' => 'SLI028', 'precio' => 12000],
            ['nombre' => 'Slipper Mujer',           'codigo' => 'SLI029', 'precio' => 12500],
            ['nombre' => 'Zapatilla Skate',         'codigo' => 'ZAP030', 'precio' => 18500],
        ];

        foreach ($productos as $data) {
            $producto = Producto::create([
                'nombre' => $data['nombre'],
                'codigo' => $data['codigo'],
                'precio' => $data['precio'],
                'stock_minimo' => 1,
                'activo' => true,
            ]);

            // Asignar talles con stock aleatorio entre 0 y 10
            foreach ($talles as $talle) {
                $producto->talles()->attach($talle->id, [
                    'stock' => rand(0, 10),
                ]);
            }
        }

        $this->command->info('Productos y talles cargados con éxito.');
    }
}

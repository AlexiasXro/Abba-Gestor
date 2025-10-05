<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Talle;

class CategoriaConTallesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
public function run()
{
    $categorias = [
        ['nombre' => 'Ropa', 'usa_talle' => true, 'tipo_talle' => 'Ropa'],
        ['nombre' => 'Calzado', 'usa_talle' => true, 'tipo_talle' => 'Calzado'],
        ['nombre' => 'Niño', 'usa_talle' => true, 'tipo_talle' => 'Niño'],
        ['nombre' => 'Accesorios', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Juguetes', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Bazar', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Electrónica', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Librería', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Hogar', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Belleza', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Deportes', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Mascotas', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Herramientas', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Papelería', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Tecnología', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Regalería', 'usa_talle' => false, 'tipo_talle' => null],
        ['nombre' => 'Bebés', 'usa_talle' => true, 'tipo_talle' => 'Ropa'],
        ['nombre' => 'Juvenil', 'usa_talle' => true, 'tipo_talle' => 'Ropa'],
        ['nombre' => 'Adulto', 'usa_talle' => true, 'tipo_talle' => 'Ropa'],
        ['nombre' => 'Unisex', 'usa_talle' => true, 'tipo_talle' => 'Ropa'],
        ['nombre' => 'Temporada', 'usa_talle' => false, 'tipo_talle' => null],
    ];

    foreach ($categorias as $data) {
        $categoria = Categoria::firstOrCreate([
            'nombre' => $data['nombre'],
        ], [
            'usa_talle' => $data['usa_talle'],
            'tipo_talle' => $data['tipo_talle'],
        ]);

        if ($categoria->usa_talle) {
            switch ($categoria->tipo_talle) {
                case 'Calzado':
                    foreach (range(35, 45) as $numero) {
                        Talle::firstOrCreate([
                            'talle' => (string) $numero,
                            'tipo' => 'Calzado',
                        ]);
                    }
                    break;

                case 'Ropa':
                    foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $ropaTalle) {
                        Talle::firstOrCreate([
                            'talle' => $ropaTalle,
                            'tipo' => 'Ropa',
                        ]);
                    }
                    break;

                case 'Niño':
                    foreach ([2, 4, 6, 8, 10, 12, 14] as $edad) {
                        Talle::firstOrCreate([
                            'talle' => (string) $edad,
                            'tipo' => 'Niño',
                        ]);
                    }
                    break;
            }
        }
    }
}

}
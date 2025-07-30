<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gasto;
use Carbon\Carbon;

class GastosSeeder extends Seeder
{
    public function run()
    {
        $categorias = ['Impuesto', 'Proveedor', 'Servicios', 'Otros', 'Publicidad', 'Mantenimiento', 'Transporte'];
        $metodosPago = ['efectivo', 'transferencia', 'tarjeta', 'débito'];
        $descripciones = [
            'Compra de materiales',
            'Pago de electricidad',
            'Publicidad en redes sociales',
            'Alquiler local',
            'Reparación maquinaria',
            'Servicio de limpieza',
            'Pago de agua',
            'Transporte de mercadería',
            'Compra de cajas y embalajes',
            'Honorarios contador',
            'Publicidad en radio local',
            'Pago de seguridad',
            'Gastos administrativos',
            'Pago de internet',
            'Capacitación personal',
            'Mantenimiento de vehículo',
            'Compra de etiquetas',
            'Suministros de oficina',
            'Pago de software',
            'Gastos varios'
        ];

        for ($i = 0; $i < 20; $i++) {
            Gasto::create([
                'fecha' => Carbon::now()->subDays(rand(0, 60))->format('Y-m-d'),
                'descripcion' => $descripciones[$i],
                'monto' => rand(500, 8000),
                'categoria' => $categorias[array_rand($categorias)],
                'metodo_pago' => $metodosPago[array_rand($metodosPago)],
                'proveedor' => 'Proveedor ' . chr(65 + ($i % 26)),
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CierreCaja;
use Carbon\Carbon;

class CierreCajaSeeder extends Seeder
{
    public function run(): void
    {
        $fechaInicio = Carbon::create(2024, 1, 1);
        $fechaFin = Carbon::now();

        while ($fechaInicio->lte($fechaFin)) {
            $montoEfectivo = rand(10000, 30000) / 100;
            $montoCuotas = rand(5000, 20000) / 100;
            $montoTotal = $montoEfectivo + $montoCuotas;

            CierreCaja::create([
                'fecha' => $fechaInicio->format('Y-m-d'),
                'monto_efectivo' => $montoEfectivo,
                'monto_cuotas' => $montoCuotas,
                'monto_total' => $montoTotal,
                'observaciones' => 'Cierre automático generado por seeder',
            ]);

            $fechaInicio->addDay();
        }
    }
}

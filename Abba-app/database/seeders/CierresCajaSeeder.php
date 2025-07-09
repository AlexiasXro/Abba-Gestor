<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CierreCaja;
use Carbon\Carbon;

class CierresCajaSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $fecha = Carbon::now()->subDays($i)->format('Y-m-d');
            $ingresosEfectivo = rand(2000, 10000);
            $ingresosTarjeta = rand(1000, 5000);
            $egresos = rand(500, 3000);
            $montoContado = $ingresosEfectivo + $ingresosTarjeta - $egresos;
            $diferencia = rand(-50, 50); // para simular diferencias

            CierreCaja::create([
                'fecha' => $fecha,
                'ingresos_efectivo' => $ingresosEfectivo,
                'ingresos_tarjeta' => $ingresosTarjeta,
                'egresos' => $egresos,
                'monto_contado' => $montoContado,
                'diferencia' => $diferencia,
                'observaciones' => 'Cierre automático de prueba',
            ]);
        }
    }
}

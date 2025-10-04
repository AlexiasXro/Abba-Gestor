<?php

namespace App\Http\Controllers;

use App\Models\CierreCaja;
use App\Models\Venta;
use App\Models\Gasto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CierreCajaController extends Controller
{
    /**
     * Muestra todos los cierres de caja, ordenados por fecha descendente.
     */
    public function index(Request $request)
{
    $mes = $request->input('mes', now()->month);
    $anio = $request->input('anio', now()->year);

    $cierres = CierreCaja::whereYear('fecha', $anio)
        ->whereMonth('fecha', $mes)
        ->orderBy('fecha', 'desc')
        ->get();

    $totalMes = $cierres->sum('saldo_dia');

    return view('cierres.index', compact('cierres', 'mes', 'anio', 'totalMes'));
}


    /**
     * Muestra el formulario para registrar el cierre del día.
     * Precalcula los valores desde ventas y gastos del día actual.
     */
    public function create()
    {
        $fecha = Carbon::today();

        // Calcula ventas del día por método de pago (ignorando anuladas)
        $monto_efectivo = Venta::whereDate('fecha', $fecha)
            ->where('tipo_pago', 'efectivo')
            ->whereNull('anulada') // asumiendo que 'anulada' es nullable
            ->sum('total');

        $monto_cuotas = Venta::whereDate('fecha', $fecha)
            ->where('tipo_pago', 'cuotas')
            ->whereNull('anulada')
            ->sum('total');

        // Calcula total de gastos del día
        $total_gastos = Gasto::whereDate('fecha', $fecha)->sum('monto');

        // Calcula saldo final
        $monto_total = ($monto_efectivo + $monto_cuotas) - $total_gastos;

        // Enviar los valores precalculados a la vista
        return view('cierres.create', compact('fecha', 'monto_efectivo', 'monto_cuotas', 'total_gastos', 'monto_total'));
    }

    /**
     * Registra un nuevo cierre de caja. Valida que no exista un cierre para esa fecha.
     */
   public function store(Request $request)
{
    $fecha = $request->input('fecha') ?? now()->toDateString();

    // Validar que no exista ya
    if (CierreCaja::where('fecha', $fecha)->exists()) {
        return back()->with('error', 'Ya existe un cierre para este día.');
    }

    $ingresoEfectivo = $request->input('ingreso_efectivo', 0);
    $ingresoTarjeta  = $request->input('ingreso_tarjeta', 0);
    $ingresoCuotas   = $request->input('ingreso_cuotas', 0);
    $otrosIngresos   = $request->input('otros_ingresos', 0);
    $egresos         = $request->input('egresos', 0);

    $saldo = $ingresoEfectivo + $ingresoTarjeta + $ingresoCuotas + $otrosIngresos - $egresos;

    CierreCaja::create([
        'fecha'            => $fecha,
        'ingreso_efectivo' => $ingresoEfectivo,
        'ingreso_tarjeta'  => $ingresoTarjeta,
        'ingreso_cuotas'   => $ingresoCuotas,
        'otros_ingresos'   => $otrosIngresos,
        'egresos'          => $egresos,
        'saldo_dia'        => $saldo,
        'observaciones'    => $request->input('observaciones'),
    ]);

    return redirect()->route('cierres.index')->with('success', 'Cierre registrado correctamente.');
}


    /**
     * Muestra el detalle de un cierre específico.
     */
    public function show(CierreCaja $cierre)
    {
        return view('cierres.show', compact('cierre'));
    }


    public function cierreMensual($anio, $mes)
{
    $total = CierreCaja::whereYear('fecha', $anio)
        ->whereMonth('fecha', $mes)
        ->sum('saldo_dia');

    return view('reportes.cierre_mensual', compact('anio', 'mes', 'total'));
}

public function cierreAnual($anio)
{
    $total = CierreCaja::whereYear('fecha', $anio)->sum('saldo_dia');

    return view('reportes.cierre_anual', compact('anio', 'total'));
}

}

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
    public function index()
    {
        $cierres = CierreCaja::orderByDesc('fecha')->get();
        return view('cierres.index', compact('cierres'));
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
        $request->validate([
            'fecha' => 'required|date',
            'monto_efectivo' => 'required|numeric|min:0',
            'monto_cuotas' => 'required|numeric|min:0',
            'monto_total' => 'required|numeric',
        ]);

        // Evita duplicado antes de guardar
        if (CierreCaja::whereDate('fecha', $request->fecha)->exists()) {
            return back()->with('error', 'Ya existe un cierre para esta fecha.');
        }

        // Guarda el cierre
        CierreCaja::create([
            'fecha' => $request->fecha,
            'monto_efectivo' => $request->monto_efectivo,
            'monto_cuotas' => $request->monto_cuotas,
            'monto_total' => $request->monto_total,
        ]);

        return redirect()->route('cierres.index')->with('success', 'Cierre de caja registrado correctamente.');
    }

    /**
     * Muestra el detalle de un cierre específico.
     */
    public function show(CierreCaja $cierre)
    {
        return view('cierres.show', compact('cierre'));
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuota;
use Illuminate\Http\Request;

class CuotaController extends Controller
{
   public function index(Request $request)
{
    $estado = $request->query('estado');
    $clienteNombre = $request->query('cliente');

    $cuotas = Cuota::with('venta.cliente'); // eager load para evitar N+1

    // Filtro por estado
    if ($estado === 'pagada') {
        $cuotas->where('pagada', true);
    } elseif ($estado === 'pendiente') {
        $cuotas->where('pagada', false)->whereDate('fecha_vencimiento', '>=', Carbon::today());
    } elseif ($estado === 'vencida') {
        $cuotas->where('pagada', false)->whereDate('fecha_vencimiento', '<', Carbon::today());
    }

    // Filtro por nombre o apellido (cliente)
    if ($clienteNombre) {
        $cuotas->whereHas('venta.cliente', function ($query) use ($clienteNombre) {
            $query->where('nombre', 'like', "%{$clienteNombre}%")
                  ->orWhere('apellido', 'like', "%{$clienteNombre}%");
        });
    }

    $cuotas = $cuotas->orderBy('fecha_vencimiento')->get();

    return view('cuotas.index', compact('cuotas', 'estado', 'clienteNombre'));
}

    public function pagar($id)
    {
        $cuota = Cuota::findOrFail($id);

        if ($cuota->pagada) {
            return back()->with('info', 'La cuota ya está pagada.');
        }

        $cuota->pagada = true;
        $cuota->save();

        return back()->with('success', 'Cuota marcada como pagada.');
    }
}

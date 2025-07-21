<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use App\Models\Venta;
use App\Models\ProductoTalle;
use App\Models\Producto;
use App\Models\Talle;
use App\Models\Cliente;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevolucionController extends Controller
{
    public function index(Request $request)
    {
        $query = Devolucion::with(['venta.cliente', 'producto', 'talle', 'usuario']);

    if ($request->filled('venta_id')) {
        $query->where('venta_id', $request->input('venta_id'));
    }

    if ($request->filled('tipo')) {
        $query->where('tipo', $request->input('tipo'));
    }

    if ($request->filled('producto_id')) {
        $query->where('producto_id', $request->input('producto_id'));
    }

    if ($request->filled('cliente')) {
        $query->whereHas('venta.cliente', function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->input('cliente'). '%');
        });
    }

    if ($request->filled('fecha')) {
        $query->whereDate('fecha', $request->input('fecha'));
    }

    $devoluciones = $query->orderByDesc('fecha')->paginate(10);

    return view('devoluciones.index', compact('devoluciones'));
    }

    public function anular(Devolucion $devolucion)
    {
        $devolucion->update([
            'estado' => 'anulada',
            'motivo_anulacion' => 'Anulación manual',
        ]);

        return redirect()->route('devoluciones.index')->with('success', 'Devolución anulada correctamente.');
    }
    public function create(Request $request)
    {
        $venta_id = $request->input('venta_id');
        $producto_id = $request->input('producto_id');
        $talle_id = $request->input('talle_id');
        $venta = null;
        $producto = null;
        $talle = null;

        if ($venta_id) {
            $venta = Venta::with('cliente')->find($venta_id);
        }

        if ($producto_id) {
            $producto = Producto::find($producto_id);
        }

        if ($talle_id) {
            $talle = Talle::find($talle_id);
        }

        $ventas = Venta::with('cliente')->orderByDesc('created_at')->take(50)->get();

        return view('devoluciones.create', compact('venta', 'producto', 'talle', 'ventas'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'producto_id' => 'required|exists:productos,id',
            'talle_id' => 'required|exists:talles,id',
            'tipo' => 'required|in:devolucion,garantia',
            'motivo_texto' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:1',
        ]);


        $venta = Venta::findOrFail($request->input('venta_id'));

        // Controlar vencimientos
        $diasTranscurridos = now()->diffInDays(Carbon::parse($venta->fecha));

        if ($request->input('tipo') === 'garantia' && $diasTranscurridos > 20) {
            return back()->withErrors(['La garantía ha vencido.'])->withInput();
        }

        if ($request->input('tipo') === 'devolucion' && $diasTranscurridos > 10) {
            return back()->withErrors(['El plazo de devolución ha vencido.'])->withInput();
        }

        // Registrar la devolución
        Devolucion::create([
            'venta_id' => $request->input('venta_id'),
            'producto_id' => $request->input('producto_id'),
            'talle_id' => $request->input('talle_id'),
            'cantidad' => $request->input('cantidad'),
            'fecha' => now(),
            'tipo' => $request->input('tipo'),
            'motivo_texto' => $request->input('motivo_texto'),
            'observaciones' => $request->input('observaciones'),
            'estado' => 'activa',
            'usuario_id' => 1, // o auth()->id()
        ]);

        // Actualizar stock
        $stock = ProductoTalle::where('producto_id', $request->input('producto_id')) // ✅
            ->where('talle_id', $request->input('talle_id'))
            ->first();

        if ($stock) {
            $stock->increment('stock', $request->input('cantidad'));
            $stock->save();
        }

        return redirect()->back()->with('success', 'Devolución registrada correctamente.');
    }



    public function show(Devolucion $devolucion)
    {
        $devolucion->load('venta.cliente', 'producto', 'talle', 'usuario');
        return view('devoluciones.show', compact('devolucion'));
    }
}

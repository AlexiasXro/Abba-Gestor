<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\ProductoTalle;
use App\Models\Talle;
use Illuminate\Http\Request;

class VentaController extends Controller
{

    //VentaController (app/Http/Controllers/VentaController.php)
    public function index()
    {
        $ventas = Venta::with(['cliente', 'detalles.producto.talles'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ventas.index', compact('ventas'));
    }


    // otros métodos como create, store, show, etc.


    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::with('talles')->get();
        $talles = Talle::all();

        return view('ventas.create', compact('clientes', 'productos', 'talles'));
    }




    public function store(Request $request)
    {
        //dd($request->all());

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',

            'productos.*.talle_id' => 'required|exists:talles,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.descuento' => 'nullable|numeric|min:0',
            'metodo_pago' => 'required|string|in:efectivo,tarjeta,transferencia',
            'monto_pagado' => 'required_if:metodo_pago,efectivo|numeric|min:0',
            'tipo_tarjeta' => 'nullable|string|in:debito,credito',
            'numero_operacion' => 'nullable|string|max:50',
        ]);

        // Verificar stock
        foreach ($validated['productos'] as $item) {
            $stockDisponible = ProductoTalle::where('producto_id', $item['producto_id'])
                ->where('talle_id', $item['talle_id'])
                ->value('stock');

            if ($stockDisponible === null || $stockDisponible < $item['cantidad']) {
                $producto = Producto::find($item['producto_id']);
                $talle = Talle::find($item['talle_id']);
                return back()->withErrors([
                    'stock' => "Stock insuficiente para {$producto->nombre} (Talle: {$talle->talle})"
                ])->withInput();
            }
        }

        // Calcular totales
        $subtotal = 0;
        $items = [];

        foreach ($validated['productos'] as $item) {
            $precio = $item['precio'];
            $cantidad = $item['cantidad'];
            $descuento = $item['descuento'] ?? 0;

            $subtotalItem = ($precio * $cantidad) - $descuento;
            $subtotal += $subtotalItem;

            $items[] = [
                'producto_id' => $item['producto_id'],
                'talle_id' => $item['talle_id'],
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'descuento' => $descuento,
                'subtotal' => $subtotalItem,
            ];
        }

        $descuentoGlobal = $validated['descuento_global'] ?? 0;
        $total = $subtotal - $descuentoGlobal;

        // Validar monto entregado si es efectivo
        if ($validated['metodo_pago'] === 'efectivo') {
            $montoPagado = $validated['monto_pagado'];
            if ($montoPagado < $total) {
                return back()->withErrors(['monto_pagado' => 'El monto entregado debe ser igual o mayor al total de la venta.'])
                    ->withInput();
            }
        }

        // Transacción
        DB::beginTransaction();

        try {
            $venta = Venta::create([
                'cliente_id' => $validated['cliente_id'] ?? null,
                'fecha_venta' => now(),
                'subtotal' => $subtotal,
                'descuento' => 0, // Por ahora sin descuento global
                'total' => $total,
                'metodo_pago' => $validated['metodo_pago'],
                'monto_pagado' => $validated['metodo_pago'] === 'efectivo' ? $validated['monto_pagado'] : null,
            ]);

            $venta->detalles()->createMany($items);

            foreach ($validated['productos'] as $item) {
                ProductoTalle::where('producto_id', $item['producto_id'])
                    ->where('talle_id', $item['talle_id'])
                    ->decrement('stock', $item['cantidad']);
            }

            DB::commit();
            return redirect()->route('ventas.show', $venta->id)->with('success', 'Venta registrada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Error al procesar la venta: ' . $e->getMessage()
            ])->withInput();
        }
    }


    public function show(Venta $venta)
    {
        $venta->load('cliente', 'detalles.producto', 'detalles.talle');
        return view('ventas.show', compact('venta'));
    }

    // Otros métodos 
    public function pdf(Venta $venta)
    {
        $venta->load('cliente', 'detalles.producto', 'detalles.talle');

        $pdf = PDF::loadView('ventas.pdf', compact('venta'));

        return $pdf->stream('ticket-venta-' . $venta->id . '.pdf');
    }

 // Ventas Anuladas
    public function anular(Request $request, Venta $venta)
{
    if ($venta->estado === 'anulada') {
        return back()->with('error', 'La venta ya fue anulada.');
    }

    $request->validate([
        'motivo_anulacion' => 'required|string|min:5'
    ]);

    // Reversión de stock
    foreach ($venta->detalles as $detalle) {
        $productoTalle = ProductoTalle::where('producto_id', $detalle->producto_id)
            ->where('talle_id', $detalle->talle_id)
            ->first();

        if ($productoTalle) {
            $productoTalle->stock += $detalle->cantidad;
            $productoTalle->save();
        }
    }

    $venta->estado = 'anulada';
    $venta->motivo_anulacion = $request->motivo_anulacion;
    $venta->save();

    return redirect()->route('ventas.show', $venta)->with('success', 'Venta anulada correctamente.');
}



}
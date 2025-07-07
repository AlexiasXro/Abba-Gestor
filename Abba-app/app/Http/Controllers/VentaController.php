<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use App\Models\Venta;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ CORRECTO
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
    // Validamos los datos de entrada con reglas claras.
    // Por ejemplo: cliente_id debe existir, productos es un array y debe tener al menos 1 producto,
    // cada producto debe tener un producto_id, talle_id, cantidad, precio, etc.
    // Además validamos que el método de pago sea uno de los permitidos.
    $validated = $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'productos' => 'required|array|min:1',
        'productos.*.producto_id' => 'required|exists:productos,id',
        'productos.*.talle_id' => 'required|exists:talles,id',
        'productos.*.cantidad' => 'required|integer|min:1',
        'productos.*.precio' => 'required|numeric|min:0',
        'productos.*.descuento' => 'nullable|numeric|min:0',
        'metodo_pago' => 'required|string|in:efectivo,tarjeta,transferencia,cuotas',

        // Para efectivo, monto_pagado es obligatorio
        'monto_pagado' => 'required_if:metodo_pago,efectivo|nullable|numeric|min:0',

        // Para cuotas, entrega_inicial y cantidad_cuotas son obligatorios
        'entrega_inicial' => 'required_if:metodo_pago,cuotas|nullable|numeric|min:0',
        'cantidad_cuotas' => 'required_if:metodo_pago,cuotas|nullable|integer|min:2',

        'tipo_tarjeta' => 'nullable|string|in:debito,credito',
        'numero_operacion' => 'nullable|string|max:50',
    ]);

    // Verificamos que haya suficiente stock para cada producto con talle seleccionado.
    foreach ($validated['productos'] as $item) {
        $stockDisponible = ProductoTalle::where('producto_id', $item['producto_id'])
            ->where('talle_id', $item['talle_id'])
            ->value('stock');

        if ($stockDisponible === null || $stockDisponible < $item['cantidad']) {
            // Si no hay stock suficiente, mostramos error con nombre y talle del producto
            $producto = Producto::find($item['producto_id']);
            $talle = Talle::find($item['talle_id']);
            return back()->withErrors([
                'stock' => "Stock insuficiente para {$producto->nombre} (Talle: {$talle->talle})"
            ])->withInput();
        }
    }

    // Calculamos subtotal sumando cada producto (precio*cantidad - descuento)
    $subtotal = 0;
    $items = [];

    foreach ($validated['productos'] as $item) {
        $precio = $item['precio'];
        $cantidad = $item['cantidad'];
        $descuento = $item['descuento'] ?? 0;

        $subtotalItem = ($precio * $cantidad) - $descuento;
        $subtotal += $subtotalItem;

        // Preparamos el array con los datos que vamos a insertar en detalles de venta
        $items[] = [
            'producto_id' => $item['producto_id'],
            'talle_id' => $item['talle_id'],
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'descuento' => $descuento,
            'subtotal' => $subtotalItem,
        ];
    }

    // Aplicamos descuento global si viene (por ahora lo dejamos en 0)
    $descuentoGlobal = $validated['descuento_global'] ?? 0;
    $total = $subtotal - $descuentoGlobal;

    // Validamos que si el pago es en efectivo, el monto entregado sea suficiente para cubrir el total
    if ($validated['metodo_pago'] === 'efectivo') {
        $montoPagado = $validated['monto_pagado'];
        if ($montoPagado < $total) {
            return back()->withErrors(['monto_pagado' => 'El monto entregado debe ser igual o mayor al total de la venta.'])
                ->withInput();
        }
    }

    // Usamos transacción para que todas las operaciones sean atómicas (o se hacen todas o ninguna)
    DB::beginTransaction();

    try {
        $tipoPago = $validated['metodo_pago'];

        // Creamos la venta principal con sus datos.
        // Si el método es cuotas, el monto_pagado es la entrega inicial.
        // Si es efectivo, usamos el monto_pagado que ingresó el usuario.
        $venta = Venta::create([
            'cliente_id' => $validated['cliente_id'] ?? null,
            'fecha_venta' => now(),
            'subtotal' => $subtotal,
            'descuento' => 0, // por ahora sin descuento global aplicado
            'total' => $total,
            'metodo_pago' => $tipoPago,
            'monto_pagado' => $tipoPago === 'cuotas'
                ? $validated['entrega_inicial']
                : ($tipoPago === 'efectivo' ? $validated['monto_pagado'] : null),
        ]);

        // Insertamos los detalles de cada producto vendido
        $venta->detalles()->createMany($items);

        // Actualizamos stock restando la cantidad vendida
        foreach ($validated['productos'] as $item) {
            ProductoTalle::where('producto_id', $item['producto_id'])
                ->where('talle_id', $item['talle_id'])
                ->decrement('stock', $item['cantidad']);
        }

        // Si el método de pago es cuotas, generamos los registros de cuotas
        if ($tipoPago === 'cuotas') {
            $cantidadCuotas = $validated['cantidad_cuotas'];
            $entregaInicial = $validated['entrega_inicial'];

            $restante = $total - $entregaInicial; // monto que queda para pagar en cuotas
            $cuotaMonto = $cantidadCuotas > 1 ? $restante / ($cantidadCuotas - 1) : $restante;

            for ($i = 1; $i <= $cantidadCuotas; $i++) {
                // La primera cuota es la entrega inicial y ya se considera pagada
                $montoCuota = $i === 1 ? $entregaInicial : $cuotaMonto;
                $fechaVencimiento = now()->addDays(30 * ($i - 1)); // cuotas cada 30 días (ajustable)

                $venta->cuotas()->create([
                    'numero' => $i,
                    'monto' => round($montoCuota, 2),
                    'fecha_vencimiento' => $fechaVencimiento,
                    'pagada' => $i === 1 ? true : false, // la primera cuota ya está pagada
                ]);
            }
        }

        DB::commit();

        // Redirigimos a la vista detalle con mensaje éxito
        return redirect()->route('ventas.show', $venta->id)->with('success', 'Venta registrada correctamente');

    } catch (\Exception $e) {
        // Si ocurre un error, deshacemos todo y mostramos el error
        DB::rollBack();

        return back()->withErrors([
            'error' => 'Error al procesar la venta: ' . $e->getMessage()
        ])->withInput();
    }
}


    public function show(Venta $venta)
{
    $venta->load('cliente', 'detalles.producto', 'detalles.talle', 'cuotas');
    return view('ventas.show', compact('venta'));
}

// Otros métodos 
public function pdf(Venta $venta)
{
    $venta->load('cliente', 'detalles.producto', 'detalles.talle', 'cuotas');

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
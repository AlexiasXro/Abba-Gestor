<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\ProductoTalle;
use App\Models\Talle;
use Illuminate\Http\Request;

class VentaController extends Controller
{

    //VentaController (app/Http/Controllers/VentaController.php)

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::with('talles')->get();
        $talles = Talle::all();
        
        return view('ventas.create', compact('clientes', 'productos', 'talles'));
    }

    
   public function store(Request $request)
{
    // Validación de los datos del formulario
    $validated = $request->validate([
        'cliente_id' => 'nullable|exists:clientes,id',
        'productos' => 'required|array|min:1',
        'productos.*.id' => 'required|exists:productos,id',
        'productos.*.talle_id' => 'required|exists:talles,id',
        'productos.*.cantidad' => 'required|integer|min:1',
        'productos.*.precio' => 'required|numeric|min:0',
        'productos.*.descuento' => 'nullable|numeric|min:0',
        'descuento_global' => 'nullable|numeric|min:0',
        'metodo_pago' => 'required|string|in:efectivo,tarjeta,transferencia',
    ]);

    // Verificación de stock antes de procesar la venta
    foreach ($validated['productos'] as $item) {
        $stockDisponible = ProductoTalle::where('producto_id', $item['id'])
                                      ->where('talle_id', $item['talle_id'])
                                      ->value('stock');
        
        if ($stockDisponible < $item['cantidad']) {
            $producto = Producto::find($item['id']);
            $talle = Talle::find($item['talle_id']);
            
            return back()->withErrors([
                'stock' => "No hay suficiente stock para {$producto->nombre} (Talle: {$talle->talle}). ".
                           "Stock disponible: {$stockDisponible}, Cantidad solicitada: {$item['cantidad']}"
            ])->withInput();
        }
    }

    // Calcular subtotal, descuento y total
    $subtotal = 0;
    $items = [];
    
    foreach ($validated['productos'] as $item) {
        $precio = $item['precio'];
        $cantidad = $item['cantidad'];
        $descuento = $item['descuento'] ?? 0;
        
        $subtotalItem = ($precio * $cantidad) - $descuento;
        $subtotal += $subtotalItem;
        
        $items[] = [
            'producto_id' => $item['id'],
            'talle_id' => $item['talle_id'],
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'descuento' => $descuento,
            'subtotal' => $subtotalItem,
        ];
    }
    
    $descuentoGlobal = $validated['descuento_global'] ?? 0;
    $total = $subtotal - $descuentoGlobal;
    
    // Usar transacción para asegurar integridad de datos
    DB::beginTransaction();
    
    try {
        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $validated['cliente_id'] ?? null,
            'fecha_venta' => now(),
            'subtotal' => $subtotal,
            'descuento' => $descuentoGlobal,
            'total' => $total,
            'metodo_pago' => $validated['metodo_pago'],
        ]);
        
        // Crear los detalles de la venta
        $venta->detalles()->createMany($items);
        
        // Actualizar stock (más eficiente que updateExistingPivot)
        foreach ($validated['productos'] as $item) {
            ProductoTalle::where('producto_id', $item['id'])
                       ->where('talle_id', $item['talle_id'])
                       ->decrement('stock', $item['cantidad']);
        }
        
        DB::commit();
        
        return redirect()->route('ventas.show', $venta->id)
                         ->with('success', 'Venta registrada correctamente');
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        return back()->withErrors([
            'error' => 'Ocurrió un error al procesar la venta: '.$e->getMessage()
        ])->withInput();
    }
}

    public function show(Venta $venta)
    {
        $venta->load('cliente', 'detalles.producto', 'detalles.talle');
        return view('ventas.show', compact('venta'));
    }
    
    // Otros métodos del CRUD...

    
}
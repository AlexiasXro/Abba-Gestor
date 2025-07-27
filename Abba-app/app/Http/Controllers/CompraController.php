<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Talle;
use App\Models\ProductoTalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        // Cargar las compras con sus proveedores y detalles
        $compras = Compra::with('proveedor', 'detalles')->latest()->paginate(15);
        // Cargar los detalles de cada compra
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $productos = Producto::with('talles')->get();
        $talles = Talle::all();

        return view('compras.create', compact('proveedores', 'productos', 'talles'));
    }

   public function store(Request $request)
{
    $request->validate([
        'proveedor_id' => 'required|exists:proveedores,id',
        'fecha' => 'required|date',
        'metodo_pago' => 'nullable|string|max:50',
        'detalles' => 'required|array|min:1',
        'detalles.*.producto_id' => 'required|exists:productos,id',
        'detalles.*.talle_id' => 'required|exists:talles,id',
        'detalles.*.cantidad' => 'required|integer|min:1',
        'detalles.*.precio_unitario' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
        // 1. Crear la compra
        $compra = Compra::create([
            'proveedor_id' => $request->proveedor_id,
            'fecha' => $request->fecha,
            'metodo_pago' => $request->metodo_pago,
        ]);

        // 2. Insertar detalles
        foreach ($request->detalles as $detalle) {
            CompraDetalle::create([
                'compra_id' => $compra->id,
                'producto_id' => $detalle['producto_id'],
                'talle_id' => $detalle['talle_id'],
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio_unitario'],
            ]);

            // 3. Actualizar stock en producto_talle
            ProductoTalle::updateOrCreate(
                [
                    'producto_id' => $detalle['producto_id'],
                    'talle_id' => $detalle['talle_id']
                ],
                [
                    'stock' => DB::raw("stock + {$detalle['cantidad']}")
                ]
            );
        }

        DB::commit();

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error al guardar la compra: ' . $e->getMessage());
    }
}

// -----      
    public function show($id)
{
    $compra = Compra::with(['proveedor', 'detalles.producto', 'detalles.talle'])->findOrFail($id);

    return view('compras.show', compact('compra'));
}

}


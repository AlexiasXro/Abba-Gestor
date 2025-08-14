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

public function create(Request $request)
{
    $filtro = $request->input('filtro');

    $query = Producto::query()->with('proveedor');

    if ($filtro) {
        $query->where(function($q) use ($filtro) {
            $q->where('nombre', 'like', "%{$filtro}%")
              ->orWhere('codigo', 'like', "%{$filtro}%")
              ->orWhereHas('proveedor', function($q2) use ($filtro) {
                  $q2->where('nombre', 'like', "%{$filtro}%");
              });
        });
    }

    $productos = $query->paginate(15);

    $proveedores = Proveedor::orderBy('nombre')->get();

    $talles = Talle::all();

    return view('compras.create', compact('productos', 'proveedores', 'filtro', 'talles'));
}




    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'metodo_pago' => 'nullable|string',
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.talle_id' => 'required|exists:talles,id',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ]);
        // Iniciar transacción para asegurar que todo se guarde correctamente
        // Si algo falla, se revertirá todo
        DB::transaction(function () use ($request) {
        $compra = Compra::create([
            'proveedor_id' => $request->proveedor_id,
            'fecha' => $request->fecha,
            'metodo_pago' => $request->metodo_pago,
        ]);
        // Guardar los detalles de la compra
        foreach ($request->detalles as $detalle) {
            CompraDetalle::create([
                'compra_id' => $compra->id,
                'producto_id' => $detalle['producto_id'],
                'talle_id' => $detalle['talle_id'],
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => $detalle['precio_unitario'],
            ]);

            // Actualizar stock en producto_talle
            // Verificar si ya existe una relación entre producto y talle
            $productoTalle = ProductoTalle::where('producto_id', $detalle['producto_id'])
                ->where('talle_id', $detalle['talle_id'])
                ->first();

            if ($productoTalle) {
                $productoTalle->increment('stock', $detalle['cantidad']);
            } else {
                // Si no existe relación, la creamos con el stock inicial
                ProductoTalle::create([
                    'producto_id' => $detalle['producto_id'],
                    'talle_id' => $detalle['talle_id'],
                    'stock' => $detalle['cantidad'],
                ]);
            }
        }
    });
// Redirigir a la lista de compras con mensaje de éxito
    return redirect()->route('compras.index')->with('success', 'Compra registrada y stock actualizado correctamente');
}

    // -----      
    public function show($id)
    {
        $compra = Compra::with(['proveedor', 'detalles.producto', 'detalles.talle'])->findOrFail($id);

        return view('compras.show', compact('compra'));
    }

}


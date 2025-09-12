<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Talle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;// <- para manejar storage
use Intervention\Image\Facades\Image;        // <- para redimensionar imágenes


class ProductoController extends Controller
{
    //Abba-app\app\Http\Controllers\ProductoController.php
    // Mostrar productos activos
    public function index(Request $request)
    {
        $filtro = $request->input('filtro');

        $productos = Producto::query()
            ->with('proveedor')
            ->when($filtro, function ($query, $filtro) {
                $query->where('nombre', 'like', "%{$filtro}%")
                    ->orWhere('codigo', 'like', "%{$filtro}%")
                    ->orWhereHas('proveedor', function ($q) use ($filtro) {
                        $q->where('nombre', 'like', "%{$filtro}%");
                    });
            })
            ->paginate(8);

        return view('productos.index', compact('productos', 'filtro'));
    }




    // Formulario para nuevo producto
    public function create()
    {
        $talles = Talle::all();
        $proveedores = Proveedor::orderBy('nombre')->get();
        return view('productos.create', compact('talles', 'proveedores'));
    }

        // -------------------
    // CREAR PRODUCTO
    // -------------------
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:productos,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_venta' => 'nullable|numeric|min:0',
            'precio_base' => 'nullable|numeric|min:0',
            'precio_reventa' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'activo' => 'required|boolean',
            'talles' => 'nullable|array',
            'talles.*.id' => 'required|exists:talles,id',
            'talles.*.stock' => 'required|integer|min:0',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Preparar datos del producto
        $datosProducto = collect($validated)->except('talles')->toArray();

        // Sincronizar precio general
        $datosProducto['precio'] = $datosProducto['precio_venta'] ?? 0;

        // Guardar imagen si se subió
        if ($request->hasFile('imagen')) {
            $datosProducto['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

//dd($datosProducto, $request->file('imagen'));

        // Crear producto
        $producto = Producto::create($datosProducto);

        // Guardar talles
        if (!empty($validated['talles'])) {
            $syncData = [];
            foreach ($validated['talles'] as $item) {
                $syncData[$item['id']] = ['stock' => $item['stock']];
            }
            $producto->talles()->sync($syncData);
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
    }

    // -------------------
    // ACTUALIZAR PRODUCTO
    // -------------------
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_venta' => 'nullable|numeric|min:0',
            'precio_base' => 'nullable|numeric|min:0',
            'precio_reventa' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'activo' => 'required|boolean',
            'talles' => 'nullable|array',
            'talles.*.id' => 'required|exists:talles,id',
            'talles.*.stock' => 'required|integer|min:0',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $datosProducto = collect($validated)->except('talles')->toArray();

        // Sincronizar precio general
        $datosProducto['precio'] = $datosProducto['precio_venta'] ?? 0;

        
        // Guardar nueva imagen si se subió
        if ($request->hasFile('imagen')) {
            // eliminar imagen anterior si existía
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $datosProducto['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

       

        // Actualizar producto
        $producto->update($datosProducto);

        // Sincronizar talles
        if (!empty($validated['talles'])) {
            $syncData = [];
            foreach ($validated['talles'] as $item) {
                $syncData[$item['id']] = ['stock' => $item['stock']];
            }
            $producto->talles()->sync($syncData);
        } else {
            $producto->talles()->detach();
        }

        return redirect()->route('productos.show', $producto)->with('success', 'Producto actualizado correctamente');
    }

    public function showPorCodigo($codigo)
{
    $producto = Producto::where('codigo', $codigo)->firstOrFail();
    return view('productos.show', compact('producto'));
}


//Detalles del producto
    public function show(Producto $producto)
    {
        $producto->load('talles', 'proveedor');
        
       
        return view('productos.show', compact('producto'));
    }

    // Formulario editar producto
    public function edit(Producto $producto)
    {
        $talles = Talle::all();
        $proveedores = Proveedor::orderBy('nombre')->get(); // <== cargamos proveedores
        $producto->load('talles');
        return view('productos.edit', compact('producto', 'talles', 'proveedores'));
    }



    
    // Mostrar productos eliminados (soft deleted)
    public function eliminados()
    {
        $query = Producto::onlyTrashed()->with('talles')->orderBy('deleted_at', 'desc');

        // Aplicar filtro de búsqueda si existe
        if ($buscar = request('buscar')) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%')
                    ->orWhere('codigo', 'like', '%' . $buscar . '%');

            });

        }
        $productosEliminados = $query->paginate(15)->withQueryString();

        return view('productos.eliminados', compact('productosEliminados'));

    }


    // Eliminar (soft delete)
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }




    // Restaurar producto eliminado
    public function restaurar($id)
    {
        $producto = Producto::onlyTrashed()->findOrFail($id);
        $producto->restore();
        return redirect()->route('productos.eliminados')->with('success', 'Producto restaurado correctamente');
    }


    //-------------imprecion QR
public function qrIndex()
{
    $productos = Producto::all(); // O filtrá los que quieras
    return view('productos.qr', compact('productos'));
}




    // Método para crear un producto rápido desde el modal compra
    public function storeDesdeCompra(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|max:100',
            'precio_base' => 'required|numeric|min:0',
        ]);

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'precio_base' => $request->precio_base,
            // Agregá otros campos que uses o valores por defecto
        ]);

        // Si querés devolver a la vista directamente (no ajax), redirigí con mensaje:
        return redirect()->back()->with('success', 'Producto agregado correctamente');

        // O para ajax, podés devolver json:
        // return response()->json(['producto' => $producto]);
    }


    public function aplicarRecargo(Request $request, Producto $producto)
    {
        $request->validate([
            'recargo' => 'required|numeric|min:0',
        ]);

        try {
            $recargo = $request->input('recargo');
            $precioBase = $producto->precio_base;

            if (!$precioBase) {
                return back()->with('error', 'El producto no tiene precio base definido.');
            }

            // Cálculos
            $nuevoPrecioVenta = $precioBase * (1 + $recargo / 100);
            $nuevoPrecioReventa = $precioBase * (1 + ($recargo - 10) / 100);

            // Actualiza el modelo
            $producto->precio_venta = round($nuevoPrecioVenta, 2);
            $producto->precio_reventa = round($nuevoPrecioReventa, 2);
            $producto->save();

            return back()->with('success', 'Precios actualizados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar precios: ' . $e->getMessage());
        }
    }
public function showPorCodigo($codigo)
{
    $producto = Producto::where('codigo', $codigo)->firstOrFail();
    return view('productos.show', compact('producto'));
}




}

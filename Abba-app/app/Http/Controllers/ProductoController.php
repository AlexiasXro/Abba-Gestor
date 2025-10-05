<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\Talle;
use Illuminate\Http\Request;
use App\Models\ProductoTalle;
use Illuminate\Support\Facades\Storage;// <- para manejar storage
use Intervention\Image\Facades\Image;        // <- para redimensionar imágenes
use Milon\Barcode\DNS1D;


class ProductoController extends Controller
{
    //Abba-app\app\Http\Controllers\ProductoController.php
    // Mostrar productos activos
public function index(Request $request)
{
    $filtro = $request->input('filtro');

    $productos = Producto::query()
        ->with('proveedor', 'talles')
        ->when($filtro, function ($query, $filtro) {
            $query->where('nombre', 'like', "%{$filtro}%")
                ->orWhere('codigo', 'like', "%{$filtro}%")
                ->orWhereHas('proveedor', function ($q) use ($filtro) {
                    $q->where('nombre', 'like', "%{$filtro}%");
                });
        });

    // Filtros avanzados
    if ($request->filled('precio_min')) {
        $productos->where('precio', '>=', $request->precio_min);
    }
    if ($request->filled('precio_max')) {
        $productos->where('precio', '<=', $request->precio_max);
    }
    if ($request->filled('precio_costo_min')) {
        $productos->where('precio_base', '>=', $request->precio_costo_min);
    }
    if ($request->filled('precio_costo_max')) {
        $productos->where('precio_base', '<=', $request->precio_costo_max);
    }
    if ($request->filled('stock_min')) {
        $productos->where('stock', '>=', $request->stock_min);
    }
    if ($request->filled('stock_max')) {
        $productos->where('stock', '<=', $request->stock_max);
    }

    // Filtrar por talle
    if ($request->filled('talle')) {
        $productos->whereHas('talles', function($q) use ($request) {
            $q->where('id', $request->talle);
        });
    }

   $productos = $productos->orderBy('created_at', 'desc')->paginate(6);


    // Obtener talles disponibles para el select (solo con stock > 0)
   // <-- Aquí generamos los talles disponibles para el select
    $tallesDisponibles = Talle::whereHas('productos', function($q){
        $q->wherePivot('stock', '>', 0);
    })->get();

    return view('productos.index', compact('productos', 'filtro', 'tallesDisponibles'));
}





    // Formulario para nuevo producto
    public function create()
    {
        $talles = Talle::all();
        $proveedores = Proveedor::orderBy('nombre')->get();
         $categorias = Categoria::orderBy('nombre')->get();
        return view('productos.create', compact('talles', 'proveedores','categorias'));
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
        'categoria_id' => 'required|exists:categorias,id',
        'talles' => 'nullable|array',
        'talles.*.id' => 'required|exists:talles,id',
        'talles.*.stock' => 'required|integer|min:0',
        'proveedor_id' => 'nullable|exists:proveedores,id',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        

    ]);

    // Validar lógica de talles según categoría
    $categoria = Categoria::find($validated['categoria_id']);

    if ($categoria->usa_talle && empty($validated['talles'])) {
        return back()->withErrors(['talles' => 'Esta categoría requiere talles.']);
    }

    if (!empty($validated['talles'])) {
        foreach ($validated['talles'] as $item) {
            $talle = Talle::find($item['id']);
            if ($talle->tipo !== $categoria->tipo_talle) {
                return back()->withErrors([
                    'talles' => 'El talle "' . $talle->talle . '" no coincide con el tipo de categoría "' . $categoria->tipo_talle . '".'
                ]);
            }
        }
    }

    // Preparar datos del producto
    $datosProducto = collect($validated)->except('talles')->toArray();
    $datosProducto['precio'] = $datosProducto['precio_venta'] ?? 0;

    // Guardar imagen si se subió
    if ($request->hasFile('imagen')) {
        $datosProducto['imagen'] = $request->file('imagen')->store('productos', 'public');
    }

    // Crear producto
    $producto = Producto::create($datosProducto);

    // Guardar talles con stock
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
        'categoria_id' => 'required|exists:categorias,id',
        'talles' => 'nullable|array',
        'talles.*.id' => 'required|exists:talles,id',
        'talles.*.stock' => 'required|integer|min:0',
        'proveedor_id' => 'nullable|exists:proveedores,id',
        'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ]);

    // Validar lógica de talles según categoría
    $categoria = Categoria::find($validated['categoria_id']);

    if ($categoria->usa_talle && empty($validated['talles'])) {
        return back()->withErrors(['talles' => 'Esta categoría requiere talles.']);
    }

    if (!empty($validated['talles'])) {
        foreach ($validated['talles'] as $item) {
            $talle = Talle::find($item['id']);
            if ($talle->tipo !== $categoria->tipo_talle) {
                return back()->withErrors([
                    'talles' => 'El talle "' . $talle->talle . '" no coincide con el tipo de categoría "' . $categoria->tipo_talle . '".'
                ]);
            }
        }
    }

    // Preparar datos del producto
    $datosProducto = collect($validated)->except('talles')->toArray();
    $datosProducto['precio'] = $datosProducto['precio_venta'] ?? 0;

    // Guardar nueva imagen si se subió
    if ($request->hasFile('imagen')) {
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





//Detalles del producto
   public function show(Producto $producto)
{
    $producto->load('talles', 'proveedor', 'categoria'); // Cargamos también la categoría
    return view('productos.show', compact('producto'));
}


    // Formulario editar producto
   public function edit(Producto $producto)
{
    $talles = Talle::all();
    $proveedores = Proveedor::orderBy('nombre')->get();
    $categorias = Categoria::orderBy('nombre')->get(); // Cargamos categorías
    $producto->load('talles', 'categoria'); // Incluimos categoría en el producto

     // Filtrar talles según la categoría del producto
    $talles = [];
    if ($producto->categoria && $producto->categoria->usa_talle) {
        $talles = Talle::where('tipo', $producto->categoria->tipo_talle)->get();
    }
    return view('productos.edit', compact('producto', 'talles', 'proveedores', 'categorias'));
}




    
    // Mostrar productos eliminados (soft deleted)
   public function eliminados()
{
    $query = Producto::onlyTrashed()->with('talles', 'categoria')->orderBy('deleted_at', 'desc');

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
        'categoria_id' => 'required|exists:categorias,id', // NUEVO
    ]);

    $producto = Producto::create([
        'nombre' => $request->nombre,
        'codigo' => $request->codigo,
        'precio_base' => $request->precio_base,
        'categoria_id' => $request->categoria_id,
        // Agregá otros campos que uses o valores por defecto
    ]);

    return redirect()->back()->with('success', 'Producto agregado correctamente');

    // Para ajax:
    // return response()->json(['producto' => $producto]);
}



   public function aplicarRecargo(Request $request, Producto $producto)
{
    $request->validate([
        'recargo' => 'required|numeric|min:0',
    ]);

    try {
        $producto->load('categoria'); // Cargamos la categoría por si se necesita

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

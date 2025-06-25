<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Talle;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    //Abba-app\app\Http\Controllers\ProductoController.php
    // Mostrar productos activos
    public function index()
{
    $productos = Producto::with('talles') // carga los talles con pivot
                         ->whereNull('deleted_at')
                         ->orderBy('created_at', 'desc')
                         ->get();

    return view('productos.index', compact('productos'));
}


    // Mostrar productos eliminados (soft deleted)
    public function eliminados()
    {
        $productosEliminados = Producto::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('productos.eliminados', compact('productosEliminados'));
    }

    // Formulario para nuevo producto
    public function create()
    {
        $talles = Talle::all();
        return view('productos.create', compact('talles'));
    }

    // Guardar producto nuevo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:productos,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock_minimo' => 'nullable|integer|min:0', // ahora es opcional
            'activo' => 'required|boolean',
            'talles' => 'nullable|array',
            'talles.*.id' => 'required|exists:talles,id',
            'talles.*.stock' => 'required|integer|min:0',
        ]);

        $datosProducto = collect($validated)->except('talles')->toArray(); // solo los campos del producto
$producto = Producto::create($datosProducto);

        if (!empty($validated['talles'])) {
            $syncData = [];
            foreach ($validated['talles'] as $item) {
                $syncData[$item['id']] = ['stock' => $item['stock']];
            }
            $producto->talles()->sync($syncData);
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
    }

    // Mostrar detalle de producto
    public function show(Producto $producto)
    {
        $producto->load('talles');
        return view('productos.show', compact('producto'));
    }

    // Formulario editar producto
    public function edit(Producto $producto)
    {
        $talles = Talle::all();
        $producto->load('talles');
        return view('productos.edit', compact('producto', 'talles'));
    }

    // Actualizar producto
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'activo' => 'required|boolean',
            'talles' => 'nullable|array',
            'talles.*.id' => 'required|exists:talles,id',
            'talles.*.stock' => 'required|integer|min:0',
        ]);

        $producto->update($validated);

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
}

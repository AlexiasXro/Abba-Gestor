<?php

namespace App\Http\Controllers;
use App\Models\Configuracion;
use App\Models\Producto;


use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
   public function editarMargenes()
{
    $margenVenta = Configuracion::getValor('margen_venta', 30);
    $margenReventa = Configuracion::getValor('margen_reventa', 15);
    return view('configuracion.margenes', compact('margenVenta', 'margenReventa'));
}

public function actualizarMargenes(Request $request)
{
    $request->validate([
        'margen_venta' => 'required|numeric|min:0|max:100',
        'margen_reventa' => 'required|numeric|min:0|max:100',
    ]);

    Configuracion::updateOrCreate(['clave' => 'margen_venta'], ['valor' => $request->margen_venta]);
    Configuracion::updateOrCreate(['clave' => 'margen_reventa'], ['valor' => $request->margen_reventa]);

    return redirect()->back()->with('success', 'Márgenes actualizados correctamente.');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required',
        'codigo' => 'nullable|string',
        'precio_base' => 'required|numeric|min:0',
        'precio_venta' => 'nullable|numeric|min:0',
        'precio_reventa' => 'nullable|numeric|min:0',
        // otros campos...
    ]);

    $precioBase = $validated['precio_base'];

    // Si no se ingresan los precios, calcular usando márgenes del sistema
    if (empty($validated['precio_venta'])) {
        $margenVenta = Configuracion::getNumero('margen_venta', 30);
        $validated['precio_venta'] = round($precioBase + ($precioBase * $margenVenta / 100), 2);
    }

    if (empty($validated['precio_reventa'])) {
        $margenReventa = Configuracion::getNumero('margen_reventa', 15);
        $validated['precio_reventa'] = round($precioBase + ($precioBase * $margenReventa / 100), 2);
    }

    Producto::create($validated);

    return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
}
}


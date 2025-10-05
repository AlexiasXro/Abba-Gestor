<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $categorias = Categoria::orderBy('nombre')->paginate(15); // o el número que prefieras

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:categorias,nombre',
            'usa_talle' => 'required|boolean',
            'tipo_talle' => 'nullable|string|in:calzado,ropa,niño,unico,adulto,juvenil,bebé',
        ]);

        Categoria::create($request->only('nombre', 'usa_talle', 'tipo_talle'));

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:categorias,nombre,' . $categoria->id,
            'usa_talle' => 'required|boolean',
            'tipo_talle' => 'nullable|string|in:calzado,ropa,niño,unico,adulto,juvenil,bebé',
        ]);

        $categoria->update($request->only('nombre', 'usa_talle', 'tipo_talle'));

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}


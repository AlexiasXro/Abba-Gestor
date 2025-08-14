<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //Abba-app/app/Http/Controllers/ClienteController.php
    // Mostrar todos los clientes activos
    public function index(Request $request)
    {
        $clientes = Cliente::latest()->get();
        // Obtener valor del filtro
         $filtro = $request->input('filtro');

        $clientes = Cliente::query() // <- ya no necesita \App\Models
            ->when($filtro, function ($query, $filtro) {
                $query->where('nombre', 'like', "%{$filtro}%")
                      ->orWhere('apellido', 'like', "%{$filtro}%")
                      ->orWhere('email', 'like', "%{$filtro}%");
            })
            ->orderBy('apellido')
            ->paginate(15);

        return view('clientes.index', [
            'clientes' => $clientes,
            'filtro' => $filtro
        ]);
    }

    

    // Mostrar clientes eliminados (soft deleted)
    public function eliminados()
    {
        $clientesEliminados = Cliente::onlyTrashed()->get();
        return view('clientes.eliminados', compact('clientesEliminados'));
    }

    // Formulario de creación
    public function create()
    {
        return view('clientes.create');
    }

    // Guardar cliente nuevo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:clientes,email',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente = Cliente::create($validated);

        return redirect()->route('clientes.show', $cliente->id)
                         ->with('success', 'Cliente creado correctamente.');
    }

    // Mostrar cliente
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    // Formulario de edición
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar cliente
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $cliente->id,
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.show', $cliente->id)
                         ->with('success', 'Cliente actualizado correctamente.');
    }

    // Soft delete del cliente
    public function destroy(Cliente $cliente)
    {
        $cliente->delete(); // ahora es soft delete
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente eliminado correctamente.');
    }

    // Restaurar un cliente eliminado
    public function restaurar($id)
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente restaurado correctamente.');
    }




    // Registro rápido de clientes en views/ventas/create
   public function rapido(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'dni' => 'nullable|string|max:20',
        'telefono' => 'nullable|string|max:20',
    ]);

    $clienteNuevo = Cliente::create($validated);

    return response()->view('clientes.partials.option', ['cliente' => $clienteNuevo]);
}



 // Búsqueda de clientes al vender. views/ventas/create
public function buscar(Request $request)
{
    $query = $request->input('query');

    $clientes = Cliente::where('nombre', 'like', "%{$query}%")
        ->orWhere('apellido', 'like', "%{$query}%")
        ->orWhere('dni', 'like', "%{$query}%")
        ->orWhere('telefono', 'like', "%{$query}%")
        ->limit(10)
        ->get();

    return response()->json($clientes);
}

// HISTORIAL DE LOS CLIENTE Y LO QUE COMPRARON 
public function historial(Request $request)
{
    $filtros = $request->only([
        'cliente', 'numero_venta', 'estado', 'metodo_pago', 
        'fecha_desde', 'fecha_hasta', 'monto_min', 'monto_max'
    ]);

    $ventas = Venta::query()
        ->when($filtros['cliente'] ?? null, function($q, $cliente) {
            $q->whereHas('cliente', function($q2) use ($cliente) {
                $q2->where('nombre', 'like', "%$cliente%")
                   ->orWhere('apellido', 'like', "%$cliente%")
                   ->orWhere('dni', 'like', "%$cliente%")
                   ->orWhere('telefono', 'like', "%$cliente%");
            });
        })
        ->when($filtros['numero_venta'] ?? null, fn($q, $num) => $q->where('id', $num))
        ->when($filtros['estado'] ?? null, fn($q, $estado) => $q->where('estado', $estado))
        ->when($filtros['metodo_pago'] ?? null, fn($q, $mp) => $q->where('metodo_pago', $mp))
        ->when($filtros['fecha_desde'] ?? null, fn($q, $fd) => $q->whereDate('created_at', '>=', $fd))
        ->when($filtros['fecha_hasta'] ?? null, fn($q, $fh) => $q->whereDate('created_at', '<=', $fh))
        ->when($filtros['monto_min'] ?? null, fn($q, $min) => $q->where('total', '>=', $min))
        ->when($filtros['monto_max'] ?? null, fn($q, $max) => $q->where('total', '<=', $max))
        ->orderBy('created_at', 'desc')
        ->paginate(15)
        ->withQueryString(); // mantiene los filtros en la paginación

    return view('clientes.historial', [
        'ventas' => $ventas,
        'filtros' => $filtros
    ]);
}
}





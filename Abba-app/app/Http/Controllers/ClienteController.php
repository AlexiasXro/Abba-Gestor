<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    //Abba-app/app/Http/Controllers/ClienteController.php
    // Mostrar todos los clientes activos
    public function index()
    {
        $clientes = Cliente::latest()->get();
        return view('clientes.index', compact('clientes'));
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
    // Recibo filtros
    $clienteQuery = $request->input('cliente'); // nombre, dni, teléfono
    $fechaDesde = $request->input('fecha_desde');
    $fechaHasta = $request->input('fecha_hasta');
    $estado = $request->input('estado');
    $metodoPago = $request->input('metodo_pago');
    $montoMin = $request->input('monto_min');
    $montoMax = $request->input('monto_max');
    $numeroVenta = $request->input('numero_venta');

    $ventas = Venta::query();

    // Filtrar por cliente (buscar en nombre, dni o teléfono)
    if ($clienteQuery) {
        $clientesIds = Cliente::where('nombre', 'like', "%$clienteQuery%")
            ->orWhere('dni', 'like', "%$clienteQuery%")
            ->orWhere('telefono', 'like', "%$clienteQuery%")
            ->pluck('id');

        $ventas->whereIn('cliente_id', $clientesIds);
    }

    // Filtrar por número de venta (id o código)
    if ($numeroVenta) {
        $ventas->where('id', $numeroVenta);
    }

    // Filtrar por estado si existe
    if ($estado) {
        $ventas->where('estado', $estado);
    }

    // Filtrar por método de pago si existe
    if ($metodoPago) {
        $ventas->where('metodo_pago', $metodoPago);
    }

    // Filtrar por rango de fechas
    if ($fechaDesde) {
        $ventas->whereDate('created_at', '>=', $fechaDesde);
    }
    if ($fechaHasta) {
        $ventas->whereDate('created_at', '<=', $fechaHasta);
    }

    // Filtrar por rango de monto
    if ($montoMin) {
        $ventas->where('total', '>=', $montoMin);
    }
    if ($montoMax) {
        $ventas->where('total', '<=', $montoMax);
    }

    $ventas = $ventas->orderBy('created_at', 'desc')->paginate(10);

    // Para mantener los filtros en la vista
    $filtros = $request->only([
        'cliente', 'fecha_desde', 'fecha_hasta', 'estado', 'metodo_pago', 'monto_min', 'monto_max', 'numero_venta'
    ]);

    return view('clientes.historial', compact('ventas', 'filtros'));
}



}

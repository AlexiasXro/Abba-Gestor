<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    /**
     * Muestra un listado de todos los gastos, ordenados por fecha descendente.
     */
    public function index(Request $request)
    {
        // Inicia una consulta sobre el modelo Gasto
    $query = Gasto::query();

    // Si se especificó una fecha "desde", se aplica el filtro correspondiente
    if ($request->filled('desde')) {
        $query->whereDate('fecha', '>=', $request->desde);
    }

    // Si se especificó una fecha "hasta", se aplica ese filtro también
    if ($request->filled('hasta')) {
        $query->whereDate('fecha', '<=', $request->hasta);
    }

    // Recupera los gastos ordenados del más reciente al más antiguo (con filtros si existen)
    $gastos = $query->orderByDesc('fecha')->get();

    // Devuelve la vista con la lista de gastos filtrada o completa
    return view('gastos.index', compact('gastos'));
    }

    /**
     * Muestra el formulario para crear un nuevo gasto.
     */
    public function create()
    {
        // Devuelve la vista del formulario de creación
        return view('gastos.create');
    }

    /**
     * Guarda un nuevo gasto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'fecha' => 'required|date',                  // La fecha es obligatoria y debe tener formato válido
            'monto' => 'required|numeric|min:0.01',      // El monto es obligatorio, numérico y mayor a cero
            'descripcion' => 'nullable|string',          // La descripción es opcional y debe ser texto
            'categoria' => 'nullable|string',            // La categoría también es opcional
            'metodo_pago' => 'required|string',

        ]);
        

        // Crea un nuevo registro de gasto con los datos validados
        Gasto::create($request->all());

        // Redirige al listado de gastos con un mensaje de éxito
        return redirect()->route('gastos.index')->with('success', 'Gasto registrado.');
    }

    /**
     * Muestra el detalle de un gasto específico.
     */
    public function show(Gasto $gasto)
    {
        // Devuelve la vista con los datos del gasto individual
        return view('gastos.show', compact('gasto'));
    }

    public function destroy(Gasto $gasto)
{
    $gasto->delete();
    return redirect()->route('gastos.index')->with('success', 'Gasto eliminado.');
}

}

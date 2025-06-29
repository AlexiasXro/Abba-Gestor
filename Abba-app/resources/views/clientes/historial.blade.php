@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Historial de ventas</h1>

    <form method="GET" action="{{ route('clientes.historial') }}" class="mb-4">

        <div class="row g-3">

            <div class="col-md-3">
                <label>Cliente (nombre, DNI, teléfono)</label>
                <input type="text" name="cliente" value="{{ $filtros['cliente'] ?? '' }}" class="form-control" />
            </div>

            <div class="col-md-3">
                <label>Número de venta</label>
                <input type="text" name="numero_venta" value="{{ $filtros['numero_venta'] ?? '' }}"
                    class="form-control" />
            </div>

            <div class="col-md-3">
                <label>Estado</label>
                <select name="estado" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="pagado"
                        {{ (isset($filtros['estado']) && $filtros['estado'] == 'pagado') ? 'selected' : '' }}>Pagado
                    </option>
                    <option value="pendiente"
                        {{ (isset($filtros['estado']) && $filtros['estado'] == 'pendiente') ? 'selected' : '' }}>
                        Pendiente</option>
                    <option value="anulado"
                        {{ (isset($filtros['estado']) && $filtros['estado'] == 'anulado') ? 'selected' : '' }}>Anulado
                    </option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Método de pago</label>
                <select name="metodo_pago" class="form-select">
                    <option value="">-- Todos --</option>
                    <option value="efectivo"
                        {{ (isset($filtros['metodo_pago']) && $filtros['metodo_pago'] == 'efectivo') ? 'selected' : '' }}>
                        Efectivo</option>
                    <option value="tarjeta"
                        {{ (isset($filtros['metodo_pago']) && $filtros['metodo_pago'] == 'tarjeta') ? 'selected' : '' }}>
                        Tarjeta</option>
                    <!-- Añadí más métodos según tu sistema -->
                </select>
            </div>

            <div class="col-md-3">
                <label>Fecha desde</label>
                <input type="date" name="fecha_desde" value="{{ $filtros['fecha_desde'] ?? '' }}"
                    class="form-control" />
            </div>

            <div class="col-md-3">
                <label>Fecha hasta</label>
                <input type="date" name="fecha_hasta" value="{{ $filtros['fecha_hasta'] ?? '' }}"
                    class="form-control" />
            </div>

            <div class="col-md-3">
                <label>Monto mínimo</label>
                <input type="number" name="monto_min" value="{{ $filtros['monto_min'] ?? '' }}" step="0.01"
                    class="form-control" />
            </div>

            <div class="col-md-3">
                <label>Monto máximo</label>
                <input type="number" name="monto_max" value="{{ $filtros['monto_max'] ?? '' }}" step="0.01"
                    class="form-control" />
            </div>

        </div>

        <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
        <a href="{{ route('clientes.historial') }}" class="btn btn-secondary mt-3 ms-2">Limpiar</a>
    </form>

    @if($ventas->isEmpty())
    <p>No se encontraron ventas con esos filtros.</p>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>N° Venta</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Método de pago</th>
                <th>Total</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr @if($venta->estado === 'anulada') class="table-danger" @endif>
                <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->cliente->nombre ?? 'Cliente no encontrado' }}</td>
                <td>
                    @if($venta->estado === 'anulada')
                    <span class="badge bg-danger">Anulada</span>
                    @else
                    {{ ucfirst($venta->estado) }}
                    @endif
                </td>
                <td>{{ ucfirst($venta->metodo_pago) }}</td>
                <td>
                    @if($venta->estado === 'anulada')
                    <del>${{ number_format($venta->total, 2) }}</del>
                    @else
                    ${{ number_format($venta->total, 2) }}
                    @endif
                </td>
                <td><a href="{{ route('ventas.show', $venta) }}">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>


    {{ $ventas->withQueryString()->links() }}

    @endif
</div>
@endsection
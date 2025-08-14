@extends('layouts.app')

@section('content')
<x-header-bar title="Historial de Clientes" :buttons="[
    ['text' => 'Nuevo Cliente', 'route' => route('clientes.create'), 'class' => 'btn-primary'],
    ['text' => 'Ver Eliminados', 'route' => route('clientes.eliminados'), 'class' => 'btn-secondary']
]" filterName="filtro" :filterValue="$filtro ?? ''" filterPlaceholder="Buscar por nombre, apellido o email"
    :filterRoute="route('clientes.historial')" />

    <form method="GET" action="{{ route('clientes.historial') }}" class="mb-3">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">
        
        {{-- Cliente --}}
        <div class="col">
            <input type="text" name="cliente" 
                   value="{{ $filtros['cliente'] ?? '' }}" 
                   class="form-control form-control-sm" 
                   placeholder="Cliente (nombre, DNI, teléfono)">
        </div>

        {{-- Número de venta --}}
        <div class="col">
            <input type="text" name="numero_venta" 
                   value="{{ $filtros['numero_venta'] ?? '' }}" 
                   class="form-control form-control-sm" 
                   placeholder="N° Venta">
        </div>

        {{-- Estado --}}
        <div class="col">
            <select name="estado" class="form-select form-select-sm">
                <option value="">-- Estado --</option>
                <option value="pagado" {{ ($filtros['estado'] ?? '') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="pendiente" {{ ($filtros['estado'] ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="anulado" {{ ($filtros['estado'] ?? '') == 'anulado' ? 'selected' : '' }}>Anulado</option>
            </select>
        </div>

        {{-- Método de pago --}}
        <div class="col">
            <select name="metodo_pago" class="form-select form-select-sm">
                <option value="">-- Método --</option>
                <option value="efectivo" {{ ($filtros['metodo_pago'] ?? '') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="tarjeta" {{ ($filtros['metodo_pago'] ?? '') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
            </select>
        </div>

        {{-- Fecha desde --}}
        <div class="col">
            <input type="date" name="fecha_desde" 
                   value="{{ $filtros['fecha_desde'] ?? '' }}" 
                   class="form-control form-control-sm">
        </div>

        {{-- Fecha hasta --}}
        <div class="col">
            <input type="date" name="fecha_hasta" 
                   value="{{ $filtros['fecha_hasta'] ?? '' }}" 
                   class="form-control form-control-sm">
        </div>

        {{-- Monto mínimo --}}
        <div class="col">
            <input type="number" name="monto_min" step="0.01"
                   value="{{ $filtros['monto_min'] ?? '' }}" 
                   class="form-control form-control-sm" 
                   placeholder="Monto min">
        </div>

        {{-- Monto máximo --}}
        <div class="col">
            <input type="number" name="monto_max" step="0.01"
                   value="{{ $filtros['monto_max'] ?? '' }}" 
                   class="form-control form-control-sm" 
                   placeholder="Monto max">
        </div>
    </div>

    {{-- Botones --}}
    <div class="mt-2 d-flex flex-wrap gap-2">
        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        <a href="{{ route('clientes.historial') }}" class="btn btn-secondary btn-sm">Limpiar</a>
    </div>
</form>

<div class="container">

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
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Historial de Ventas</h2>

    <table class="table table-striped mt-3">
    <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Pagado</th>
            <th>Vuelto</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ventas as $venta)
        <tr @if($venta->estado === 'anulada') class="table-danger" @endif>
            <td>{{ $venta->id }}</td>
            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $venta->cliente->nombre ?? 'Sin nombre' }}</td>
            <td>
                @if($venta->estado === 'anulada')
                    <del>${{ number_format($venta->total, 2) }}</del>
                    <span class="badge bg-danger">Anulada</span>
                @else
                    ${{ number_format($venta->total, 2) }}
                @endif
            </td>
            <td>${{ number_format($venta->monto_pagado, 2) }}</td>
            <td>${{ number_format($venta->monto_pagado - $venta->total, 2) }}</td>
            <td>
                <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-sm btn-info">Ver</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection

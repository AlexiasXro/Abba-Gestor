@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Detalle de Devolución #{{ $devolucion->id }}</h4>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $devolucion->venta->cliente->nombre ?? 'Sin cliente' }}</p>
            <p><strong>Producto:</strong> {{ $devolucion->producto->nombre ?? 'N/D' }}</p>
            <p><strong>Talle:</strong> {{ $devolucion->talle->talle ?? 'N/D' }}</p>
            <p><strong>Cantidad:</strong> {{ $devolucion->cantidad }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($devolucion->tipo) }}</p>
           <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($devolucion->fecha)->format('d/m/Y') }}</p>

            <p><strong>Estado:</strong>
                <span class="badge {{ $devolucion->estado == 'activa' ? 'bg-success' : 'bg-danger' }}">
                    {{ ucfirst($devolucion->estado) }}
                </span>
            </p>
            <p><strong>Motivo:</strong> {{ $devolucion->motivo_texto }}</p>
            @if($devolucion->observaciones)
                <p><strong>Observaciones:</strong> {{ $devolucion->observaciones }}</p>
            @endif
            <p><strong>Registrada por:</strong> {{ $devolucion->usuario->name ?? 'Sistema' }}</p>
        </div>
    </div>

    <a href="{{ route('devoluciones.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection

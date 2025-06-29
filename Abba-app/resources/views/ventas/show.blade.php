@extends('layouts.app')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-8">
            <h1>Detalle de Venta #{{ $venta->id }}</h1>
            <p><small>Fecha: {{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</small></p>
        </div>
        <div class="col-4 text-end">
            <button class="btn btn-primary no-print" onclick="window.print()">Imprimir Ticket</button>
        </div>
    </div>

    <div class="card mb-4 admin-info">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información de la Venta</h5>
                    <p><strong>Método de Pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
                    @if($venta->metodo_pago === 'efectivo')
                    <p><strong>Monto Pagado:</strong> ${{ number_format($venta->monto_pagado, 2) }}</p>
                    <p><strong>Vuelto:</strong> ${{ number_format($venta->monto_pagado - $venta->total, 2) }}</p>
                    @elseif($venta->metodo_pago === 'tarjeta')
                    <p><strong>Tipo de Tarjeta:</strong> {{ ucfirst($venta->tipo_tarjeta ?? 'N/A') }}</p>
                    @elseif($venta->metodo_pago === 'transferencia')
                    <p><strong>Número de Operación:</strong> {{ $venta->numero_operacion ?? 'N/A' }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h5>Cliente</h5>
                    @if($venta->cliente)
                    <p><strong>Nombre:</strong> {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</p>
                    <p><strong>Teléfono:</strong> {{ $venta->cliente->telefono ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $venta->cliente->email ?? 'N/A' }}</p>
                    @else
                    <p>Cliente no registrado</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Tabla productos para admin -->
    <div class="card admin-info">
        <div class="card-body">
            <h5>Productos Detallados</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Talle</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->talle->talle }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>${{ number_format($detalle->descuento, 2) }}</td>
                        <td>${{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Subtotal:</th>
                        <td>${{ number_format($venta->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-end">Descuento Global:</th>
                        <td>${{ number_format($venta->descuento, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-end">Total:</th>
                        <td>${{ number_format($venta->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<!--Venta anulada?-->
    @if ($venta->estado !== 'anulada')
    <form action="{{ route('ventas.anular', $venta) }}" method="POST" class="mt-3">
        @csrf
        @method('PATCH')

        <div class="mb-2">
            <label for="motivo">Motivo de anulación:</label>
            <textarea name="motivo_anulacion" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Anular venta</button>
    </form>
    @else
    <div class="alert alert-danger mt-3">
        Esta venta fue anulada.<br>
        <strong>Motivo:</strong> {{ $venta->motivo_anulacion }}
    </div>
    @endif

    <!-- Tabla simplificada para impresión, solo datos esenciales -->
    <div class="card print-only" style="display:none;">
        <div class="card-body">
            <h5>Productos</h5>
            <table class="table" style="border:none;">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($venta->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>${{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <td>${{ number_format($venta->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
            <p><strong>Método de Pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
            @if($venta->metodo_pago === 'efectivo')
            <p><strong>Monto Pagado:</strong> ${{ number_format($venta->monto_pagado ?? 0, 2) }}</p>
            <p><strong>Vuelto:</strong> ${{ number_format(($venta->monto_pagado ?? 0) - $venta->total, 2) }}</p>
            @endif
            <p>Gracias por su compra!</p>
        </div>
    </div>

</div>

<style>
/* Ocultar info de admin al imprimir */
@media print {
    .no-print {
        display: none !important;
    }

    .admin-info {
        display: none !important;
    }

    .print-only {
        display: block !important;
    }
}
</style>
@endsection
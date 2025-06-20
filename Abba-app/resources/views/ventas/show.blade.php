@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1>Detalle de Venta #{{ $venta->id }}</h1>
            <button class="btn btn-primary" onclick="window.print()">Imprimir Ticket</button>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Información de la Venta</h5>
                    <p><strong>Fecha:</strong> {{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
                    <p><strong>Método de Pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Cliente</h5>
                    @if($venta->cliente)
                        <p><strong>Nombre:</strong> {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</p>
                        <p><strong>Teléfono:</strong> {{ $venta->cliente->telefono ?? 'N/A' }}</p>
                    @else
                        <p>Cliente no registrado</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h5>Productos</h5>
            <table class="table">
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
</div>

<!-- Estilo para impresión -->
<style media="print">
    body * {
        visibility: hidden;
    }
    .container, .container * {
        visibility: visible;
    }
    .container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
    .card {
        border: none;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid #ddd;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
</style>
@endsection
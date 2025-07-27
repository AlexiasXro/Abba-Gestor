@extends('layouts.app')

@section('content')
    <h1>Detalle de Compra</h1>

    <div class="mb-3">
        <strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}<br>
        <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}<br>
        <strong>Método de pago:</strong> {{ $compra->metodo_pago ?? '-' }}
    </div>

    <h4>Productos Comprados</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Talle</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($compra->detalles as $detalle)
                @php
                    $subtotal = $detalle->cantidad * $detalle->precio_unitario;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->talle->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>${{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total</th>
                <th>${{ number_format($total, 2) }}</th>
            </tr>
        </tfoot>
    </table>

     <div class="d-flex justify-content-between">
        <a href="{{ route('compras.index') }}" class="btn btn-secondary">Volver</a>

        {{-- 🔜 Este botón funcionará cuando integremos DomPDF --}}
        <a href="#" class="btn btn-outline-primary disabled" title="Pendiente de PDF">
            Exportar a PDF
        </a>
    </div>
@endsection

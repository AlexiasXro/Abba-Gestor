@extends('layouts.app')


@section('content')

    <!-- alerta -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <!--fin alerta -->

    <div class="container mt-1">

        <!-- ENCABEZADO -->
        <div class="row mb-4 align-items-center  no-print">
            <div class="col-md-8 d-flex align-items-center">
                <img src="{{ asset('images/AbbaShoes Positive.svg') }}" alt="Logo Tienda" style="max-height: 60px;"
                    class="me-3">
                <div>
                    <h5 class="mb-0">Detalle de Venta #{{ $venta->id }}</h5>
                    <small class="text-muted">Fecha:
                        {{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</small>
                </div>
            </div>
            <div class="col-md-4 text-md-end text-start mt-3 mt-md-0">
                <button class="btn btn-primary no-print" onclick="window.print()">Imprimir Ticket</button>
            </div>
        </div>


        <!-- RESUMEN DE VENTA Y CLIENTE -->
        <div class="card mb-3 admin-info">
            <div class="card-body">
                <h5 class="mb-3">Resumen</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Método de Pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
                        @if($venta->metodo_pago === 'efectivo')
                            <p class="mb-1"><strong>Monto Pagado:</strong> ${{ number_format($venta->monto_pagado, 2) }}</p>
                            <p class="mb-1"><strong>Vuelto:</strong>
                                ${{ number_format($venta->monto_pagado - $venta->total, 2) }}</p>
                        @elseif($venta->metodo_pago === 'tarjeta')
                            <p class="mb-1"><strong>Tipo de Tarjeta:</strong> {{ ucfirst($venta->tipo_tarjeta ?? 'N/A') }}</p>
                        @elseif($venta->metodo_pago === 'transferencia')
                            <p class="mb-1"><strong>Operación:</strong> {{ $venta->numero_operacion ?? 'N/A' }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($venta->cliente)
                            <p class="mb-1"><strong>Cliente:</strong> {{ $venta->cliente->nombre }}
                                {{ $venta->cliente->apellido }}</p>
                            <p class="mb-1"><strong>Teléfono:</strong> {{ $venta->cliente->telefono ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $venta->cliente->email ?? 'N/A' }}</p>
                        @else
                            <p>Cliente no registrado</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- DETALLE DE CUOTAS -->
        @if($venta->metodo_pago === 'cuotas')
            <div class="card admin-info mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Detalle de Cuotas</h5>
                    @if($venta->cuotas->count())
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>Cuota #</th>
                                    <th>Monto</th>
                                    <th>Vencimiento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($venta->cuotas as $cuota)
                                    <tr>
                                        <td>{{ $cuota->numero }}</td>
                                        <td>${{ number_format($cuota->monto, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($cuota->pagada)
                                                <span class="badge bg-success">Pagada</span>
                                            @elseif(\Carbon\Carbon::parse($cuota->fecha_vencimiento)->isPast())
                                                <span class="badge bg-danger">Vencida</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay cuotas registradas para esta venta.</p>
                    @endif
                </div>
            </div>
        @endif

        <!-- DETALLE DE PRODUCTOS -->
        <div class="card admin-info mb-4">
            <div class="card-body">
                <h5 class="mb-3">Productos Detallados</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Producto</th>
                            <th>Talle</th>
                            <th>Cant.</th>
                            <th>P.Unit</th>
                            <th>Desc.</th>
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
                                <td>
                                    ${{ number_format($detalle->subtotal, 2) }}

                                    @if ($venta->estado !== 'anulada')
                                        <a href="{{ route('devoluciones.create') }}?venta_id={{ $venta->id }}&producto_id={{ $detalle->producto_id }}&talle_id={{ $detalle->talle_id }}"
                                            class="btn btn-sm btn-warning d-block mt-2">
                                            Registrar devolución
                                        </a>
                                    @endif
                                </td>
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

        <!-- ANULACIÓN -->
        @if ($venta->estado !== 'anulada')
            <div class="card admin-info">
                <div class="card-body">
                    <form action="{{ route('ventas.anular', $venta) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label for="motivo_anulacion" class="form-label">Motivo de anulación</label>
                        <textarea name="motivo_anulacion" class="form-control mb-2" rows="2" required></textarea>
                        <button type="submit" class="btn btn-danger">Anular venta</button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-danger mt-3">
                <strong>Venta Anulada.</strong><br>
                Motivo: {{ $venta->motivo_anulacion }}
            </div>
        @endif
        {{-- Aquí incluís el partial del ticket para impresión --}}
        @include('ventas.partials.print-ticket')
    </div>



@endsection
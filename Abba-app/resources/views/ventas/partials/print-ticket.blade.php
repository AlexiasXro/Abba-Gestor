<!-- Bloque para impresión optimizado en una sola hoja Abba-app\resources\views\ventas\partials\print-ticket.blade.php -->
<div class="card print-only" style="display:none; font-size: 11px; line-height: 1.2;">
    <div class="card-body">

        <!-- Encabezado con logo + empresa + tipo factura -->
        <div
            class="encabezado-factura d-flex justify-content-between align-items-center mb-4 p-3 rounded shadow-sm bg-light">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('images/AbbaShoes Positive.svg') }}" alt="Logo Tienda" class="logo-tienda">
                <div class="info-empresa">
                    <strong class="fs-5 text-primary">Zapatería</strong><br>
                    <small class="text-muted">
                        Av. Siempre Viva 123, Buenos Aires<br>
                        CUIT: 30-12345678-9<br>
                        Responsable Inscripto
                    </small>
                </div>
            </div>
            <div class="factura-b-label px-4 py-2 rounded text-white fw-bold">
                FACTURA B
            </div>
        </div>

        <!-- Comprobante -->
        <div class="mb-2" style="font-size: 10px;">
            <p><strong>Punto de Venta:</strong> 0001</p>
            <p><strong>Comprobante N°:</strong> {{ str_pad($venta->id, 8, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Cliente -->
        @if($venta->cliente)
            <div class="mb-2" style="font-size: 10px;">
                <p><strong>Cliente:</strong> {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</p>
                @if($venta->cliente->telefono)
                    <p><strong>Teléfono:</strong> {{ $venta->cliente->telefono }}</p>
                @endif
            </div>
        @endif

        <!-- Productos -->
        <h6 class="mb-1">Detalle de productos</h6>
        <table class="table table-sm table-bordered mb-2" style="font-size: 10px;">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th>P.Unit</th>
                    <th>Subt.</th>
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

        <!-- Cuotas si corresponde -->
        @if($venta->metodo_pago === 'cuotas')
            <h6 class="mb-1">Cuotas</h6>
            @foreach($venta->cuotas as $cuota)
                <p class="mb-0" style="font-size: 10px;">#{{ $cuota->numero }} - ${{ number_format($cuota->monto, 2) }} - Vence:
                    {{ \Carbon\Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y') }} -
                    @if($cuota->pagada) Pagada
                    @elseif(\Carbon\Carbon::parse($cuota->fecha_vencimiento)->isPast()) Vencida
                        @else Pendiente
                    @endif
                </p>
            @endforeach
        @endif

        <!-- Pago -->
        <p class="mt-2" style="font-size: 10px;"><strong>Método de Pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
        @if($venta->metodo_pago === 'efectivo')
            <p style="font-size: 10px;"><strong>Monto Pagado:</strong> ${{ number_format($venta->monto_pagado, 2) }}</p>
            <p style="font-size: 10px;"><strong>Vuelto:</strong>
                ${{ number_format($venta->monto_pagado - $venta->total, 2) }}</p>
        @endif

        <!-- Anulada -->
        @if($venta->estado === 'anulada')
            <p style="font-weight: bold; color: gray; font-size: 1.1em;">FACTURA ANULADA</p>
        @endif

        <!-- Pie -->
        <div class="text-center mt-2">
            <img src="{{ asset('images/codigo_ejemplo.svg') }}" alt="Código" style="max-height: 60px;">
            <p style="font-size: 8px;">Gracias por su compra</p>
        </div>
    </div>
</div>
<style>
    .encabezado-factura {
        background-color: #f9fafb;
        /* tono muy suave */
        border: 1px solid #ddd;
        font-size: 14px !important;
        padding: 12px !important;
    }

    .logo-tienda {

        object-fit: contain;
        max-height: 80px !important;
    }

    .info-empresa {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.3;
        user-select: none;
    }

    .factura-b-label {
        background: linear-gradient(135deg, #007bff, #0056b3);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        white-space: nowrap;
        user-select: none;
        font-size: 1.5rem !important;
        /* Más grande y destacado */
        padding: 12px 30px !important;
    }


    @media print {
        .no-print {
            display: none !important;
        }

        .admin-info {
            display: none !important;
        }

        .print-only {
            display: block !important;
            font-size: 12px !important;
            /* Fuente un poco más grande */
            line-height: 1.4 !important;
            /* Mejor separación entre líneas */
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 12px !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .table th,
        .table td {
            padding: 6px 8px !important;
            /* Más espacio en celdas para legibilidad */
            font-size: 12px !important;
        }


    }
</style>
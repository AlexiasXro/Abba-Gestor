@extends('layouts.app')
@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
        <p><strong>Ups!</strong> Hay errores con los datos ingresados:</p>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <div class="container">
        <h1>Nueva Venta</h1>

        <form method="POST" action="{{ route('ventas.store') }}">
            @csrf

            <!-- Input de búsqueda -->
            <div class="col-md-6">
                <label for="busqueda_cliente" class="form-label">Buscar Cliente</label>
                <input type="text" id="busqueda_cliente" class="form-control" placeholder="Nombre, DNI o Teléfono">
            </div>

            <!-- Select de cliente -->
            <div class="col-md-6">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-select" id="cliente_id" name="cliente_id">
                    <option value="">-- Seleccionar cliente --</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-sm btn-link" data-bs-toggle="modal"
                    data-bs-target="#modalNuevoCliente">
                    + Nuevo cliente
                </button>
            </div>

            <!--Total de productos sumados-->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label"><strong>Total estimado:</strong></label>
                    <input type="text" id="total_mostrado" class="form-control" readonly value="$0.00">
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-12">
                    <h4>Productos</h4>
                    <div id="productos-container">
                        <!-- Los productos se agregarán aquí dinámicamente con JavaScript -->
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="agregar-producto">
                        Agregar Producto
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="metodo_pago" class="form-label">Método de Pago</label>
                    <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                        <option value="">-- Seleccionar método --</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="transferencia">Transferencia</option>
                        <!-- FALTA ESTA: -->
                        <option value="cuotas">Pago en Cuotas</option>
                    </select>
                </div>

                <!-- FORMULARIO CUOTAS -->
                <div id="cuotas-container" class="d-none">
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="entrega_inicial" class="form-label">Entrega Inicial</label>
                            <input type="number" class="form-control" name="entrega_inicial" id="entrega_inicial" min="0"
                                step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label for="cantidad_cuotas" class="form-label">Cantidad de Cuotas</label>
                            <input type="number" class="form-control" name="cantidad_cuotas" id="cantidad_cuotas" min="1"
                                value="2">
                        </div>
                    </div>
                </div>

                <!-- RESUMEN DE CUOTAS -->
                <div id="resumen-cuotas" class="mt-3 d-none">
                    <div class="alert alert-info">
                        <strong>Resumen de Cuotas:</strong><br>
                        Entrega Inicial: <span id="resumen-entrega">$0.00</span><br>
                        Cuota Final (ganancia): <span id="resumen-cuota-final">$0.00</span><br>
                        Total Venta: <span id="resumen-total">$0.00</span>
                    </div>
                </div>

               
                <!-- Monto entregado solo para efectivo -->
                <div class="col-md-4 d-none" id="monto-entregado-container">
                    <label for="monto_pagado" class="form-label">Monto Entregado</label>
                    <input type="number" class="form-control" id="monto_pagado" name="monto_pagado" min="0" step="0.01"
                        value="0">
                    <small id="vuelto-text" class="form-text text-success mt-1"></small>
                </div>

                <!-- Tipo de tarjeta solo para tarjeta -->
                <div class="col-md-4 d-none" id="tipo-tarjeta-container">
                    <label for="tipo_tarjeta" class="form-label">Tipo de Tarjeta (opcional)</label>
                    <select class="form-select" id="tipo_tarjeta" name="tipo_tarjeta">

                        <option value="">-- Seleccionar tipo --</option>
                        <option value="debito">Débito</option>
                        <option value="credito">Crédito</option>
                    </select>
                </div>

                <!-- Número de operación solo para transferencia -->
                <div class="col-md-4 d-none" id="numero-operacion-container">
                    <label for="numero_operacion" class="form-label">Número de Operación (opcional)</label>
                    <input type="text" class="form-control" id="numero_operacion" name="numero_operacion" maxlength="50">
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Registrar Venta</button>
                </div>
            </div>
            <!-- Template para agregar productos dinámicamente -->
            @include('ventas.partials.producto-template')


        </form>

        <!-- Incluir modal -->
        @include('clientes.partials.modal')
    </div>



    <!-- Incluimos jQuery y Select2 
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                -->

    <script>
        // Objeto con stock disponible por producto y talle, generado desde backend Laravel con
        // Estructura: { productoId: { talleId: stock, ... }, ... }
        // ventas.js depende de esa variable para validar stock.
       window.stockDisponible = @json(
        $productos->mapWithKeys(function ($producto) {
            return [
                $producto->id => $producto->talles->mapWithKeys(function ($talle) {
                    return [$talle->id => $talle->pivot->stock];
                })->toArray()
            ];
        })->toArray()
    );
    //console.log('StockDisponible:', window.stockDisponible);
</script>



    <script src="{{ asset('js/ventas.js') }}"></script>
    <script src="{{ asset('js/cuotas.js') }}"></script>
    <script src="{{ asset('js/clientes-autocomplete.js') }}"></script>
    <script src="{{ asset('js/modal-cierre.js') }}"></script>


@endsection
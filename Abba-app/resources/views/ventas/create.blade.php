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

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-select" id="cliente_id" name="cliente_id">
                    <option value="">-- Seleccionar cliente --</option>
                    @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row mb-3">
    <div class="col-md-4">
        <label class="form-label"><strong>Total estimado:</strong></label>
        <input type="text" id="total_mostrado" class="form-control" readonly value="$0.00">
    </div>
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
                </select>
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
    </form>
</div>

<!-- Template para agregar productos dinámicamente -->
<template id="producto-template">
    <div class="producto-item card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Producto</label>
                    <select class="form-select producto-select" name="productos[][id]" required>
                        <option value="">-- Seleccionar producto --</option>
                        @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">
                            {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Talle</label>
                    <select class="form-select talle-select" name="productos[][talle_id]" required>
                        <option value="">-- Seleccionar talle --</option>
                        @foreach($talles as $talle)
                        <option value="{{ $talle->id }}">{{ $talle->talle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Cantidad</label>
                    <input type="number" class="form-control cantidad" name="productos[][cantidad]" min="1" value="1"
                        required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" class="form-control precio" name="productos[][precio]" step="0.01" min="0"
                        required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Descuento</label>
                    <input type="number" class="form-control descuento" name="productos[][descuento]" step="0.01"
                        min="0" value="0">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <button type="button" class="btn btn-danger btn-sm quitar-producto">Quitar</button>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('productos-container');
    const addButton = document.getElementById('agregar-producto');
    const template = document.getElementById('producto-template');
    const totalMostrado = document.getElementById('total_mostrado');
    const metodoPagoSelect = document.getElementById('metodo_pago');
    const montoEntregadoContainer = document.getElementById('monto-entregado-container');
    const montoPagadoInput = document.getElementById('monto_pagado');
    const vueltoText = document.getElementById('vuelto-text');
    const tipoTarjetaContainer = document.getElementById('tipo-tarjeta-container');
    const numeroOperacionContainer = document.getElementById('numero-operacion-container');

    const stockDisponible = @json(
        $productos->mapWithKeys(function($producto) {
            return [
                $producto->id => $producto->talles->mapWithKeys(function($talle) {
                    return [$talle->id => $talle->pivot->stock];
                })->toArray()
            ];
        })->toArray()
    );

    agregarProducto();
    recalcularTotales();
    mostrarCamposMetodoPago();

    addButton.addEventListener('click', () => {
        agregarProducto();
        recalcularTotales();
    });

    metodoPagoSelect.addEventListener('change', () => {
        mostrarCamposMetodoPago();
        recalcularTotales();
    });

    montoPagadoInput.addEventListener('input', () => {
        recalcularTotales();
    });

    function mostrarCamposMetodoPago() {
        const metodo = metodoPagoSelect.value;
        montoEntregadoContainer.classList.toggle('d-none', metodo !== 'efectivo');
        tipoTarjetaContainer.classList.toggle('d-none', metodo !== 'tarjeta');
        numeroOperacionContainer.classList.toggle('d-none', metodo !== 'transferencia');
    }

    function agregarProducto() {
        const clone = template.content.cloneNode(true);
        const productoItem = clone.querySelector('.producto-item');
        const index = document.querySelectorAll('.producto-item').length;
        const inputs = productoItem.querySelectorAll('[name]');

        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[]', `[${index}]`);
            input.setAttribute('name', name);
        });

        const productoSelect = productoItem.querySelector('.producto-select');
        const talleSelect = productoItem.querySelector('.talle-select');
        const cantidadInput = productoItem.querySelector('.cantidad');
        const precioInput = productoItem.querySelector('.precio');
        const descuentoInput = productoItem.querySelector('.descuento');

        productoSelect.addEventListener('change', () => {
            const precio = productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio') || 0;
            precioInput.value = precio;
            actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput);
            recalcularTotales();
        });

        talleSelect.addEventListener('change', () => {
            actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput);
            recalcularTotales();
        });

        cantidadInput.addEventListener('input', () => {
            const max = cantidadInput.getAttribute('max');
            if (max && parseInt(cantidadInput.value) > max) {
                cantidadInput.value = max;
            } else if (parseInt(cantidadInput.value) < 1 || isNaN(parseInt(cantidadInput.value))) {
                cantidadInput.value = 1;
            }
            recalcularTotales();
        });

        precioInput.addEventListener('input', recalcularTotales);
        descuentoInput.addEventListener('input', recalcularTotales);

        productoItem.querySelector('.quitar-producto').addEventListener('click', () => {
            productoItem.remove();
            recalcularTotales();
        });

        container.appendChild(clone);
    }

    function actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput) {
        const productoId = productoSelect.value;
        const talleId = talleSelect.value;

        if (
            productoId &&
            talleId &&
            stockDisponible[productoId] &&
            stockDisponible[productoId][talleId] !== undefined
        ) {
            const stockMax = stockDisponible[productoId][talleId];
            cantidadInput.setAttribute('max', stockMax);
            if (parseInt(cantidadInput.value) > stockMax) {
                cantidadInput.value = stockMax;
            }
        } else {
            cantidadInput.removeAttribute('max');
        }
    }

    function recalcularTotales() {
        let total = 0;

        document.querySelectorAll('.producto-item').forEach(item => {
            const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(item.querySelector('.precio').value) || 0;
            const descuento = parseFloat(item.querySelector('.descuento').value) || 0;

            let subtotal = (precio * cantidad) - descuento;
            if (subtotal < 0) subtotal = 0;
            total += subtotal;
        });

        totalMostrado.value = `$${total.toFixed(2)}`;

        const metodo = metodoPagoSelect.value;
        if (metodo === 'efectivo') {
            const pagado = parseFloat(montoPagadoInput.value) || 0;
            const vuelto = pagado - total;
            vueltoText.textContent = vuelto >= 0 ? `Vuelto: $${vuelto.toFixed(2)}` : `Falta: $${Math.abs(vuelto).toFixed(2)}`;
            vueltoText.classList.toggle('text-danger', vuelto < 0);
            vueltoText.classList.toggle('text-success', vuelto >= 0);
        } else {
            vueltoText.textContent = '';
        }
    }
});
</script>




@endsection
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
// ==========================
// BÚSQUEDA INTELIGENTE DE CLIENTES
// Este script permite buscar clientes por nombre, DNI o teléfono
// mientras el usuario escribe, y seleccionarlos automáticamente
// desde un dropdown visual.
// ==========================

// 1. Referencias a los elementos clave
const inputBusqueda = document.getElementById('busqueda_cliente'); // input donde se escribe
const selectCliente = document.getElementById('cliente_id'); // select de clientes reales
let dropdown; // contenedor de sugerencias

// 2. Escuchamos cambios en el input
inputBusqueda.addEventListener('input', async function() {
    const query = this.value.trim(); // eliminamos espacios
    if (query.length < 2) return limpiarDropdown(); // si escribe poco, no buscamos

    // 3. Llamamos a la ruta `/clientes/buscar?query=...` vía fetch
    const res = await fetch(`/clientes/buscar?query=${encodeURIComponent(query)}`);
    if (!res.ok) return; // si hay error, salimos

    const data = await res.json(); // parseamos los resultados
    //console.log('Clientes encontrados:', data); // <-- Agregado para debug
    mostrarSugerencias(data); // mostramos sugerencias
});

// 4. Mostrar sugerencias en un dropdown visual debajo del input
function mostrarSugerencias(clientes) {
    limpiarDropdown(); // primero limpiamos si ya había uno

    if (!clientes.length) return; // si no hay resultados, no hacemos nada

    // Creamos la lista visual con estilo Bootstrap
    dropdown = document.createElement('div');
    dropdown.classList.add('list-group', 'position-absolute', 'zindex-tooltip');
    dropdown.style.maxHeight = '200px';
    dropdown.style.overflowY = 'auto';
    dropdown.style.width = inputBusqueda.offsetWidth + 'px';

    // Creamos un botón por cliente sugerido
    clientes.forEach(cliente => {
        const item = document.createElement('button');
        item.type = 'button';
        item.className = 'list-group-item list-group-item-action';
        item.textContent = `${cliente.nombre} ${cliente.apellido} - ${cliente.dni || ''}`;

        // Al hacer clic, se selecciona el cliente
        item.addEventListener('click', () => seleccionarCliente(cliente));
        dropdown.appendChild(item);
    });

    // Lo agregamos debajo del input
    inputBusqueda.parentNode.appendChild(dropdown);
}

// 5. Al seleccionar un cliente desde el dropdown
function seleccionarCliente(cliente) {
    selectCliente.value = cliente.id; // seteamos el select real
    inputBusqueda.value = `${cliente.nombre} ${cliente.apellido}`; // rellenamos el input
    limpiarDropdown(); // limpiamos sugerencias
}

// 6. Función para eliminar el dropdown (si existe)
function limpiarDropdown() {
    if (dropdown && dropdown.parentNode) {
        dropdown.parentNode.removeChild(dropdown);
        dropdown = null;
    }
}

// 7. Si se hace clic fuera del input o dropdown, lo limpiamos
document.addEventListener('click', function(e) {
    if (!dropdown || dropdown.contains(e.target) || e.target === inputBusqueda) return;
    limpiarDropdown();
});
</script>




<!-- Actualiza los campos y valida -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos clave del DOM
    const container = document.getElementById('productos-container'); // contenedor donde se agregan productos dinámicamente
    const addButton = document.getElementById('agregar-producto'); // botón para agregar nuevo producto
    const template = document.getElementById('producto-template'); // template HTML para un producto
    const totalMostrado = document.getElementById('total_mostrado'); // campo que muestra el total acumulado
    const metodoPagoSelect = document.getElementById('metodo_pago'); // select del método de pago
    const montoEntregadoContainer = document.getElementById('monto-entregado-container'); // contenedor monto entregado (solo efectivo)
    const montoPagadoInput = document.getElementById('monto_pagado'); // input monto pagado en efectivo
    const vueltoText = document.getElementById('vuelto-text'); // texto que muestra el vuelto o falta de dinero
    const tipoTarjetaContainer = document.getElementById('tipo-tarjeta-container'); // contenedor para tipo de tarjeta (crédito/débito)
    const numeroOperacionContainer = document.getElementById('numero-operacion-container'); // contenedor para número de operación transferencia

    // Objeto con stock disponible por producto y talle, generado desde backend Laravel con @json
    // Estructura: { productoId: { talleId: stock, ... }, ... }
    const stockDisponible = @json(
        $productos -> mapWithKeys(function($producto) {
            return [
                $producto -> id => $producto -> talles -> mapWithKeys(function($talle) {
                    return [$talle -> id => $talle -> pivot -> stock];
                }) -> toArray()
            ];
        }) -> toArray()
    );

    // Funciones iniciales al cargar la página:
    agregarProducto(); // agrega automáticamente un producto vacío para empezar
    recalcularTotales(); // calcula el total inicial (0)
    mostrarCamposMetodoPago(); // muestra/oculta inputs según método de pago seleccionado

    // Evento para agregar un nuevo producto al formulario
    addButton.addEventListener('click', () => {
        agregarProducto();
        recalcularTotales();
    });

    // Evento para mostrar/ocultar campos según el método de pago
    metodoPagoSelect.addEventListener('change', () => {
        mostrarCamposMetodoPago();
        recalcularTotales();
    });

    // Evento para recalcular total cuando cambia monto pagado (en efectivo)
    montoPagadoInput.addEventListener('input', () => {
        recalcularTotales();
    });

    // Muestra/oculta inputs relacionados al método de pago seleccionado
    function mostrarCamposMetodoPago() {
        const metodo = metodoPagoSelect.value;
        montoEntregadoContainer.classList.toggle('d-none', metodo !== 'efectivo'); // mostrar solo si es efectivo
        tipoTarjetaContainer.classList.toggle('d-none', metodo !== 'tarjeta'); // mostrar solo si es tarjeta
        numeroOperacionContainer.classList.toggle('d-none', metodo !== 'transferencia'); // mostrar solo si es transferencia
    }

    // Agrega un producto al formulario usando el template
    function agregarProducto() {
        const clone = template.content.cloneNode(true); // clona el template
        const productoItem = clone.querySelector('.producto-item'); // contenedor individual producto
        const index = document.querySelectorAll('.producto-item').length; // índice para los nombres de inputs (productos[0], productos[1], etc.)
        const inputs = productoItem.querySelectorAll('[name]'); // todos los inputs/selects dentro del producto

        // Ajusta el atributo 'name' de cada input para que se envíen correctamente como array al backend
        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[]', `[${index}]`);
            input.setAttribute('name', name);
            //console.log('Asignando name:', name); // para debug 
        });

        // Referencias a elementos dentro de este producto para gestionar eventos
        const productoSelect = productoItem.querySelector('.producto-select');
        const talleSelect = productoItem.querySelector('.talle-select');
        const cantidadInput = productoItem.querySelector('.cantidad');
        const precioInput = productoItem.querySelector('.precio');
        const descuentoInput = productoItem.querySelector('.descuento');

        // Cuando cambia el producto seleccionado, actualiza precio, stock máximo y total
        productoSelect.addEventListener('change', () => {
            const precio = productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio') || 0;
            precioInput.value = precio;
            actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput);
            recalcularTotales();
        });

        // Cuando cambia el talle, actualiza el stock máximo permitido y total
        talleSelect.addEventListener('change', () => {
            actualizarMaxCantidad(productoSelect, talleSelect, cantidadInput);
            recalcularTotales();
        });

        // Valida cantidad ingresada para que no supere stock ni sea menor a 1, y recalcula total
        cantidadInput.addEventListener('input', () => {
            const max = cantidadInput.getAttribute('max');
            if (max && parseInt(cantidadInput.value) > max) {
                cantidadInput.value = max;
            } else if (parseInt(cantidadInput.value) < 1 || isNaN(parseInt(cantidadInput.value))) {
                cantidadInput.value = 1;
            }
            recalcularTotales();
        });

        // Si el usuario cambia manualmente precio o descuento, recalcula total
        precioInput.addEventListener('input', recalcularTotales);
        descuentoInput.addEventListener('input', recalcularTotales);

        // Botón para quitar este producto del formulario y recalcular total
        productoItem.querySelector('.quitar-producto').addEventListener('click', () => {
            productoItem.remove();
            recalcularTotales();
        });

        // Finalmente agrega el producto al contenedor
        container.appendChild(clone);
    }

    // Actualiza la cantidad máxima permitida para el input cantidad según el stock disponible para ese producto y talle
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
            cantidadInput.removeAttribute('max'); // si no hay stock info, no se limita cantidad
        }
    }

    // Recalcula el total de la venta sumando cada producto con cantidad * precio - descuento
    // También calcula el vuelto o cuánto falta si es pago en efectivo
    function recalcularTotales() {
        let total = 0;

        document.querySelectorAll('.producto-item').forEach(item => {
            const cantidad = parseFloat(item.querySelector('.cantidad').value) || 0;
            const precio = parseFloat(item.querySelector('.precio').value) || 0;
            const descuento = parseFloat(item.querySelector('.descuento').value) || 0;

            let subtotal = (precio * cantidad) - descuento;
            if (subtotal < 0) subtotal = 0; // evitar subtotales negativos
            total += subtotal;
        });

        // Muestra total en el input readonly
        totalMostrado.value = `$${total.toFixed(2)}`;

        // Si es pago efectivo, calcula vuelto o falta
        const metodo = metodoPagoSelect.value;
        if (metodo === 'efectivo') {
            const pagado = parseFloat(montoPagadoInput.value) || 0;
            const vuelto = pagado - total;
            vueltoText.textContent = vuelto >= 0 ? `Vuelto: $${vuelto.toFixed(2)}` :
                `Falta: $${Math.abs(vuelto).toFixed(2)}`;
            vueltoText.classList.toggle('text-danger', vuelto < 0);
            vueltoText.classList.toggle('text-success', vuelto >= 0);
        } else {
            vueltoText.textContent = ''; // limpia texto para otros métodos
        }
    }
});
</script>


<script>
//Modal js
document.body.addEventListener('htmx:afterSwap', (event) => {
    if (event.target.id === 'cliente_id') {
        const modalEl = document.getElementById('modalNuevoCliente');
        if (modalEl) {
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        }
        const form = document.getElementById('formNuevoCliente');
        if (form) {
            form.reset();
        }
    }
});
</script>






@endsection
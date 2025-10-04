@extends('layouts.app')

@section('content')

        {{-- resources\views\ventas\create.blade.php --}}



        <x-header-bar title="Ventas" action="create" :buttons="[
        ['text' => '+ Nueva Venta', 'route' => route('ventas.create'), 'class' => 'btn-primary']
    ]">

        </x-header-bar>


        <form method="POST" action="{{ route('ventas.store') }}">
            @csrf

            <div class="row">
                <!-- IZQUIERDA -->
                <div class="col-md-8">

                    {{-- ================== CONTENEDOR CLIENTE ================== --}}
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold text-primary mb-0">👤 Cliente</h5>
                                <button type="button" class="btn btn-sm btn-link" data-bs-toggle="modal"
                                    data-bs-target="#modalNuevoCliente">
                                    + Nuevo cliente
                                </button>
                            </div>

                            {{-- Input búsqueda --}}
                            <div class="mb-3">
                                <label for="buscarCliente" class="form-label"></label>
                                <input type="text" id="buscarCliente" class="form-control" placeholder="Nombre, DNI o Teléfono...">
                                <ul id="sugerenciasCliente" class="list-group position-absolute w-50 mt-1" style="z-index: 1050; display:none;"></ul>
                                </div>
                                {{-- Card cliente seleccionado --}}
                                {{-- Card compacto de cliente seleccionado --}}
                                <div id="clienteSeleccionado"
                                    class="d-none my-2 p-2 border rounded bg-light d-flex align-items-center justify-content-between">
                                    <div>
                                        <span id="clienteInfo" class="text-truncate" style="max-width: 400px;">
                                            <!-- Aquí va "Juan Pérez - DNI 12345678 - Tel 11223344" -->
                                        </span>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="cambiarCliente">Cambiar</button>
                                </div>

                                {{-- Campo oculto con cliente_id para enviar al backend --}}
                                <input type="hidden" name="cliente_id" id="clienteId">

                            </div>
                        </div>

                   {{-- ================== SCRIPT BÚSQUEDA ================== --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    const buscarCliente = document.getElementById("buscarCliente");
    const sugerencias = document.getElementById("sugerenciasCliente");
    const clienteCard = document.getElementById("clienteSeleccionado");
    const clienteId = document.getElementById("clienteId");

    buscarCliente.addEventListener("input", async () => {
        const query = buscarCliente.value.trim();
        if (query.length < 2) {
            sugerencias.style.display = "none";
            return;
        }

        try {
            const resp = await fetch(`/clientes/buscar?query=${encodeURIComponent(query)}`);
            const clientes = await resp.json();

            sugerencias.innerHTML = "";
            if (clientes.length === 0) {
                sugerencias.style.display = "none";
                return;
            }

            clientes.forEach(c => {
                const item = document.createElement("li");
                item.className = "list-group-item list-group-item-action";
                item.textContent = `${c.nombre} ${c.apellido ?? ""} - DNI: ${c.dni ?? "N/A"} - Tel: ${c.telefono ?? "N/A"}`;
                item.addEventListener("click", () => seleccionarCliente(c));
                sugerencias.appendChild(item);
            });

            sugerencias.style.display = "block";
        } catch (e) {
            console.error("Error buscando clientes:", e);
        }
    });

    function seleccionarCliente(c) {
        clienteId.value = c.id;
        clienteCard.innerHTML = `
            <div class="d-flex align-items-center justify-content-between p-2 border rounded bg-light">
                <div>
                    <span>${c.nombre} ${c.apellido ?? ""} - DNI: ${c.dni ?? "-"} - Tel: ${c.telefono ?? "-"}</span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('clienteSeleccionado').innerHTML='';document.getElementById('clienteId').value='';document.getElementById('buscarCliente').focus();">
                    Cambiar
                </button>
            </div>
        `;
        clienteCard.classList.remove("d-none");
        sugerencias.style.display = "none";
        buscarCliente.value = "";
    }
});
</script>


    <!-- CONTENEDOR PRODUCTOS -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-bold text-primary mb-0">🛒 Productos
                <div class="d-flex gap-2 align-items-center">
                    <input type="text" id="busqueda-producto" class="form-control form-control-sm"
                        placeholder="Buscar producto...">
                    <div class="d-flex align-items-center gap-1">
                        <label for="cantidad-mostrar" class="mb-0 small text-muted">Mostrar:</label>
                        <select id="cantidad-mostrar" class="form-select form-select-sm">
                            <option value="10">10 productos</option>
                            <option value="20">20 productos</option>
                            <option value="50">50 productos</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 300px; overflow-y:auto;">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Talle</th>
                            <th style="width:60px;">Cant.</th>
                            <th>P.Reventa</th>
                            <th>Precio</th>
                            <th>Desc. $
                            <th style="width:100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="productos-container">
                        @foreach($productos as $producto)
                            <tr data-id="{{ $producto->id }}">
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>
                                    <select class="form-select form-select-sm talle-select"
                                        style="width:auto; min-width:100px;">
                                        @foreach ($producto->talles as $talle)
                                            <option value="{{ $talle->id }}" @if($talle->pivot->stock <= 0) disabled
                                            @endif>
                                                {{ $talle->talle }} (Stock: {{ $talle->pivot->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number"
                                        class="form-control form-control-sm cantidad-input text-center"
                                        style="width:60px; min-width:40px;" min="1" value="1">
                                </td>
                                <td>${{ number_format($producto->precio_reventa, 2) }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm descuento-dinero"
                                        min="0" step="0.01" value="0">
                                
                                <td>
                                                            <button type="button" class="btn btn-success btn-sm agregar-carrito">
                                                                <i class="bi bi-cart-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <!-- DERECHA: DETALLES DE PAGO -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold text-primary mb-0">💰 Total Venta</h5>
                                        <span class="fs-5 fw-bold" id="total-venta-monto">$0.00</span>
                                    </div>


                                    <!-- Tipo de Documento -->
                                    <!-- Alerta para select tipo documento -->
                                    <div id="alert-tipo-doc" class="text-danger small mt-1 d-none">Seleccione primero un cliente</div>

                                    <!-- Select tipo documento -->
                                    <div class="mb-3 mt-2">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                        <select class="form-select form-select-sm" id="tipo_documento" name="tipo_documento" disabled>
                                            <option value="">Seleccione un tipo</option>
                                            <option value="factura">Factura</option>
                                            <option value="remito">Remito</option>
                                            <option value="ticket">Ticket</option>
                                            <option value="nota_credito">Nota de Crédito</option>
                                        </select>
                                    </div>


                                    <!-- Número de venta -->
                                    <div class="mb-3">
                                        <label for="numero_venta" class="form-label">Número de Venta</label>
                                        <input type="text" class="form-control form-control-sm" id="numero_venta" name="numero_venta"
                                            readonly value="{{ old('numero_venta', $ultimo_numero_venta ?? '') }}">
                                    </div>

                                    <!-- Método de pago -->
                                    <div class="mb-3">
                                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                                        <select class="form-select form-select-sm" id="metodo_pago" name="metodo_pago" required>
                                            <option value="">-- Seleccionar método --</option>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="transferencia">Transferencia</option>
                                            <option value="cuotas">Pago en Cuotas</option>
                                        </select>
                                    </div>

                                    <!-- Subtotal y descuento -->
                                    <div class="mb-3 d-flex justify-content-between">
                                        <span>Subtotal:</span>
                                        <span id="subtotal">$0.00</span>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <span>Descuento Total:</span>
                                        <span id="descuento-total">$0.00</span>
                                    </div>

                                    <!-- Botón Confirmar -->
                                    <div class="d-grid mt-3">
                                        <button type="button" class="btn btn-success" id="btn-confirmar-venta" data-bs-toggle="modal"
                                            data-bs-target="#modal-detalle-pago">
                                            Confirmar Venta
                                        </button>
                                    </div>
                                </div>
                            </div>




                            <!-- Template dinámico -->
                            @include('ventas.partials.producto-template')
                </form>

                <!-- Modal cliente -->
                @include('clientes.partials.modal')
                
@endsection
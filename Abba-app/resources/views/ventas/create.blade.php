@extends('layouts.app')

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
                <label for="descuento_global" class="form-label">Descuento Global</label>
                <input type="number" class="form-control" id="descuento_global" name="descuento_global" min="0" step="0.01" value="0">
            </div>
            <div class="col-md-4">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                </select>
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
                    <input type="number" class="form-control cantidad" name="productos[][cantidad]" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" class="form-control precio" name="productos[][precio]" step="0.01" min="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Descuento</label>
                    <input type="number" class="form-control descuento" name="productos[][descuento]" step="0.01" min="0" value="0">
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('productos-container');
    const addButton = document.getElementById('agregar-producto');
    const template = document.getElementById('producto-template');
    
    // Agregar primer producto por defecto
    agregarProducto();
    
    addButton.addEventListener('click', agregarProducto);
    
    function agregarProducto() {
        const clone = template.content.cloneNode(true);
        const productoItem = clone.querySelector('.producto-item');
        
        // Actualizar índices de los nombres de los campos
        const index = document.querySelectorAll('.producto-item').length;
        const inputs = productoItem.querySelectorAll('[name]');
        
        inputs.forEach(input => {
            const name = input.getAttribute('name').replace('[]', `[${index}]`);
            input.setAttribute('name', name);
        });
        
        // Configurar evento para actualizar precios cuando se selecciona un producto
        const productoSelect = productoItem.querySelector('.producto-select');
        const precioInput = productoItem.querySelector('.precio');
        
        productoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const precio = selectedOption.getAttribute('data-precio');
            precioInput.value = precio || '0';
        });
        
        // Configurar evento para quitar producto
        const quitarBtn = productoItem.querySelector('.quitar-producto');
        quitarBtn.addEventListener('click', function() {
            if (document.querySelectorAll('.producto-item').length > 1) {
                productoItem.remove();
            } else {
                alert('Debe haber al menos un producto en la venta.');
            }
        });
        
        container.appendChild(clone);
    }
});
</script>
@endsection
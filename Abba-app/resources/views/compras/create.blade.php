@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Registrar Compra</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filtro de búsqueda de productos --}}
    <form method="GET" action="{{ route('compras.create') }}" class="mb-4 border p-3 rounded bg-light">
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label">Proveedor</label>
                <select name="proveedor_id" class="form-control">
                    <option value="">-- Todos los proveedores --</option>
                    @foreach ($proveedores as $prov)
                        <option value="{{ $prov->id }}" {{ $proveedorId == $prov->id ? 'selected' : '' }}>
                            {{ $prov->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label">Buscar producto</label>
                <input type="text" name="buscar_producto" class="form-control"
                       placeholder="Nombre o código..."
                       value="{{ old('buscar_producto', $search) }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-secondary w-100">Filtrar productos</button>
            </div>
        </div>
    </form>

    {{-- Formulario principal --}}
    <form method="POST" action="{{ route('compras.store') }}">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Proveedor *</label>
                <select name="proveedor_id" class="form-control" required>
                    <option value="">-- Seleccionar proveedor --</option>
                    @foreach ($proveedores as $prov)
                        <option value="{{ $prov->id }}" {{ old('proveedor_id', $proveedorId) == $prov->id ? 'selected' : '' }}>
                            {{ $prov->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-4">
                <label>Método de Pago</label>
                <input type="text" name="metodo_pago" class="form-control">
            </div>
        </div>

        {{-- Modal nuevo producto --}}
        <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
            + Nuevo producto
        </button>

        {{-- Detalles --}}
        <div id="detalles-container">
            <h5>Detalles</h5>
            <div class="detalle row mb-2" data-index="0">
                <div class="col-md-4">
                    <select name="detalles[0][producto_id]" class="form-control" required>
                        <option value="">-- Seleccionar producto --</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="detalles[0][talle_id]" class="form-control" required>
                        <option value="">-- Seleccionar talle --</option>
                        @foreach($talles as $talle)
                            <option value="{{ $talle->id }}">{{ $talle->talle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="detalles[0][cantidad]" class="form-control" placeholder="Cantidad" min="1" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="detalles[0][precio_unitario]" class="form-control" placeholder="Precio $" required>
                </div>
                <div class="col-12 mt-1 text-end">
                    <button type="button" class="btn btn-danger btn-sm btn-remove-detalle" style="display:none;">Eliminar</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-outline-secondary btn-sm" id="btn-add-detalle">+ Agregar producto</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Guardar Compra</button>
        </div>
    </form>

   {{-- Modal para crear producto --}}
@include('compras.partials.modal_producto')

{{-- Script para clonado de filas --}}
@include('compras.partials.script_detalles')

@endsection

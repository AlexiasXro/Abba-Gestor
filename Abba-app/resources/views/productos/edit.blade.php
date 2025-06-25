@extends('layouts.app')

@section('content')
<!--Abba-app\resources\views\productos\edit.blade.php  Formulario editar producto-->
<div class="container">
    <h1>Editar Producto</h1>
    <a href="{{ route('productos.show', $producto) }}" class="btn btn-secondary mb-3">Volver</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.update', $producto) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $producto->codigo) }}" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{ old('precio', $producto->precio) }}" required>
        </div>

        <div class="mb-3">
    <label for="stock_minimo" class="form-label">Stock mínimo <small class="text-muted">(opcional)</small></label>
    <input type="number" name="stock_minimo" id="stock_minimo" class="form-control"
           value="{{ old('stock_minimo', $producto->stock_minimo) }}" min="0">
</div>

        <div class="mb-3">
            <label for="activo" class="form-label">Activo</label>
            <select name="activo" id="activo" class="form-select" required>
                <option value="1" {{ old('activo', $producto->activo) == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('activo', $producto->activo) == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        {{-- Talles con stock --}}
        <h4>Talles y Stock</h4>
        @foreach ($talles as $talle)
            @php
                $stock = $producto->talles->firstWhere('id', $talle->id)?->pivot->stock ?? 0;
            @endphp
            <div class="row mb-2 align-items-center">
                <div class="col-4">
                    <label>{{ $talle->talle }}</label>
                </div>
                <div class="col-4">
                    <input type="hidden" name="talles[{{ $loop->index }}][id]" value="{{ $talle->id }}">
                    <input type="number" name="talles[{{ $loop->index }}][stock]" class="form-control" min="0" value="{{ old('talles.' . $loop->index . '.stock', $stock) }}">
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Actualizar Producto</button>
    </form>
</div>
@endsection

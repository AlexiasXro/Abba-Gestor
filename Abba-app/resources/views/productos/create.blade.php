@extends('layouts.app')

@section('content')
<!--Abba-app\resources\views\productos\create.blade.php-->
<div class="container">
    <h1>Nuevo Producto</h1>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">Volver</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{ old('precio') }}" required>
        </div>

        <div class="mb-3">
            <label for="stock_minimo" class="form-label">Stock mínimo</label>
            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value="{{ old('stock_minimo', 3) }}" required>
        </div>

        <div class="mb-3">
            <label for="activo" class="form-label">Activo</label>
            <select name="activo" id="activo" class="form-select" required>
                <option value="1" {{ old('activo') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('activo') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        {{-- Talles con stock --}}
        <h4>Talles y Stock</h4>
        @foreach ($talles as $talle)
            <div class="row mb-2 align-items-center">
                <div class="col-4">
                    <label>{{ $talle->talle }}</label>
                </div>
                <div class="col-4">
                    <input type="hidden" name="talles[{{ $loop->index }}][id]" value="{{ $talle->id }}">
                    <input type="number" name="talles[{{ $loop->index }}][stock]" class="form-control" min="0" value="0">
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Crear Producto</button>
    </form>
</div>
@endsection

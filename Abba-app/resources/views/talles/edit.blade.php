

@extends('layouts.app')

@section('title', 'Editar Talle')

@section('content')

<x-header-bar
    title="Editar Talle"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('talles.index'), 'class' => 'btn-secondary']
    ]"
/>


<!--Abba-app\resources\views\talles\edit.blade.php 
– Formulario de edición
-->
    @extends('layouts.app')

@section('title', 'Editar Talle')

@section('content')
<div class="container mt-3">
    <div class="row">
        <!-- Formulario -->
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                

                <form action="{{ route('talles.update', $talle) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="talle" class="form-label">Talle</label>
                        <input type="text" name="talle" id="talle" class="form-control" value="{{ old('talle', $talle->talle) }}" required>
                        @error('talle')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Ej: 35, S, M, 10 años, etc.</div>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select name="tipo" id="tipo" class="form-select" required>
    <option value="">-- Seleccionar tipo --</option>
    <option value="calzado" {{ old('tipo') == 'calzado' ? 'selected' : '' }}>Calzado</option>
    <option value="ropa" {{ old('tipo') == 'ropa' ? 'selected' : '' }}>Ropa</option>
    <option value="niño" {{ old('tipo') == 'niño' ? 'selected' : '' }}>Niño</option>
    <option value="unico" {{ old('tipo') == 'unico' ? 'selected' : '' }}>Único</option>
    <option value="adulto" {{ old('tipo') == 'adulto' ? 'selected' : '' }}>Adulto</option>
    <option value="juvenil" {{ old('tipo') == 'juvenil' ? 'selected' : '' }}>Juvenil</option>
    <option value="bebé" {{ old('tipo') == 'bebé' ? 'selected' : '' }}>Bebé</option>
</select>
                        <div class="form-text">Define a qué categoría pertenece este talle.</div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('talles.index') }}" class="btn btn-secondary">⬅️ Volver</a>
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contenedor informativo -->
        <div class="col-md-4">
            <div class="card border-info shadow-sm p-3">
                <h6 class="card-title text-info">Información del Módulo</h6>
                <p class="card-text mb-1">- Los talles se usan para controlar stock en productos.</p>
                <p class="card-text mb-1">- Cada tipo ayuda a clasificar productos: Calzado, Ropa, Niño o Único.</p>
                <p class="card-text mb-0">- El talle "Único" sirve para accesorios o productos especiales.</p>
            </div>
        </div>
    </div>
</div>
@endsection


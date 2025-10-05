

@extends('layouts.app')

@section('title', 'Nuevo Talle')

@section('content')

<x-header-bar
    title="Nuevo Talle"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('talles.index'), 'class' => 'btn-secondary']
    ]"
/>

<!--Abba-app\resources\views\talles\create.blade.php 
– Formulario de altas
-->
      <!-- Alerta de errores -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

  <div class="container mt-3">
    <div class="row">
        <!-- Formulario -->
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="card-title mb-3">Crear Nuevo Talle</h5>

                <form action="{{ route('talles.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="talle" class="form-label">Talle <span class="text-danger">*</span></label>
                            <input type="text" name="talle" id="talle" class="form-control" value="{{ old('talle') }}" required>
                            <div class="form-text">Ej: 35, S, M, 10 años, etc.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo <span class="text-danger">*</span></label>
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

                        <div class="col-12 text-end mt-2">
                            <button type="submit" class="btn btn-primary">Crear Talle</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Contenedor informativo -->
        <div class="col-md-4">
            <div class="card border-info shadow-sm p-3">
                <h6 class="card-title text-info">Información del Módulo</h6>
                <p class="card-text mb-1">- Los talles se usarán para controlar stock en productos.</p>
                <p class="card-text mb-1">- Cada tipo ayuda a clasificar productos: Calzado, Ropa, Niño o Único.</p>
                <p class="card-text mb-0">- Podés crear un talle "Único" para accesorios o productos especiales.</p>
            </div>
        </div>
    </div>
</div>

@endsection


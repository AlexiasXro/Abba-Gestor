@extends('layouts.app')

@section('content')
<!--/resources/views/clientes/create.blade.php-->

<x-header-bar title="Nuevo Cliente" :buttons="[
    ['text' => 'Volver al listado', 'route' => route('clientes.index'), 'class' => 'btn-secondary']
]" />

<div class="container">
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="container mt-4">
    <div class="row">
        <!-- Formulario principal -->
        <div class="col">
            <div class="card border-primary shadow-sm p-3">
                <div class="card-body">
                    
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea name="direccion" id="direccion" class="form-control" rows="2">{{ old('direccion') }}</textarea>
                        </div>

                        <div class="card-footer text-end">
           
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contenedor informativo a la derecha -->
        <div class="col-auto" style="max-width: 250px;">
            <div class="card border-info shadow-sm p-3">
                <h6 class="fw-bold text-info mb-3"><i class="bi bi-info-circle me-1"></i> Información</h6>
                <p class="mb-1"><i class="bi bi-asterisk text-danger"></i> Los campos con * son obligatorios.</p>
                <p class="mb-1"><i class="bi bi-telephone me-1"></i> Teléfono opcional, recomendable para contacto rápido.</p>
                <p class="mb-1"><i class="bi bi-envelope me-1"></i> Email opcional, debe ser válido.</p>
                <p class="mb-0"><i class="bi bi-house me-1"></i> Dirección opcional, ayuda a envíos o facturación.</p>
            </div>
        </div>
    </div>
</div>


@endsection

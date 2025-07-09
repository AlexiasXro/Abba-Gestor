{{-- resources/views/gastos/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-4 text-dark fw-semibold">Registrar Gasto</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Errores:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('gastos.store') }}" method="POST" class="row g-3">
                @csrf

                <div class="col-md-4">
                    <label for="fecha" class="form-label fw-medium">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', date('Y-m-d')) }}" required>
                </div>

                <div class="col-md-4">
                    <label for="monto" class="form-label fw-medium">Monto ($)</label>
                    <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto') }}" required>
                </div>

                <div class="col-md-4">
                    <label for="categoria" class="form-label fw-medium">Categoría</label>
                    <input type="text" name="categoria" id="categoria" class="form-control" value="{{ old('categoria') }}" placeholder="Ej: Proveedor, Servicios...">
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label fw-medium">Descripción (opcional)</label>
                    <textarea name="descripcion" id="descripcion" rows="2" class="form-control" placeholder="Detalle del gasto">{{ old('descripcion') }}</textarea>
                </div>

                <div class="col-12 text-end">
                    <a href="{{ route('gastos.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-dark">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-4 text-dark fw-semibold">Detalle del Gasto</h4>

            <dl class="row mb-3">
                <dt class="col-sm-4 fw-medium text-muted">Fecha</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</dd>

                <dt class="col-sm-4 fw-medium text-muted">Monto</dt>
                <dd class="col-sm-8 fw-bold text-success">${{ number_format($gasto->monto, 2, ',', '.') }}</dd>

                <dt class="col-sm-4 fw-medium text-muted">Categoría</dt>
                <dd class="col-sm-8">{{ $gasto->categoria ?? '-' }}</dd>

                <dt class="col-sm-4 fw-medium text-muted">Descripción</dt>
                <dd class="col-sm-8">{{ $gasto->descripcion ?? '-' }}</dd>
            </dl>

            <a href="{{ route('gastos.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
        </div>
    </div>
</div>
@endsection

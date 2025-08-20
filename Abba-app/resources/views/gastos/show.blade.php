@extends('layouts.app')

@section('content')
<x-header-bar
    title="Detalle del Gasto"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('gastos.index'), 'class' => 'btn-secondary']
    ]"
/>

<div class="container " style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            
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

            
        </div>
    </div>
</div>
@endsection

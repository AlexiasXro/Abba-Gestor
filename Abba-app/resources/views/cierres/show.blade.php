@extends('layouts.app')

@section('content')

<x-header-bar
    title="Listado de Cierres de Caja"
    :buttons="[
        ['text' => '+ Nuevo Cierre', 'route' => route('cierres.create'), 'class' => 'btn-primary']
    ]"
/>

<div class="container py-4" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-4 text-dark fw-semibold">Detalle del Cierre de Caja</h4>

            <dl class="row mb-3">
                <dt class="col-sm-5 fw-medium text-muted">Fecha</dt>
                <dd class="col-sm-7">{{ \Carbon\Carbon::parse($cierre->fecha)->format('d/m/Y') }}</dd>

                <dt class="col-sm-5 fw-medium text-muted">Ventas en efectivo</dt>
                <dd class="col-sm-7 text-success">${{ number_format($cierre->monto_efectivo, 2, ',', '.') }}</dd>

                <dt class="col-sm-5 fw-medium text-muted">Ventas en cuotas</dt>
                <dd class="col-sm-7">${{ number_format($cierre->monto_cuotas, 2, ',', '.') }}</dd>

                <dt class="col-sm-5 fw-medium text-muted">Total gastos</dt>
                <dd class="col-sm-7">${{ number_format(($cierre->monto_total - ($cierre->monto_efectivo + $cierre->monto_cuotas)), 2, ',', '.') }}</dd>

                <dt class="col-sm-5 fw-semibold">Saldo final</dt>
                <dd class="col-sm-7 fw-bold text-success">${{ number_format($cierre->monto_total, 2, ',', '.') }}</dd>
            </dl>

            <a href="{{ route('cierres.index') }}" class="btn btn-outline-secondary">Volver al historial</a>
        </div>
    </div>
</div>
@endsection

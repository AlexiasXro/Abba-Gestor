@extends('layouts.app')

@section('content')
<x-header-bar
    title="Cierre de Caja"
    :buttons="[
        ['text' => 'Volver al Listado', 'route' => route('cierres.index'), 'class' => 'btn-secondary']
    ]"
/>
<div class="container py-4" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="mb-4 text-dark fw-semibold">Cierre de Caja - {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</h4>

            @if(session('error'))
                <div class="alert alert-danger small">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('cierres.store') }}" method="POST" class="mb-0">
                @csrf

                <input type="hidden" name="fecha" value="{{ $fecha }}">

                <div class="mb-3">
                    <label class="form-label fw-medium">Ventas en efectivo</label>
                    <input type="text" class="form-control" value="${{ number_format($monto_efectivo, 2, ',', '.') }}" readonly>
                    <input type="hidden" name="monto_efectivo" value="{{ $monto_efectivo }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Ventas en cuotas</label>
                    <input type="text" class="form-control" value="${{ number_format($monto_cuotas, 2, ',', '.') }}" readonly>
                    <input type="hidden" name="monto_cuotas" value="{{ $monto_cuotas }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium">Total gastos</label>
                    <input type="text" class="form-control" value="${{ number_format($total_gastos, 2, ',', '.') }}" readonly>
                    <input type="hidden" name="total_gastos" value="{{ $total_gastos }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Saldo final</label>
                    <input type="text" class="form-control fw-bold text-success" value="${{ number_format($monto_total, 2, ',', '.') }}" readonly>
                    <input type="hidden" name="monto_total" value="{{ $monto_total }}">
                </div>

                <div class="text-end">
                    <a href="{{ route('cierres.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-dark">Confirmar cierre</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container ">
    <x-header-bar 
        title="Historial de Cierres de Caja"
        :buttons="[
            ['text' => '+ Nuevo Cierre', 'route' => route('cierres.create'), 'class' => 'btn-dark btn-sm']
        ]"
    />

    @if(session('success'))
        <div class="alert alert-success small">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped table-sm align-middle">
                <thead class="table-light">
                    <tr class="text-muted small text-uppercase">
                        <th scope="col">Fecha</th>
                        <th scope="col">Ventas Efectivo ($)</th>
                        <th scope="col">Ventas Cuotas ($)</th>
                        <th scope="col">Total Gastos ($)</th>
                        <th scope="col">Saldo Final ($)</th>
                        <th class="text-end" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cierres as $cierre)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($cierre->fecha)->format('d/m/Y') }}</td>
                            <td>{{ number_format($cierre->monto_efectivo, 2, ',', '.') }}</td>
                            <td>{{ number_format($cierre->monto_cuotas, 2, ',', '.') }}</td>
                            <td>{{ number_format($cierre->monto_total - ($cierre->monto_efectivo + $cierre->monto_cuotas), 2, ',', '.') }}</td>
                            <td class="fw-bold text-success">{{ number_format($cierre->monto_total, 2, ',', '.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('cierres.show', $cierre) }}" class="btn btn-outline-secondary btn-sm">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No se registraron cierres de caja.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

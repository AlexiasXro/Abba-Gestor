@extends('layouts.app')

@section('content')
<!--/resources/views/clientes/show.blade.php-->
<x-header-bar title="Detalle del Cliente" :buttons="[
    ['text' => 'Editar Cliente', 'route' => route('clientes.edit', $cliente), 'class' => 'btn-primary'],
    ['text' => 'Volver al listado', 'route' => route('clientes.index'), 'class' => 'btn-secondary']
]" />

<div class="container">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Nombre</th>
                <td>{{ $cliente->nombre }}</td>
            </tr>
            <tr>
                <th>Apellido</th>
                <td>{{ $cliente->apellido }}</td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>{{ $cliente->telefono ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $cliente->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td>{{ $cliente->direccion ?? '-' }}</td>
            </tr>
            
        </tbody>
    </table>
{{-- Bloque animado para puntos --}}
    <div class="my-4 p-4 rounded shadow-sm text-center bg-light position-relative overflow-hidden">
        <div class="points-animation position-absolute w-100 h-100 top-0 start-0"></div>
        <h5 class="fw-bold">🎯 Sistema de Puntos</h5>
        <p class="text-muted mb-0">Próximamente disponible para clientes frecuentes</p>
        <small class="text-muted">(Gana beneficios por compras y pagos en tiempo)</small>
    </div>
</div>

{{-- Estilos y animación --}}
<style>
.points-animation {
    background: radial-gradient(circle at 20% 20%, #ffd70055, transparent),
                radial-gradient(circle at 80% 40%, #ff8c0055, transparent),
                radial-gradient(circle at 50% 80%, #ffa50055, transparent);
    animation: moveGradient 6s infinite alternate;
    z-index: 0;
}
@keyframes moveGradient {
    0% { background-position: 0 0, 50% 50%, 100% 100%; }
    100% { background-position: 50% 50%, 100% 0, 0 100%; }
}
.bg-light {
    z-index: 1;
    position: relative;
}
</style>
@endsection

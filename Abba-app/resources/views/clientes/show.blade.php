@extends('layouts.app')

@section('content')
<!--/resources/views/clientes/show.blade.php-->
<div class="container">
    <h1 class="mb-4">Detalle del Cliente</h1>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mb-3">Volver al listado</a>
    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning mb-3">Editar Cliente</a>

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
</div>
@endsection

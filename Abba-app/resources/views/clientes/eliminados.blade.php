@extends('layouts.app')

@section('content')
<!--/resources/views/clientes/eliminados.blade.php-->
<div class="container">
    <h3 class="mb-4">Clientes eliminados</h3>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mb-3">Volver a clientes activos</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($clientesEliminados->isEmpty())
        <p>No hay clientes eliminados.</p>
    @else
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Eliminado el</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientesEliminados as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->apellido }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->deleted_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('clientes.restaurar', $cliente->id) }}" method="POST" onsubmit="return confirm('¿Restaurar este cliente?')">
                            @csrf
                            <button class="btn btn-success btn-sm">Restaurar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection

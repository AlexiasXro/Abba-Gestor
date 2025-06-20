@extends('layouts.app')

@section('content')
<!--/resources/views/clientes/index.blade.php-->
<div class="container">
    <h1 class="mb-4">Clientes activos</h1>

    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">+ Nuevo Cliente</a>
    <a href="{{ route('clientes.eliminados') }}" class="btn btn-secondary mb-3 float-end">Ver eliminados</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($clientes->isEmpty())
        <p>No hay clientes registrados.</p>
    @else
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->apellido }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>
                        <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este cliente?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
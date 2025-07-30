@extends('layouts.app')

@section('content')
    <h4>Proveedores</h4>
    <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-2">Nuevo Proveedor</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>CUIT</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proveedores as $p)
                <tr>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->cuit }}</td>
                    <td>{{ $p->telefono }}</td>
                    <td>{{ $p->email }}</td>
                    <td>
                        <a href="{{ route('proveedores.edit', $p) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('proveedores.destroy', $p) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar proveedor?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $proveedores->links() }}
@endsection

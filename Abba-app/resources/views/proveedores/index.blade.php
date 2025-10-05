@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="container mt-3">
<x-header-bar
    title="Listado de Proveedores"
    :buttons="[
        ['text' => '+ Nuevo Proveedor', 'route' => route('proveedores.create'), 'class' => 'btn-primary'],
        ['text' => 'Ver Eliminados', 'route' => route('proveedores.eliminados'), 'class' => 'btn-outline-dark']
    ]"
    filterName="nombre"
    filterPlaceholder="Buscar proveedor..."
    filterRoute="{{ route('proveedores.index') }}"
/>




@include('components.filtros._proveedores')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>CUIT</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Obcervación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->cuit }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td>{{ $proveedor->email }}</td>
                    <td>{{ $proveedor->observaciones }}</td>
                    <td>
  <a href="{{ route('proveedores.show', $proveedor) }}" class="btn btn-sm btn-info" title="Ver detalles">
        <i class="bi bi-eye-fill"></i>
    </a>

    <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-sm btn-warning" title="Editar">
        <i class="bi bi-pencil-fill"></i>
    </a>

    <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                onclick="return confirm('¿Eliminar proveedor?')">
            <i class="bi bi-trash-fill"></i>
        </button>
    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $proveedores->links() }}
    </div>
@endsection

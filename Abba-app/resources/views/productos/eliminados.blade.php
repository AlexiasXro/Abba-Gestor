@extends('layouts.app')

@section('content')

<!--alerta-->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<!--fin alerta-->

<!--Abba-app\resources\views\productos\eliminados.blade.php   Listado productos eliminados con restaurar-->
<div class="container">
    <h1>Productos Eliminados</h1>
    <!--boton de regreso-->
    <a href="{{ route('productos.index') }}" class="btn btn-secondary mb-3">Volver a Productos</a>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Eliminado el</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productosEliminados as $producto)
                <tr>
                    <td>{{ $producto->codigo }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->deleted_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('productos.restaurar', $producto->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Restaurar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No hay productos eliminados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

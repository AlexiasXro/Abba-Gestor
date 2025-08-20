@extends('layouts.app')

@section('title', 'Talles')

@section('content')

<x-header-bar
    title="Listado de Talles"
    :buttons="[
        ['text' => '➕ Nuevo Talle', 'route' => route('talles.create'), 'class' => 'btn-primary']
    ]"
/>
<!--Abba-app\resources\views\talles\index.blade.php
– Listado de talles
-->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📏 Listado de Talles</h4>
        <a href="{{ route('talles.create') }}" class="btn btn-primary">➕ Nuevo Talle</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($talles->isEmpty())
        <p>No hay talles registrados.</p>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Talle</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($talles as $talle)
                    <tr>
                        <td>{{ $talle->id }}</td>
                        <td>{{ $talle->talle }}</td>
                        <td>
                            <a href="{{ route('talles.edit', $talle) }}" class="btn btn-sm btn-warning">✏️ Editar</a>
                            <form action="{{ route('talles.destroy', $talle) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este talle?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

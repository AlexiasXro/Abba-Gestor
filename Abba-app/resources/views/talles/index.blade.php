@extends('layouts.app')

@section('title', 'Talles')

@section('content')

<x-header-bar
    title="Listado de Talles"
    :buttons="[
        ['text' => '➕ Nuevo Talle', 'route' => route('talles.create'), 'class' => 'btn-primary']
    ]"
/>



@if($talles->isEmpty())
    <p>No hay talles registrados.</p>
@else
<div class="container mt-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <th>ID</th>
                    <th>Talle</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($talles as $talle)
                    <tr>
                        <td>{{ $talle->id }}</td>
                        <td>{{ $talle->talle }}</td>
                        <td>
                            @if($talle->tipo === 'calzado')
                                <span class="badge bg-primary">Calzado</span>
                            @elseif($talle->tipo === 'ropa')
                                <span class="badge bg-success">Ropa</span>
                            @elseif($talle->tipo === 'niño')
                                <span class="badge bg-info text-dark">Niño</span>
                            @elseif($talle->tipo === 'unico')
                                <span class="badge bg-warning text-dark">Único</span>
                            @else
                                <span class="badge bg-secondary">Desconocido</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('talles.edit', $talle) }}" class="btn btn-sm btn-warning mb-1">✏️ Editar</a>
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
    </div>
@endif
</div>
@endsection

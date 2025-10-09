@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <!--/resources/views/clientes/index.blade.php-->


    <x-header-bar title="Clientes" :buttons="[
            ['text' => 'Nuevo Cliente', 'route' => route('clientes.create'), 'class' => 'btn-primary'],
            ['text' => 'Ver Eliminados', 'route' => route('clientes.eliminados'), 'class' => 'btn-secondary']
        ]"
        filterName="filtro" :filterValue="$filtro ?? ''" filterPlaceholder="Buscar por nombre, apellido o email"
        :filterRoute="route('clientes.index')" />
    
        <div class="container">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($clientes->isEmpty())
            <p>No hay clientes registrados.</p>
        @else
         <div class="table-responsive">
             <table class="table table-bordered table-sm  table-striped  align-middle text-center small shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Deuda</th>
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
                            @php
                                $deuda = $cliente->ventas->sum(function ($venta) {
                                    return $venta->total - $venta->pagado; // o el campo que tengas
                                });
                            @endphp

                            <td class="text-center">
                                @if ($deuda > 0)
                                    <span class="badge text-danger ">${{ number_format($deuda, 2) }}</span>
                                @else
                                    <span class="text-success" title="Sin deudas">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-info btn-sm" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    </div>
@endsection
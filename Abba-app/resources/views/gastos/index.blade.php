@extends('layouts.app')

@section('content')

  <x-header-bar
    title="Listado de Gastos"
    :buttons="[
        ['text' => '+ Nuevo Gasto', 'route' => route('gastos.create'), 'class' => 'btn-primary']
    ]"
    filterName="nombre"
    filterPlaceholder="Buscar gasto..."
    filterRoute="{{ route('gastos.index') }}"
/>

    <div class="container ">

@include('components.filtros._gastos')

        

        @if($gastos->count())
            <div class="text-end mt-3">
                {{-- Etiqueta descriptiva --}}
                <span class="fw-medium small text-muted">Total: </span>

                {{-- Suma del campo monto de todos los gastos filtrados --}}
                <span class="fw-bold text-success">
                    ${{ number_format($gastos->sum('monto'), 2, ',', '.') }}
                </span>
            </div>
        @endif


        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped table-sm align-middle">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase">
                            <th scope="col">Fecha</th>
                            <th scope="col">Monto ($)</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Descripción</th>
                            <th class="text-end" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gastos as $gasto)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                                <td class="fw-bold text-success">${{ number_format($gasto->monto, 2, ',', '.') }}</td>
                                <td>{{ $gasto->categoria ?? '-' }}</td>
                                <td>{{ $gasto->descripcion ?? '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('gastos.show', $gasto) }}"
                                        class="btn btn-outline-secondary btn-sm me-1">Ver</a>

                                    <form action="{{ route('gastos.destroy', $gasto) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar gasto? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No se registraron gastos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
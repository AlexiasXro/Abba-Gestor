@extends('layouts.app')

@section('content')

    <x-header-bar title="Listado de Ventas" :buttons="[
            ['text' => '+ Nueva Venta', 'route' => route('ventas.create'), 'class' => 'btn-primary']
        ]" filterName="cliente" filterValue="{{ request('cliente') }}"
        filterPlaceholder="Buscar cliente, DNI o teléfono..." filterRoute="{{ route('ventas.index') }}" />



    <div class="container">

    
 <div class="table-responsive">
        {{-- Tabla --}}
        <table class="table table-bordered table-sm  table-striped  align-middle text-center small shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Venta</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                    <th>Detalle</th> {{-- 🔍 Este es nuevo --}}
                </tr>
            </thead>
            <tbody>
                @forelse($devoluciones as $dev)
                    <tr>
                        <td>#{{ $dev->id }}</td>
                        <td>#{{ $dev->venta_id }}</td>
                        <td>{{ $dev->venta->cliente->nombre ?? 'Sin cliente' }}</td>
                        <td>{{ ucfirst($dev->tipo) }}</td>
                        <td>{{ $dev->cantidad }}</td>
                        <td>{{ $dev->motivo_texto }}</td>
                        <td>
                            <span class="badge {{ $dev->estado === 'activa' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($dev->estado) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($dev->fecha)->format('d/m/Y') }}</td>
                        <td>
                            @if($dev->estado === 'activa')
                                <form method="POST" action="{{ route('devoluciones.anular', $dev) }}"
                                    onsubmit="return confirm('¿Anular esta devolución?')">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-danger">Anular</button>
                                </form>
                            @else
                                <small class="text-muted">Anulada</small>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('devoluciones.show', $dev) }}" class="btn btn-sm btn-primary">
                                Ver detalle
                            </a>
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No se encontraron devoluciones.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
</div> 
        {{-- Paginación si aplica --}}
        {{ $devoluciones->links() }}
    </div>
@endsection
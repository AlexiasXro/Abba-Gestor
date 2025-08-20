@extends('layouts.app')

@section('content')

    <x-header-bar title="Listado de Ventas" :buttons="[
            ['text' => '+ Nueva Venta', 'route' => route('ventas.create'), 'class' => 'btn-primary']
        ]" filterName="cliente" filterValue="{{ request('cliente') }}"
        filterPlaceholder="Buscar cliente, DNI o teléfono..." filterRoute="{{ route('ventas.index') }}" />



    <div class="container">

    

        {{-- Filtros profesionales - Devoluciones --}}
        <form method="GET" action="{{ route('devoluciones.index') }}" class="mb-3">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2">

                {{-- ID de devolución --}}
                <div class="col">
                    <input type="text" name="id" value="{{ request('id') }}" class="form-control form-control-sm"
                        placeholder="ID devolución">
                </div>

                {{-- Venta relacionada --}}
                <div class="col">
                    <input type="text" name="venta" value="{{ request('venta') }}" class="form-control form-control-sm"
                        placeholder="N° Venta">
                </div>

                {{-- Cliente --}}
                <div class="col">
                    <input type="text" name="cliente" value="{{ request('cliente') }}" class="form-control form-control-sm"
                        placeholder="Cliente (nombre, DNI, teléfono)">
                </div>

                {{-- Tipo de devolución --}}
                <div class="col">
                    <select name="tipo" class="form-select form-select-sm">
                        <option value="">-- Tipo --</option>
                        <option value="total" {{ request('tipo') == 'total' ? 'selected' : '' }}>Total</option>
                        <option value="parcial" {{ request('tipo') == 'parcial' ? 'selected' : '' }}>Parcial</option>
                    </select>
                </div>

                {{-- Motivo --}}
                <div class="col">
                    <input type="text" name="motivo" value="{{ request('motivo') }}" class="form-control form-control-sm"
                        placeholder="Motivo">
                </div>

                {{-- Estado --}}
                <div class="col">
                    <select name="estado" class="form-select form-select-sm">
                        <option value="">-- Estado --</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="procesada" {{ request('estado') == 'procesada' ? 'selected' : '' }}>Procesada</option>
                        <option value="anulada" {{ request('estado') == 'anulada' ? 'selected' : '' }}>Anulada</option>
                    </select>
                </div>

                {{-- Fecha desde --}}
                <div class="col">
                    <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                        class="form-control form-control-sm">
                </div>

                {{-- Fecha hasta --}}
                <div class="col">
                    <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                        class="form-control form-control-sm">
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-2 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                <a href="{{ route('devoluciones.index') }}" class="btn btn-secondary btn-sm">Limpiar</a>
            </div>
        </form>

        {{-- Tabla --}}
        <table class="table table-bordered table-striped table-sm align-middle">
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

        {{-- Paginación si aplica --}}
        {{ $devoluciones->links() }}
    </div>
@endsection
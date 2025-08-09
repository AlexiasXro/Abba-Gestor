@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Listado de Devoluciones</h4>

        {{-- Mensajes de éxito --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" class="row g-2 mb-3">
    <div class="col-md-2">
        <input type="text" name="cliente" class="form-control" placeholder="Cliente" value="{{ request('cliente') }}">
    </div>
    <div class="col-md-2">
        <input type="number" name="venta_id" class="form-control" placeholder="ID Venta" value="{{ request('venta_id') }}">
    </div>
    <div class="col-md-2">
        <input type="number" name="producto_id" class="form-control" placeholder="ID Producto" value="{{ request('producto_id') }}">
    </div>
    <div class="col-md-2">
        <select name="tipo" class="form-select">
            <option value="">Tipo</option>
            <option value="devolucion" {{ request('tipo') == 'devolucion' ? 'selected' : '' }}>Devolución</option>
            <option value="garantia" {{ request('tipo') == 'garantia' ? 'selected' : '' }}>Garantía</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
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
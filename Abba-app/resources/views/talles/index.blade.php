@extends('layouts.app')

@section('title', 'Talles')

@section('content')

    <x-header-bar title="Listado de Talles" :buttons="[
            ['text' => '➕ Nuevo Talle', 'route' => route('talles.create'), 'class' => 'btn-primary']
        ]" />



    @if($talles->isEmpty())
        <p>No hay talles registrados.</p>
    @else
       <div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="table-responsive" style="max-width: 720px; width: 100%;">
            <table class="table table-bordered table-sm  table-striped  align-middle text-center small shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;"><i class="bi bi-hash"></i></th>
                        <th><i class="bi bi-tag-fill"></i> Talle</th>
                        <th><i class="bi bi-collection"></i> Categorías</th>
                        <th style="width: 140px;"><i class="bi bi-tools"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($talles as $talle)
                        @php
                            $categorias = \App\Models\Categoria::where('tipo_talle', $talle->tipo)->pluck('nombre')->toArray();
                        @endphp
                        <tr>
                            <td><code>{{ $talle->id }}</code></td>
                            <td><span class="fw-bold">{{ $talle->talle }}</span></td>
                            <td>
                                @if($categorias)
                                    <span class="text-muted">{{ implode(', ', $categorias) }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('talles.edit', $talle) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('talles.destroy', $talle) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar este talle?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center">
            {{ $talles->links() }}
            </div>
        </div>
    </div>
</div>

    @endif
    </div>
@endsection
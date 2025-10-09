@extends('layouts.app')

@section('title', 'Categorías')

@section('content')

<x-header-bar
    title="Listado de Categorías"
    :buttons="[
        ['text' => '➕ Nueva Categoría', 'route' => route('categorias.create'), 'class' => 'btn-primary']
    ]"
/>

@if($categorias->isEmpty())
    <p>No hay categorías registradas.</p>
@else
<div class="container mt-3">
    <div class="d-flex justify-content-center">
        <div class="table-responsive " style="max-width: 720px; width: 100%;">
            <table class="table table-bordered table-sm  table-striped  align-middle text-center small shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;"><i class="bi bi-hash"></i></th>
                        <th><i class="bi bi-bookmark-fill"></i> Nombre</th>
                        <th><i class="bi bi-rulers"></i> Usa talle</th>
                        <th><i class="bi bi-tags"></i> Tipo de talle</th>
                        <th style="width: 140px;"><i class="bi bi-tools"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorias as $categoria)
                        <tr>
                            <td><code>{{ $categoria->id }}</code></td>
                            <td class="fw-bold">{{ $categoria->nombre }}</td>
                            <td>
                                @if($categoria->usa_talle)
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if($categoria->usa_talle)
                                    <span class="text-muted">{{ ucfirst($categoria->tipo_talle) }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar esta categoría?')">
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

            <!-- Paginación -->
            <div class="mt-3 d-flex justify-content-center">
                {{ $categorias->links() }}
            </div>
        </div>
 



 <!-- Panel informativo -->
    <div class="col-md-4" id="infoPanel" style="display: none;">
       
        <div class="card border-info shadow-sm p-3">
            <h5 class="text-info fw-bold mb-3">¿Cómo funciona este módulo?</h5>
            <ul class="small text-muted ps-3">
                <li><strong>Nombre:</strong> Es el título general de la categoría. Ej: Ropa, Calzado, Juguetes.</li>
                <li><strong>¿Usa talle?</strong> Marcá “Sí” si los productos de esta categoría se venden por talles (como ropa o calzado).</li>
                <li><strong>Tipo de talle:</strong> Elegí el sistema de talles que se aplica. Esto permite mostrar talles correctos en el módulo de productos.</li>
                <li><strong>Ejemplos:</strong>
                    <ul>
                        <li>Ropa → talles XS a XXL</li>
                        <li>Calzado → talles 35 a 45</li>
                        <li>Niño → talles 2 a 14</li>
                    </ul>
                </li>
                <li>Si la categoría no usa talles (como Bazar o Electrónica), seleccioná “No” y dejá el tipo vacío.</li>
            </ul>
            <div class="alert alert-info mt-3 mb-0">
                Esta configuración impacta directamente en cómo se cargan productos y cómo se gestiona el stock por talle.
            </div>
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usaTalle = document.getElementById('usa_talle');
        const tipoTalleContainer = document.getElementById('tipoTalleContainer');
        const toggleInfo = document.getElementById('toggleInfo');
        const infoPanel = document.getElementById('infoPanel');

        function toggleTipoTalle() {
            tipoTalleContainer.style.display = usaTalle.value === '1' ? 'block' : 'none';
        }

        toggleInfo.addEventListener('click', function () {
            infoPanel.style.display = infoPanel.style.display === 'none' ? 'block' : 'none';
        });

        usaTalle.addEventListener('change', toggleTipoTalle);
        toggleTipoTalle(); // Ejecutar al cargar por si hay old()
    });
</script>

@endsection

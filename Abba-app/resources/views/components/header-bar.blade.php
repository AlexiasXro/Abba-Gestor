@props([
    'title' => 'Título',
    'filterName' => null,
    'filterValue' => '',
    'filterPlaceholder' => 'Buscar...',
    'filterRoute' => null,
    'buttons' => [],
])

<style>
    
.bg-pastel-blue {
  background-color: #cfe2ff; /* pastel azul claro */
  color: #084298; /* texto azul oscuro */
}
.bg-pastel-green {
  background-color: #d1e7dd; /* pastel verde claro */
  color: #0f5132; /* texto verde oscuro */
}
.bg-pastel-yellow {
  background-color: #fff3cd; /* pastel amarillo claro */
  color: #664d03; /* texto amarillo oscuro */
}
.bg-pastel-pink {
  background-color: #f8d7da; /* pastel rosa claro */
  color: #842029; /* texto rosa oscuro */
}
.bg-pastel-purple {
  background-color: #e2d9f3; /* pastel violeta claro */
  color: #4b367c; /* texto violeta oscuro */
}
</style>
{{-- resources/views/components/header-bar.blade.php --}}
@php
    // Opcional: definir color según título o variable explícita
    $colorClasses = [
        'Productos' => 'bg-pastel-blue',
        'Clientes' => 'bg-pastel-green',
        'Ventas' => 'bg-pastel-yellow',
        'Proveedores' => 'bg-pastel-pink',
        'Compras' => 'bg-pastel-purple',
    ];
    // Validar que $title sea string y exista en el array
    $titleKey = is_string($title) ? $title : '';
    $bgClass = $colorClasses[$titleKey] ?? 'bg-light';
@endphp

<div class="d-flex flex-wrap align-items-center justify-content-between mb-2 gap-2 p-2 {{ $bgClass }}" style="font-size: 0.9rem;">

    <div class="d-flex align-items-center gap-3 flex-grow-1 flex-wrap">
        <h4 class="d-flex align-items-center mb-0" style="font-weight: 600; min-width: 200px;">
            <span class="icon-bg d-flex justify-content-center align-items-center me-2" style="width: 24px; height: 24px; border-radius: 4px;">
                <img src="{{ asset('images/ico/P.png') }}" alt="Ícono producto" width="20" height="20" />
            </span>
            {{ $title }}
        </h4>

        <div class="btn-group flex-wrap">
            @if(!empty($buttons))
                @foreach ($buttons as $button)
                    <a href="{{ $button['route'] }}" class="btn btn-sm {{ $button['class'] ?? 'btn-secondary' }}">
                        {{ $button['text'] }}
                    </a>
                @endforeach
            @endif
        </div>
    </div>

     {{-- Botones extra (por ejemplo "Modificar recargo") --}}
    <div class="d-flex align-items-center gap-2">
        {{ $extraButtons ?? '' }}
    </div>

   @if(!empty($filterRoute) && !empty($filterName))
    <form method="GET" action="{{ $filterRoute }}" class="d-flex ms-auto" style="min-width: 250px; max-width: 400px;">
        <input 
            type="text" 
            name="{{ $filterName }}" 
            class="form-control form-control-sm" 
            placeholder="{{ $filterPlaceholder }}" 
            value="{{ $filterValue ?? '' }}"
            autocomplete="off"
        >
        <button type="submit" class="btn btn-outline-secondary btn-sm ms-2">Buscar</button>
    </form>
@endif

    
</div>


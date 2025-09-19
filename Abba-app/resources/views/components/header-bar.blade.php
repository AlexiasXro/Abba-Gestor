<!-- Abba-app\resources\views\components\header-bar.blade.php -->

@props([
    'title' => 'Título',
    'filterName' => null,
    'filterValue' => '',
    'filterPlaceholder' => 'Buscar...',
    'filterRoute' => null,
    'buttons' => [],
])

<div class="container">

    {{-- Título e ícono --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 p-2 border-bottom mb-3">
    {{-- Título e ícono --}}
    <div class="d-flex align-items-center gap-3 flex-grow-1 flex-wrap">
        <h4 class="d-flex align-items-center mb-0" style="font-weight: 600; min-width: 200px;">
            <span class="icon-bg d-flex justify-content-center align-items-center me-2" 
                  style="width: 24px; height: 24px; border-radius: 4px;">
                <img src="{{ asset('images/ico/P.png') }}" alt="Ícono producto" width="20" height="20" />
            </span>
            {{ $title }}
        </h4>
  

        {{-- Filtro opcional --}}
        @if(!empty($filterRoute) && !empty($filterName))
            <form method="GET" action="{{ $filterRoute }}" class="d-flex align-items-center gap-2">
                <input 
                    type="text" 
                    name="{{ $filterName }}" 
                    class="form-control form-control-sm" 
                    placeholder="{{ $filterPlaceholder }}" 
                    value="{{ $filterValue ?? '' }}"
                    autocomplete="off"
                >
                <button type="submit" class="btn btn-primary p-1 btn-sm">Buscar</button>
            </form>

        @endif
        
    </div>
   

    {{-- Botones --}}
    {{-- Botones --}}  
<div class="d-flex align-items-center gap-2 flex-wrap ">
    @if(!empty($buttons))
        @foreach ($buttons as $button)
            <a href="{{ $button['route'] }}" class="btn btn-sm {{ $button['class'] ?? 'btn-success' }}">
                {{ $button['text'] }}
            </a>
        @endforeach
    @endif
    {{-- Botones extra opcionales --}}
    {{ $extraButtons ?? '' }}

    {{-- Botón "Atrás" con ícono siempre visible --}}
    <a href="javascript:history.back()" class="btn btn-sm btn-success d-flex align-items-center gap-1">
        <i class="bi bi-arrow-left me-1"></i> Atrás
    </a>

    
</div>
 </div>
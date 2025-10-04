@props([
    'title' => 'Título',
    'filterName' => null,
    'filterValue' => '',
    'filterPlaceholder' => 'Buscar...',
    'filterRoute' => null,
    'buttons' => [],
])

<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2  py-2 border-bottom mb-2">
        {{-- Título e ícono --}}
        <div class="d-flex align-items-center gap-3 flex-grow-1 flex-wrap">
            <h4 class="d-flex align-items-center mb-0" style="font-weight: 600; min-width: 200px;">
                <span class="icon-bg d-flex justify-content-center align-items-center me-2" 
                      style="width: 24px; height: 24px; border-radius: 4px;">
                    
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

                    {{-- Slot extra al lado del buscador --}}
                    {{ $filterExtra ?? '' }}
                </form>
            @endif
        </div>

        {{-- Botones --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @if(!empty($buttons))
                @foreach ($buttons as $button)
                    <a href="{{ $button['route'] }}" class="btn btn-sm {{ $button['class'] ?? 'btn-success' }}">
                        {{ $button['text'] }}
                    </a>
                @endforeach
            @endif

            {{ $extraButtons ?? '' }}

            {{-- Botón "Atrás" --}}
            <a href="javascript:history.back()" class="btn btn-sm btn-success d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left me-1"></i> Atrás
            </a>
        </div>
    </div>
</div>

@props([
    'title' => 'Título',
    'filterName' => null,
    'filterValue' => '',
    'filterPlaceholder' => 'Buscar...',
    'filterRoute' => null,
    'buttons' => [],
])

<div class="container-fluid"  style="font-size: 0.9rem; 
            background: linear-gradient(90deg, #eeebf5ff, #402ba0d8, #343235ff);
            border-radius: 0px;">
<div class="d-flex flex-wrap align-items-center justify-content-between  gap-2 p-2" 
     ">

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
    
            <div class="d-flex align-items-center gap-2">
    <label for="tipoCodigo" class="form-label mb-0 text-white">Ver:</label>
    <select id="tipoCodigo" class="form-select form-select-sm" style="width: 140px;">
        <option value="qr">Código QR</option>
        <option value="barra">Código de barras</option>
    </select>
</div>



        @endif
    </div>
   

    {{-- Botones --}}
    <div class="d-flex align-items-center gap-2 flex-wrap ">
        @if(!empty($buttons))
            @foreach ($buttons as $button)
                <a href="{{ $button['route'] }}" class="btn btn-sm {{ $button['class'] ?? 'btn-success' }}">
                    {{ $button['text'] }}
                </a>
            @endforeach
        @endif

        {{-- Botón "Atrás" con ícono siempre visible --}}
        <a href="javascript:history.back()" class="btn btn-sm btn-success d-flex align-items-center gap-1">
            <i class="bi bi-arrow-left me-1"></i> Atrás
        </a>

        {{-- Botones extra opcionales --}}
        {{ $extraButtons ?? '' }}
    </div>
</div>
</div>
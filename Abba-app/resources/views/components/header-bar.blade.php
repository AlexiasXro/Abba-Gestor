@props([
    'title' => 'Título',
    
    'filterName' => null,
    'filterValue' => '',
    'filterPlaceholder' => 'Buscar...',
    'filterRoute' => null,
    'buttons' => [],
])

<style>
    .header-gradient {
    background: linear-gradient(90deg, #cfe2ff, #e2d9f3, #d1e7dd); /* azul → violeta → verde */
    color: #fff;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
}
</style>


{{-- resources/views/components/header-bar.blade.php --}}


<div class="d-flex flex-wrap align-items-center justify-content-between mb-2 gap-2 p-2 " 
style="font-size: 0.9rem; 
            background: linear-gradient(90deg, #6c5ca3, #7f6fbf, #5a7f6b);
            
            border-radius: 4px;">
    

    <div class="d-flex align-items-center gap-3 flex-grow-1 flex-wrap">
        <h4 class="d-flex align-items-center mb-0" style="font-weight: 600; min-width: 200px;">
            <span class="icon-bg d-flex justify-content-center align-items-center me-2" style="width: 24px; height: 24px; border-radius: 4px;">
                <img src="{{ asset('images/ico/P.png') }}" alt="Ícono producto" width="20" height="20" />
            </span>
            {{ $title }}
        </h4>


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
            <button type="submit" class="btn  btn-primary  p-1 btn-sm"> Buscar</button>
        </form>
    

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

 
@endif
 </div> 
  </div>
    



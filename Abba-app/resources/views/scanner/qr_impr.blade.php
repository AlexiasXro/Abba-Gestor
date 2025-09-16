@extends('layouts.app')

@section('content')
    {{-- resources/views/scanner/qr_impr.blade.php --}}

    @php
        // Botones del header para la vista de impresión de QR
        $headerButtons = [
            ['text' => '← Volver', 'route' => url()->previous(), 'class' => 'btn-outline-secondary'],
        ];

        // Si necesitas talles aquí también, puedes mantenerlo
        $todosLosTalles = \App\Models\Talle::orderBy('talle')->get();
    @endphp

    <x-header-bar 
        title="Impresión de Códigos QR" 
        :buttons="$headerButtons" 
       
    />

<div class="container my-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
    <h4 class="mb-0">Seleccionar Códigos para Imprimir</h4>
    <button type="button" class="btn btn-success" onclick="imprimirSeleccionados()">🖨️ Imprimir Seleccionados</button>
</div>


    <form id="qrForm">
        <div class="row">
            @foreach($productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card p-3">
                        <label>
                            <input type="checkbox" name="productos[]" value="{{ $producto->id }}">
                            <strong>{{ $producto->nombre }}</strong>
                        </label>
                        <div class="mt-2 text-center">
                            <img src="{{ asset('storage/qrs/' . $producto->qr_filename) }}" alt="QR de {{ $producto->nombre }}" class="img-fluid" style="max-height: 150px;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        
    </form>
</div>

{{-- Vista oculta para impresión --}}
<div id="printArea" style="display: none;">
    <div class="container my-5">
        <h2 class="mb-4">Códigos Seleccionados</h2>
        <div class="row" id="qrSeleccionados"></div>
    </div>
</div>

<script>
    function imprimirSeleccionados() {
        const checkboxes = document.querySelectorAll('input[name="productos[]"]:checked');
        const qrSeleccionados = document.getElementById('qrSeleccionados');
        qrSeleccionados.innerHTML = '';

        checkboxes.forEach(cb => {
            const card = cb.closest('.card');
            const clone = card.cloneNode(true);
            clone.querySelector('input').remove(); // Elimina el checkbox
            qrSeleccionados.appendChild(clone);
        });

        const printArea = document.getElementById('printArea');
        printArea.style.display = 'block';

        window.print();

        printArea.style.display = 'none';
    }
</script>

@endsection

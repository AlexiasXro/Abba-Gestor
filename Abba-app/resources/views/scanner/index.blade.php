<!-- //Abba-app\resources\views\scanner\index.blade.php -->
@extends('layouts.app')


@section('content')
    {{-- resources/views/scanner/index.blade.php --}}

    @php
        // Botón único para volver atrás
        $headerButtons = [
            ['text' => '← Volver', 'route' => url()->previous(), 'class' => 'btn-outline-secondary'],
        ];
    @endphp

    <x-header-bar title="Panel de Escaneo" :buttons="$headerButtons" />

    <div class="row my-5">
        <div class="col-md-6">
            <div class="container">
                <div class="card shadow-sm p-4 mx-auto" style="max-width: 500px;">
                    <h3 class="card-title text-center mb-4">Escáner QR</h3>
                    <div id="reader" class="mb-3" style="width: 100%; height: auto;"></div>
                    <div class="alert alert-light text-center mt-3" role="alert">
                        <strong>Resultado:</strong> <span id="result">Esperando...</span>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-primary">Reiniciar Escaneo</button>
                    </div>
                    <!-- Mensaje de servicio PRO -->
                    <div class="points-animation cartel container-sm p-4 my-4 text-center rounded  shadow-xs">
                        <h3 class="mb-3 titulo-cartel">¡Habilitalo ahora!</h3>
                        <p>
                            Este escáner está disponible para <br>sistemas con <strong>dominio propio</strong>.<br>
                            Acceder a todas las funciones, este servicio requiere una <strong>membresía</strong>.
                        </p>
                        <button class="btn btn-pro btn-md mt-3">Ver Planes</button>
                        <p class="mt-2">
                            <span class="link-simulado"><a href="#" class="text-decoration-none text-reset">Página de
                                    servicio</a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-6">
            <div class="container">
                <div class="card shadow-sm p-4 mx-auto" style="max-width: 500px;">
                    <h3 class="card-title text-center mb-4">
                        <i class="bi bi-upc-scan me-2"></i>Escáner con lector físico
                    </h3>

                    <div class="text-center mb-3">
                        <img src="{{ asset('images/ico/scanner-icon-gray.svg') }}" alt="Scanner" class="img-fluid" style="max-width:100px;">
                        <p class="mt-2 text-muted" style="font-size: 0.9rem;">
                            Conectá tu lector USB y escaneá el código de barras directamente en el campo.
                        </p>
                    </div>

                    <input type="text" id="codigoBarra" class="form-control text-center" placeholder="Escaneá aquí..."
                        autofocus>

                    <div class="alert alert-light text-center mt-3" role="alert">
                        <strong>Resultado:</strong> <span id="resultBarra">Esperando...</span>
                    </div>
                     <div class="points-animation cartel container-sm p-4 my-4 text-center rounded shadow-xs">
    
</div>

                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById("codigoBarra").addEventListener("change", function () {
            const codigo = this.value.trim();
            document.getElementById("resultBarra").innerText = codigo;
            if (codigo) {
                window.open("/productos/" + codigo, "_blank");
            }
            this.value = "";
        });
    </script>

    <!-- Cargar librería -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById("result").innerText = decodedText;

            // Redirigir al show del producto
            //"productos/" + decodedText": arma la URL del producto.
            // "_blank": indica que se abra en una nueva pestaña o ventana.
            window.open("/productos/" + decodedText, "_blank");

        }

        function onScanError(errorMessage) {
            console.warn(`Error en escaneo: ${errorMessage}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: 250 }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
@endsection
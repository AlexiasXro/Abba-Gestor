<!-- //Abba-app\resources\views\scanner\index.blade.php -->
@extends('layouts.app')

@section('content')

<div class="points-animation cartel container-sm p-4 my-4 text-center rounded  shadow-xs">
    <h3 class="mb-3 titulo-cartel">Escáner habilitado</h3>
    <p>
      Este escáner está disponible para sistemas con <strong>dominio propio</strong>.<br>
      Para acceder a todas las funciones, este servicio requiere una <strong>membresía PRO de pago</strong>.
    </p>
    <button class="btn btn-pro btn-md mt-3">Ver Planes PRO</button>
    <p class="mt-2">
      <span class="link-simulado"><a href="#" class="text-decoration-none text-reset">Página de servicio</a></span>
    </p>
  </div>

<div class="container my-5">
    <div class="card shadow-sm p-4 mx-auto" style="max-width: 500px;">
        <h3 class="card-title text-center mb-4">Escáner de desabilitado</h3>
        <div id="reader" class="mb-3" style="width: 100%; height: auto;"></div>
        <div class="alert alert-light text-center mt-3" role="alert">
            <strong>Resultado:</strong> <span id="result">Esperando...</span>
        </div>
        <div class="text-center mt-3">
            <button class="btn btn-primary">Reiniciar Escaneo</button>
        </div>
    </div>
</div>

<!-- Cargar librería -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById("result").innerText = decodedText;

        // Redirigir al show del producto
        window.location.href = "/productos/" + decodedText;
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

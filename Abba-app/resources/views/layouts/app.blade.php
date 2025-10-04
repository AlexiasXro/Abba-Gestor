<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Mi App')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- htmx -->
    <script src="https://unpkg.com/htmx.org@1.9.2"></script>

    <link rel="stylesheet" href="{{ asset('css/aspecto.css') }}" />

    {{-- Iconos Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const aspecto = localStorage.getItem("aspecto") || "aspecto-claro";
            document.body.classList.add(aspecto);
        });
    </script>
</head>

<body class="" style="font-size: 0.9rem; 
            background: linear-gradient(180deg, #f5f5f5, #e0e0e0, #160f36d8); 
            border-radius: 0px;">
    
  {{-- Navbar completo --}}
    @include('layouts.nav_full')

    {{-- Mensajes de sesión --}}

    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    @if(session('warning'))
        <x-alert type="warning" :message="session('warning')" />
    @endif

    @if(session('info'))
        <x-alert type="info" :message="session('info')" />
    @endif


    {{-- Contenedor principal --}}
    <div class="container-fluid" style="
        font-size: 0.9rem; 
        font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.5;
        color: #212529;
        background: linear-gradient(180deg, #f5f5f5ff, #e9e9e9ff, #e4e4e4ff, #8f7bf0ff); 
       
        min-height: 100vh;
        border-radius: 0px;
        overflow-x: hidden;
     ">


        {{-- Contenido dinámico --}}
        @yield('content')


    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!--Generador  de QR-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>


    <script>
        document.getElementById("tipoCodigo").addEventListener("change", function () {
            const tipo = this.value;
            document.querySelectorAll(".qr-codigo").forEach(el => el.style.display = tipo === "qr" ? "block" : "none");
            document.querySelectorAll(".barra-codigo").forEach(el => el.style.display = tipo === "barra" ? "block" : "none");
        });
    </script>
    
    <!-- <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.body.classList.add("fade-in");
        });

        window.addEventListener("beforeunload", () => {
            document.body.classList.remove("fade-in");
            document.body.classList.add("fade-out");
        });
    </script> -->

</body>

</html>
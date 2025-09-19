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

    <style>
        /* Animaciones globales */
        .fade-in { animation: fadeIn 0.6s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .fade-out { animation: fadeOut 0.4s ease-in-out forwards; }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }

        /* Wrapper principal */
        body {
            font-size: 0.9rem;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
            color: #fff;
            background: linear-gradient(180deg, #343235ff, #2f2074d8, #7c6e9cff);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Hover suave para botones */
        .btn-secondary:hover, .btn-outline-secondary:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease-in-out;
        }

        /* Cards del login */
        .login-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            background-color: #fff;
        }

        /* Texto de info */
        .info-box h5 { color: #d8c7ff; }
        .info-box p { color: #e0e0e0; }

        @media (max-width: 768px) {
            .login-card { margin-bottom: 1.5rem; }
        }
    </style>
</head>

<body>
    
   {{-- Aquí se renderiza el contenido de la vista --}}
    @yield('content')

  <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => { document.body.classList.add("fade-in"); });
        window.addEventListener("beforeunload", () => {
            document.body.classList.remove("fade-in");
            document.body.classList.add("fade-out");
        });
    </script>
</body>

</html>
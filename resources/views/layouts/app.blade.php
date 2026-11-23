<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Académico')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f1f5f9;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .main-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
    </style>
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('records.index') }}">
                Práctica 1.3 · Sistema Académico
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end text-light small">
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <span class="badge {{ auth()->user()->isProfesor() ? 'bg-primary' : 'bg-success' }}">
                        {{ strtoupper(auth()->user()->role) }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Salir</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <main class="container pb-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
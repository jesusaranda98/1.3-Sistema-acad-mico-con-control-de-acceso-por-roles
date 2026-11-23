@extends('layouts.app')

@section('title', 'Iniciar Sesión · Sistema Académico')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="col-md-6 col-lg-5">
        <div class="card main-card bg-white p-4 p-md-5">
            <div class="text-center mb-4">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 mb-2">
                    Práctica 1.3 · Control Académico
                </span>
                <h3 class="fw-bold text-dark mb-1">Iniciar Sesión</h3>
                <p class="text-muted small mb-0">
                    Consulta y administración de calificaciones y faltas
                </p>
            </div>

            @if (session('success'))
                <div class="alert alert-success small">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-control form-control-lg" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                    <input type="password" id="password" name="password"
                           class="form-control form-control-lg" required>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">Recordar sesión</label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 fw-semibold">
                    Entrar al sistema
                </button>
            </form>

            <hr class="my-4">
            <div class="bg-light rounded-3 p-3 small text-muted">
                <div class="fw-semibold text-dark mb-1">Cuentas de prueba:</div>
                <div><strong>Profesor:</strong> profesor@escuela.edu.mx / <code>Profesor1234!</code></div>
                <div><strong>Alumno:</strong> alumno@escuela.edu.mx / <code>Alumno1234!</code></div>
            </div>
        </div>
    </div>
</div>
@endsection
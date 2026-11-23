@extends('layouts.app')

@section('title', 'Editar Registro Académico')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card main-card bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Editar Alumno</h4>
                <a href="{{ route('records.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('records.update', $record) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="student_name" class="form-label fw-semibold">Nombre del alumno</label>
                    <input type="text" id="student_name" name="student_name" value="{{ old('student_name', $record->student_name) }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="absences" class="form-label fw-semibold">Número de faltas (0 a 100)</label>
                    <input type="number" id="absences" name="absences" value="{{ old('absences', $record->absences) }}"
                           min="0" max="100" step="1" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="grade" class="form-label fw-semibold">Calificación numérica (0.0 a 10.0)</label>
                    <input type="number" id="grade" name="grade" value="{{ old('grade', $record->grade) }}"
                           min="0" max="10" step="0.1" class="form-control" required>
                    <div class="form-text">
                        Equivalencia actual: <strong>{{ $record->equivalence_code }}</strong> ({{ $record->equivalence_label }}). Se recalculará automáticamente al guardar.
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-semibold">Actualizar registro</button>
            </form>
        </div>
    </div>
</div>
@endsection
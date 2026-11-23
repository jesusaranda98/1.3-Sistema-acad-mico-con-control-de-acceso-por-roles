@extends('layouts.app')

@section('title', 'Registros Académicos')

@section('content')
<div class="card main-card bg-white p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Información Académica</h3>
            <p class="text-muted small mb-0">
                @if ($isProfesor)
                    Vista de Profesor: registra, edita o elimina registros y ordena por nombre, calificación o faltas.
                @else
                    Vista de Alumno: consulta de tu nombre, faltas, calificación y equivalencia alfabética.
                @endif
            </p>
        </div>

        @if ($isProfesor)
            <a href="{{ route('records.create') }}" class="btn btn-primary fw-semibold">
                + Registrar alumno
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="bg-light rounded-3 p-3 mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="small fw-semibold text-dark">
                Ordenar registros:
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('records.index', ['sort_by' => 'student_name', 'direction' => ($sortBy === 'student_name' && $direction === 'asc') ? 'desc' : 'asc']) }}"
                   class="btn btn-sm {{ $sortBy === 'student_name' ? 'btn-dark' : 'btn-outline-dark' }}">
                    Nombre ({{ ($sortBy === 'student_name' && $direction === 'desc') ? 'Z-A' : 'A-Z' }})
                </a>

                <a href="{{ route('records.index', ['sort_by' => 'grade', 'direction' => 'desc']) }}"
                   class="btn btn-sm {{ ($sortBy === 'grade' && $direction === 'desc') ? 'btn-dark' : 'btn-outline-dark' }}">
                    Calificación: Mayor a menor
                </a>

                <a href="{{ route('records.index', ['sort_by' => 'grade', 'direction' => 'asc']) }}"
                   class="btn btn-sm {{ ($sortBy === 'grade' && $direction === 'asc') ? 'btn-dark' : 'btn-outline-dark' }}">
                    Calificación: Menor a mayor
                </a>

                <a href="{{ route('records.index', ['sort_by' => 'absences', 'direction' => 'desc']) }}"
                   class="btn btn-sm {{ ($sortBy === 'absences' && $direction === 'desc') ? 'btn-dark' : 'btn-outline-dark' }}">
                    Faltas: Mayor a menor
                </a>

                <a href="{{ route('records.index', ['sort_by' => 'absences', 'direction' => 'asc']) }}"
                   class="btn btn-sm {{ ($sortBy === 'absences' && $direction === 'asc') ? 'btn-dark' : 'btn-outline-dark' }}">
                    Faltas: Menor a mayor
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre del alumno</th>
                    <th class="text-center">Número de faltas</th>
                    <th class="text-center">Calificación numérica</th>
                    <th class="text-center">Equivalencia alfabética</th>
                    @if ($isProfesor)
                        <th class="text-end">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    @php
                        $code = $record->equivalence_code;
                        $badgeClass = match ($code) {
                            'AU' => 'bg-success',
                            'DE' => 'bg-primary',
                            'SA' => 'bg-warning text-dark',
                            default => 'bg-danger',
                        };
                    @endphp
                    <tr>
                        <td class="fw-semibold">{{ $record->student_name }}</td>
                        <td class="text-center">{{ $record->absences }}</td>
                        <td class="text-center fw-semibold">{{ number_format($record->grade, 1) }}</td>
                        <td class="text-center">
                            <span class="badge {{ $badgeClass }}">
                                {{ $code }}
                            </span>
                            <span class="text-muted small ms-1">({{ $record->equivalence_label }})</span>
                        </td>
                        @if ($isProfesor)
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('records.edit', $record) }}" class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('records.destroy', $record) }}"
                                          onsubmit="return confirm('¿Eliminar el registro de {{ $record->student_name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isProfesor ? 5 : 4 }}" class="text-center py-4 text-muted">
                            No hay registros académicos disponibles para mostrar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top small text-muted">
        <strong>Escala automática:</strong>
        <span class="badge bg-danger ms-1">NA</span> No Acreditado (&lt; 6.0) ·
        <span class="badge bg-warning text-dark">SA</span> Suficiente (6.0 – 7.4) ·
        <span class="badge bg-primary">DE</span> Destacado (7.5 – 8.9) ·
        <span class="badge bg-success">AU</span> Autónomo (9.0 – 10.0)
    </div>
</div>
@endsection
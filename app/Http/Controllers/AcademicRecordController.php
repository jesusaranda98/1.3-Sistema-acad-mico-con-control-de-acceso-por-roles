<?php

namespace App\Http\Controllers;

use App\Models\StudentRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AcademicRecordController extends Controller
{
    public function index(Request $request): View
    {
        $sortBy = (string) $request->input('sort_by', 'student_name');
        $direction = strtolower((string) $request->input('direction', 'asc'));

        $allowedColumns = [
            'student_name' => 'student_name',
            'grade' => 'grade',
            'absences' => 'absences',
        ];

        $column = $allowedColumns[$sortBy] ?? 'student_name';
        $dir = in_array($direction, ['asc', 'desc'], true) ? $direction : 'asc';

        $query = StudentRecord::query();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAlumno()) {
            $query->where('user_id', $user->id);
        }

        $records = $query->orderBy($column, $dir)->get();

        return view('records.index', [
            'records' => $records,
            'sortBy' => $sortBy,
            'direction' => $dir,
            'isProfesor' => $user->isProfesor(),
        ]);
    }

    public function create(): View
    {
        if (! Auth::user()?->isProfesor()) {
            abort(403, 'Solo los profesores pueden registrar alumnos.');
        }

        return view('records.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (! Auth::user()?->isProfesor()) {
            abort(403, 'Solo los profesores pueden registrar alumnos.');
        }

        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:150'],
            'absences' => ['required', 'integer', 'min:0', 'max:100'],
            'grade' => ['required', 'numeric', 'min:0', 'max:10'],
        ], [
            'student_name.required' => 'El nombre del alumno es obligatorio.',
            'absences.required' => 'El número de faltas es obligatorio.',
            'absences.integer' => 'El número de faltas debe ser un entero.',
            'absences.min' => 'El número de faltas no puede ser menor a 0.',
            'absences.max' => 'El número de faltas no puede ser mayor a 100.',
            'grade.required' => 'La calificación numérica es obligatoria.',
            'grade.numeric' => 'La calificación numérica debe ser un número válido.',
            'grade.min' => 'La calificación no puede ser menor a 0.',
            'grade.max' => 'La calificación no puede ser mayor a 10.',
        ]);

        StudentRecord::create([
            'student_name' => $validated['student_name'],
            'absences' => $validated['absences'],
            'grade' => round((float) $validated['grade'], 2),
        ]);

        return redirect()->route('records.index')
            ->with('success', 'Alumno registrado correctamente. Equivalencia calculada automáticamente.');
    }

    public function edit(StudentRecord $record): View
    {
        if (! Auth::user()?->isProfesor()) {
            abort(403, 'Solo los profesores pueden modificar registros académicos.');
        }

        return view('records.edit', [
            'record' => $record,
        ]);
    }

    public function update(Request $request, StudentRecord $record): RedirectResponse
    {
        if (! Auth::user()?->isProfesor()) {
            abort(403, 'Solo los profesores pueden modificar registros académicos.');
        }

        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:150'],
            'absences' => ['required', 'integer', 'min:0', 'max:100'],
            'grade' => ['required', 'numeric', 'min:0', 'max:10'],
        ], [
            'student_name.required' => 'El nombre del alumno es obligatorio.',
            'absences.required' => 'El número de faltas es obligatorio.',
            'absences.integer' => 'El número de faltas debe ser un entero.',
            'absences.min' => 'El número de faltas no puede ser menor a 0.',
            'absences.max' => 'El número de faltas no puede ser mayor a 100.',
            'grade.required' => 'La calificación numérica es obligatoria.',
            'grade.numeric' => 'La calificación numérica debe ser un número válido.',
            'grade.min' => 'La calificación no puede ser menor a 0.',
            'grade.max' => 'La calificación no puede ser mayor a 10.',
        ]);

        $record->update([
            'student_name' => $validated['student_name'],
            'absences' => $validated['absences'],
            'grade' => round((float) $validated['grade'], 2),
        ]);

        return redirect()->route('records.index')
            ->with('success', 'Registro académico actualizado correctamente.');
    }

    public function destroy(StudentRecord $record): RedirectResponse
    {
        if (! Auth::user()?->isProfesor()) {
            abort(403, 'Solo los profesores pueden eliminar registros académicos.');
        }

        $record->delete();

        return redirect()->route('records.index')
            ->with('success', 'Registro académico eliminado correctamente.');
    }
}
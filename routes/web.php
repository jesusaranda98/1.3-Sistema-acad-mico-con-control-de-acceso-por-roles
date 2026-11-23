<?php

use App\Http\Controllers\AcademicRecordController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Consulta académica: accesible para Profesor y Alumno (el alumno solo ve su información)
Route::middleware(['auth', 'role:profesor,alumno'])->group(function () {
    Route::get('/academico', [AcademicRecordController::class, 'index'])->name('records.index');
});

// Operaciones de gestión académica: exclusivas para Profesor
Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::get('/academico/crear', [AcademicRecordController::class, 'create'])->name('records.create');
    Route::post('/academico', [AcademicRecordController::class, 'store'])->name('records.store');
    Route::get('/academico/{record}/editar', [AcademicRecordController::class, 'edit'])->name('records.edit');
    Route::put('/academico/{record}', [AcademicRecordController::class, 'update'])->name('records.update');
    Route::delete('/academico/{record}', [AcademicRecordController::class, 'destroy'])->name('records.destroy');
});
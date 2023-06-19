<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\ImparteController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\CursaController;
use App\Http\Controllers\AsistenciasController;

// Panel docente
Route::middleware('auth')->group(function() {
  Route::get('/', [ImparteController::class, 'index'])->name('home');
  Route::get('/notas/{imparte}', [NotasController::class, 'show'])->name('docente.estudiantes');
  Route::post('/notas/create', [NotasController::class, 'store'])->name('docente.estudiantes.notas.store');
  Route::put('/perfil/{docente}', [DocenteController::class, 'update'])->name('docente.perfil.update');
  Route::get('/notas/excel/{imparte}', [NotasController::class, 'generate_excel'])->name('docente.estudiantes.excel');
  Route::get('/notas/pdf/{imparte}', [NotasController::class, 'generate_pdf'])->name('docente.estudiantes.pdf');
  Route::prefix('laboratorios')->group(function() {
    Route::get('/{imparte}', [LaboratorioController::class, 'index'])->name('docente.laboratorios.index');
    Route::post('/', [LaboratorioController::class, 'store'])->name('docente.laboratorios.store');
    Route::put('/{laboratorio}', [LaboratorioController::class, 'update'])->name('docente.laboratorios.update');
  });
  Route::prefix('asistencias')->group(function() {
    Route::get('/{imparte}', [AsistenciasController::class, 'index'])->name('docente.asistencias.index');
    Route::post('/{imparte}', [AsistenciasController::class, 'store'])->name('docente.asistencias.store');
    Route::put('/{asistencia}', [AsistenciasController::class, 'update'])->name('docente.asistencias.update');
    Route::delete('/{asistencia}', [AsistenciasController::class, 'destroy'])->name('docente.asistencias.destroy');
  });
});

// Panel administrador
Route::prefix('/admin')->group(function() {
  Route::prefix('/dashboard')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard.index');
    Route::prefix('docentes')->group(function() {
      Route::get('/', [DocenteController::class, 'index'])->name('admin.dashboard.docentes.index');
      Route::post('/store', [DocenteController::class, 'store'])->name('admin.dashboard.docentes.store');
      Route::post('/store-many', [DocenteController::class, 'store_many'])->name('admin.dashboard.docentes.store-many');
      Route::put('/update/{docente}', [DocenteController::class, 'update'])->name('admin.dashboard.docentes.update');
      Route::get('/{id}', [DocenteController::class, 'show'])->name('admin.dashboard.docentes.show');
      Route::prefix('asignaciones')->group(function() {
        Route::put('/update', [ImparteController::class, 'update'])->name('admin.dashboard.docentes.asignaciones.update');
        Route::post('/create', [ImparteController::class, 'store'])->name('admin.dashboard.docentes.asignaciones.store');
      });
    });
    Route::prefix('estudiantes')->group(function() {
      Route::get('/', [EstudianteController::class, 'index'])->name('admin.dashboard.estudiantes.index');
      Route::post('/store', [EstudianteController::class, 'store'])->name('admin.dashboard.estudiantes.store');
      Route::post('/store-many', [EstudianteController::class, 'store_many'])->name('admin.dashboard.estudiantes.store-many');
      Route::put('/update', [EstudianteController::class, 'update'])->name('admin.dashboard.estudiantes.update');
      Route::get('/{id}', [EstudianteController::class, 'show'])->name('admin.dashboard.estudiantes.show');
      Route::prefix('asignaciones')->group(function() {
        Route::put('/update', [CursaController::class, 'update'])->name('admin.dashboard.estudiantes.asignaciones.update');
        Route::post('/create', [CursaController::class, 'store'])->name('admin.dashboard.estudiantes.asignaciones.store');
        Route::delete('/delete/{cursa_id}', [CursaController::class, 'destroy'])->name('admin.dashboard.estudiantes.asignaciones.delete');
      });
    });
    Route::prefix('materias')->group(function() {
      Route::get('/', [MateriaController::class, 'index'])->name('admin.dashboard.materias.index');
      Route::post('/', [MateriaController::class, 'store'])->name('admin.dashboard.materias.store');
      Route::put('/{materia}', [MateriaController::class, 'update'])->name('admin.dashboard.materias.update');
      Route::delete('/{materia}', [MateriaController::class, 'destroy'])->name('admin.dashboard.materias.destroy');
    });
  });
});

Route::middleware('guest')->group(function() {
  Route::view('/login', 'auth.login')->name('login');
  Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

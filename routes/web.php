<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\ImparteController;
use App\Http\Controllers\AsignacionController;

// Panel docente
Route::middleware('auth')->group(function() {
  Route::get('/', [ImparteController::class, 'index'])->name('home');
  Route::get('/notas/{codigo}/{periodo}/{gestion}/{turno}', [NotasController::class, 'show'])->name('docente.estudiantes');
});

// Panel administrador
Route::prefix('/admin')->group(function() {
  Route::prefix('/dashboard')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard.index');
    Route::prefix('docentes')->group(function() {
      Route::get('/', [DocenteController::class, 'index'])->name('admin.dashboard.docentes.index');
      Route::get('/create', [DocenteController::class, 'create'])->name('admin.dashboard.docentes.create');
      Route::post('/store', [DocenteController::class, 'store'])->name('admin.dashboard.docentes.store');
      Route::put('/update', [DocenteController::class, 'update'])->name('admin.dashboard.docentes.update');
      Route::delete('/delete', [DocenteController::class, 'destroy'])->name('admin.dashboard.docentes.destroy');
      Route::get('/{id}', [DocenteController::class, 'show'])->name('admin.dashboard.docentes.show');
    });
    Route::prefix('asignaciones')->group(function() {
      Route::put('/update', [AsignacionController::class, 'update'])->name('admin.dashboard.asignaciones.update');
    });
    Route::prefix('materias')->group(function() {
      Route::get('/', [MateriaController::class, 'index'])->name('admin.dashboard.materias.index');
    });
  });
});

Route::middleware('guest')->group(function() {
  Route::view('/login', 'auth.login')->name('login');
  Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

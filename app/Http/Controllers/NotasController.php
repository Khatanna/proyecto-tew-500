<?php

namespace App\Http\Controllers;

use App\Models\Imparte;
use App\Models\Materia;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class NotasController extends Controller
{
  public function show(Authenticatable $user, Request $request, $codigo, $periodo, $gestion, $turno)
  {
    $materia = Materia::where('codigo', $codigo)->first();
    $imparte = Imparte::where([
      ["docente_id", "=", $user->id],
      ["materia_id", "=", $materia->id],
      ["gestion", "=", $gestion],
      ["periodo", "=", $periodo],
      ["turno", "=", $turno]
    ])
      ->firstOrFail();
    $estudiantes = $imparte->estudiantes;
    $laboratorios = $imparte->laboratorios;
    $asistencias = $imparte->asistencias;
    $imparte_id = $imparte->id;
    return view("docente.notas.index", compact('estudiantes', 'laboratorios', 'asistencias', 'imparte_id'));
  }
}

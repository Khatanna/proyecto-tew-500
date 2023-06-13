<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Cursa;
use App\Models\Imparte;
use App\Models\Materia;
use App\Models\NotasAsistencia;
use App\Models\NotasLaboratorio;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
  public function index(Imparte $imparte)
  {
    $materia = Materia::find($imparte->Materia_id);
    $asistencias = $imparte->asistencias;

    return view('docente.asistencias.index', compact('asistencias', 'materia', 'imparte'));
  }

  public function store(Request $request, Imparte $imparte)
  {
    Asistencia::create(
      [
        "tema" => $request->get('tema'),
        "fecha" => $request->get('fecha'),
        "imparte_id" => $imparte->id
      ]
    );
    return back()->withErrors(["message-success" => "Asistencia creada correctamente"]);
  }

  public function update(Request $request, Asistencia $asistencia)
  {
    $asistencia->update($request->all());
    return back()->withErrors(["message-success" => "Asistencia actualizada correctamente"]);
  }

  public function destroy(Asistencia $asistencia)
  {
    $asistencia->delete();

    return back()->withErrors(["message-success" => "Asistencia eliminada correctamente"]);
  }
}

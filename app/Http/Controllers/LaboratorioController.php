<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Imparte;
use App\Models\Laboratorio;
use App\Models\Materia;
use App\Models\NotasLaboratorio;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
  public function index(Imparte $imparte)
  {
    // $imparte = Imparte::find($imparteId);
    $materia = Materia::find($imparte->Materia_id);
    $laboratorios = $imparte->laboratorios;

    return view('docente.laboratorios.index', compact('laboratorios', 'materia', 'imparte'));
  }

  public function store(Request $request)
  {
    if ($request->boolean('asistencia')) {
      Asistencia::create([
        "imparte_id" => $request->get('imparteId'),
        "tema" => $request->get("tema"),
        "fecha" => $request->get("fecha"),
      ]);
    }

    Laboratorio::create([
      "imparte_id" => $request->get('imparteId'),
      "tema" => $request->get("tema"),
      "fecha" => $request->get("fecha"),
      "ponderacion" => $request->get("ponderacion")
    ]);
    return back()->withErrors(["message-success" => "Se ha creado el laboratorio correctamente"]);
  }

  public function update(Request $request, Laboratorio $laboratorio)
  {
    foreach ($laboratorio->notas as $nota) {
      $nota->update([
        "nota" => $nota->nota / $laboratorio->ponderacion * intval($request->get('ponderacion'))
      ]);
    }

    $laboratorio->update(array_replace($request->all(), ["habilitado" => $request->boolean('habilitado')]));
    return back()->withErrors(["message-success" => "Laboratorio actualizado correctamente"]);
  }
}

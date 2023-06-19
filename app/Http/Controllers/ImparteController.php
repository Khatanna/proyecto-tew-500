<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Imparte;
use Illuminate\Http\Request;

class ImparteController extends Controller
{
  public function index(Request $request)
  {
    $semestre = array_filter($request->keys(), fn($k) => $k !== 'gestion');
    $gestion_selected = $request->get('gestion') ?? 2023;
    $checked = $request->all();

    $gestiones = Imparte::pluck('gestion')->unique();
    $docente = Docente::find(auth()->user()->id);
    $materias = $request->has('all') || count($semestre) === 0 ? $docente->get_materias_by_gestion($gestion_selected)->get() : $docente->get_materias_by_semestre_and_gestion($semestre, $gestion_selected)->get();

    return view('home', compact('materias', 'checked', 'gestion_selected', 'gestiones'));
  }

  public function update(Request $request)
  {
    // $year = Carbon::now()->year; TODO validar el año

    $imparte = Imparte::where([
      "docente_id" => $request->get('old_docente_id'),
      "materia_id" => $request->get('materia_id'),
      "gestion" => $request->get('old_gestion'),
      "periodo" => $request->get('old_periodo'),
      "turno" => $request->get('old_turno'),
    ])->first();

    $imparte->update([
      "docente_id" => $request->get('docente_id'),
      "gestion" => $request->get('gestion'),
      "periodo" => $request->get('periodo'),
      "turno" => $request->get('turno'),
      "primer_parcial" => $request->get('primer_parcial'),
      "segundo_parcial" => $request->get('segundo_parcial')
    ]);

    return back()->withErrors(['message-success' => 'Se reasigno la materia correctamente']);
  }

  public function store(Request $request)
  {
    Imparte::create($request->all());
    return back()->withErrors(['message-success' => 'Se creo la asignacion correctamente']);
  }
}

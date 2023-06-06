<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ImparteController extends Controller
{
  public function index(Request $request)
  {
    $semestre = array_filter($request->keys(), fn($k) => $k !== 'gestion');
    $gestion = $request->get('gestion') ?? 2020;
    $checked = $request->all();

    $docente = Docente::find(auth()->user()->id);
    $materias = $request->has('all') ? $docente->get_materias_by_gestion($gestion)->get() : $docente->get_materias_by_semestre_and_gestion($semestre, $gestion)->get();

    return view('home', compact('materias', 'checked', 'gestion'));
  }
}

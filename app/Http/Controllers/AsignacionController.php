<?php

namespace App\Http\Controllers;

use App\Models\Imparte;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
  public function update(Request $request)
  {
    $year = Carbon::now()->year;
    /*
    $request->validate([
      "gestion" => "gte:$year",
    ]);
*/
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
      "turno" => $request->get('turno')
    ]);

    return to_route('admin.dashboard.docentes.index')->withErrors(['message-success' => 'Se reasigno la materia correctamente']);
  }
}

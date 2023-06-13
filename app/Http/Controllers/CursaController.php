<?php

namespace App\Http\Controllers;

use App\Models\Cursa;
use App\Models\Imparte;
use Illuminate\Http\Request;

class CursaController extends Controller
{
  public function update(Request $request)
  {
    $cursa = Cursa::where([
      "estudiante_id" => $request->get('estudiante_id'),
      "imparte_id" => $request->get('old_imparte_id')
    ])->first();

    $cursa->update([
      "imparte_id" => $request->get('imparte_id')
    ]);

    return back()->withErrors(['message-success' => 'Se reasigno la materia correctamente']);
  }

  public function store(Request $request)
  {
    Cursa::create([
      "estudiante_id" => $request->get('estudiante_id'),
      "imparte_id" => $request->get('imparte_id')
    ]);

    return back()->withErrors(['message-success' => 'Se creo la asignacion correctamente']);
  }

  public function destroy($id)
  {
    Cursa::find($id)->delete();
    return back()->withErrors(["message-success" => "Se elimino la asignación"]);
  }
}

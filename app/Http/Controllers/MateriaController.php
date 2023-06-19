<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MateriaController extends Controller
{
  public function index()
  {
    $columns = Schema::getColumnListing('materia');
    $materias = Materia::paginate(13);
    $docentes = Docente::all();

    return view('admin.dashboard.materias.index', compact('columns', 'materias', 'docentes'));
  }

  public function store(Request $request)
  {
    Materia::create($request->all());
    return back()->withErrors(["message-success" => "Materia ha sido creada correctamente"]);
  }

  public function update(Request $request, Materia $materia)
  {
    $materia->update($request->all());
    return back()->withErrors(["message-success" => "Materia ha sido actualizada correctamente"]);
  }

  public function destroy(Materia $materia)
  {
    $materia->delete();
    return back()->withErrors(["message-success" => "Materia ha sido eliminada correctamente"]);
  }
}

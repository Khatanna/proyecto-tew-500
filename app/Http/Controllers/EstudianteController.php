<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Imparte;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class EstudianteController extends Controller
{
  public function index(Request $request)
  {
    $orderBy = $request->get('orderBy', 'id');
    $type = $request->get('type');
    $query = Estudiante::query();

    $type = $type === 'asc' ? 'desc' : 'asc';
    $estudiantes = $query->orderBy($orderBy, $type)->paginate(13);
    $matriculas = Estudiante::pluck('matricula');

    $columns = Schema::getColumnListing("estudiante");
    return view('admin.dashboard.estudiantes.index', compact('estudiantes', 'matriculas', 'columns', 'type'));
  }

  public function show($id)
  {
    $estudiante = Estudiante::find(base64_decode($id));
    $cursos = $estudiante->imparte;
    $asignaciones = Imparte::all();


    return view('admin.dashboard.estudiantes.show', compact('estudiante', 'cursos', 'asignaciones'));
  }

  public function update(Request $request)
  {
    $estudiante = Estudiante::where('ci', $request->get('old-ci'))->first();

    $estudiante_updated = $estudiante->update([
      "nombres" => $request->get("nombres"),
      "apellido_paterno" => $request->get("apellido_paterno"),
      "apellido_materno" => $request->get("apellido_materno"),
      "ci" => $request->get("ci"),
      "estado" => $request->get('estado')
    ]);

    if (isset($estudiante_updated)) {
      return to_route('admin.dashboard.estudiantes.index')->withErrors(["message-success" => "La información del estudiante se actualizo"]);
    }

    return to_route('admin.dashboard.estudiantes.index')->withErrors(["message-error" => "La información del estudiante no se actualizo"]);
  }

  public function store(Request $request)
  {
    return $request;
  }
}

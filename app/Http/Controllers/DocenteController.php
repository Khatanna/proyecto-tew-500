<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DocenteController extends Controller
{
  public function index(Request $request)
  {
    $orderBy = $request->get('orderBy', 'id');
    $type = $request->get('type');
    $codigo = $request->get('codigo');

    $type = $type === 'asc' ? 'desc' : 'asc';
    $query = Docente::query();
    if (isset($codigo)) {
      $query->where('codigo', 'like', '%' . $codigo . '%');
    }

    $docentes = $query->orderBy($orderBy, $type)->get();
    $docentes_codigos = Docente::pluck('codigo');
    $columns = array_filter(Schema::getColumnListing("docente"), fn($e) => $e !== 'id' && $e !== 'contraseña');

    return view('admin.dashboard.docentes.index', compact('docentes', 'columns', 'type', 'codigo', 'docentes_codigos'));
  }

  public function create()
  {
    return view('admin.dashboard.docentes.create');
  }

  public function store(Request $request)
  {
    try {
      $find = Docente::where('ci', $request->get('ci'))->count();

      if ($find > 0) {
        return to_route('admin.dashboard.docentes.index')->withErrors(["message-error" => "Este docente ya existe"]);
      }
      Docente::create([
        "nombres" => $request->get("nombres", ""),
        "apellido_paterno" => $request->get("apellido_paterno", ""),
        "apellido_materno" => $request->get("apellido_materno", ""),
        "ci" => $request->get("ci", "")
      ]);

      return to_route('admin.dashboard.docentes.index')->withErrors(["message-success" => "El docente se creo correctamente"]);
    } catch (\Illuminate\Database\QueryException $error) {
      return to_route('admin.dashboard.docentes.index')->withErrors(["message-error" => $error->getMessage()]);
    }
  }

  public function show($id)
  {
    $docente = Docente::find(base64_decode($id));
    $docentes = Docente::where('id', '!=', $docente->id)->get();

    return view('admin.dashboard.docentes.show', compact('docente', 'docentes'));
  }

  public function update(Request $request)
  {
    $docente = Docente::where('ci', $request->get('old-ci'))->first();

    $docente_updated = $docente->update([
      "nombres" => $request->get("nombres"),
      "apellido_paterno" => $request->get("apellido_paterno"),
      "apellido_materno" => $request->get("apellido_materno"),
      "codigo" => $request->get("codigo"),
      "estado" => $request->get('estado'),
      "ci" => $request->get("ci")
    ]);

    if (isset($docente_updated)) {
      return to_route('admin.dashboard.docentes.index')->withErrors(["message-success" => "El docente se actualizo"]);
    }

    return to_route('admin.dashboard.docentes.index')->withErrors(["message-error" => "El docente no se actualizo"]);
  }

  public function destroy(Request $request)
  {
    $docente = Docente::find($request->get('id'))->delete();

    return to_route('admin.dashboard.docentes.index')->withErrors(["message-success" => "El docente se elimino"]);
  }

}

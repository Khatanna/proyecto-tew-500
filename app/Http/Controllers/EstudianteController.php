<?php

namespace App\Http\Controllers;

use App\Imports\EstudiantesImport;
use App\Models\Estudiante;
use App\Models\Imparte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DB;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;

class EstudianteController extends Controller
{
  public function index(Request $request)
  {
    $orderBy = $request->get('orderBy', 'id');
    $type = $request->get('type');
    $query = Estudiante::query();
    $matricula = $request->get('matricula');

    if (isset($matricula)) {
      $query->where('matricula', 'like', '%' . $matricula . '%');
    }

    $type = $type === 'asc' ? 'desc' : 'asc';
    $estudiantes = $query->orderBy($orderBy, $type)->paginate(13);
    $matriculas = Estudiante::pluck('matricula');

    $columns = Schema::getColumnListing("estudiante");
    return view('admin.dashboard.estudiantes.index', compact('estudiantes', 'matriculas', 'matricula', 'columns', 'type'));
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
    try {
      $find = Estudiante::where('ci', $request->get('ci'))->count();

      if ($find > 0) {
        return to_route('admin.dashboard.estudiantes.index')->withErrors(["message-error" => "Este estudiante ya existe"]);
      }
      Estudiante::create([
        "nombres" => $request->get("nombres", ""),
        "apellido_paterno" => $request->get("apellido_paterno", ""),
        "apellido_materno" => $request->get("apellido_materno", ""),
        "ci" => $request->get("ci", "")
      ]);

      return to_route('admin.dashboard.estudiantes.index')->withErrors(["message-success" => "El estudiante se creo correctamente"]);
    } catch (\Illuminate\Database\QueryException $error) {
      return to_route('admin.dashboard.estudiantes.index')->withErrors(["message-error" => $error->getMessage()]);
    }
  }

  public function store_many(Request $request)
  {
    $request->validate([
      'file' => 'mimes:csv,xlsx',
    ],
      [
        'file.mimes' => 'El archivo debe tener una extensión CSV o XLSX.',
      ]);
    try {
      $file = $request->file('file');

      if ($file->extension() === "csv") {
        $file_path = $file->getPathname();

        $csv = Reader::createFromPath($file_path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        $data = [];

        foreach ($records as $record) {
          $estudiante = [
            "nombres" => $record['NOMBRES'],
            "apellido_paterno" => $record['APELLIDO PATERNO'],
            "apellido_materno" => $record["APELLIDO MATERNO"],
            "ci" => $record["CI"]
          ];

          $data[] = $estudiante;
        }

        DB::table('estudiante')->insert($data);
      } else {
        Excel::import(new EstudiantesImport, $file);
      }

      return back()->withErrors(["message-success" => "Estudiantes registrados correctamente"]);
    } catch (\Exception $e) {
      return back()->withErrors(["message-error" => "Ocurrio un error intentelo mas tarde"]);
    }
  }
}

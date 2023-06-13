<?php

namespace App\Http\Controllers;

use App\Exports\NotasExport;
use App\Models\Cursa;
use App\Models\Imparte;
use App\Models\NotasAsistencia;
use App\Models\NotasLaboratorio;
use http\Env\Request;
use View;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;

class NotasController extends Controller
{
  public function show(Imparte $imparte)
  {
    $estudiantes = $imparte->estudiantes;
    $laboratorios = $imparte->laboratorios->where('habilitado', '=', true);;
    $asistencias = $imparte->asistencias;

    return view("docente.notas.index", compact('estudiantes', 'laboratorios', 'asistencias', 'imparte'));
  }

  public function generate_excel($imparteId)
  {
    return Excel::download(new NotasExport($imparteId), 'notas.xlsx', \Maatwebsite\Excel\Excel::XLSX);
  }

  public function generate_pdf($imparteId)
  {
    $pdf = new TCPDF('L', 'in', [11, 17], true, 'UTF-8', false); // Crea una instancia de TCPDF

    $pdf->SetCreator('Your Name');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Ejemplo de TCPDF');
    $pdf->AddPage();

    $imparte = Imparte::find($imparteId);

    $estudiantes = $imparte->estudiantes;
    $laboratorios = $imparte->laboratorios;
    $asistencias = $imparte->asistencias;

    $view = View::make('docente.notas.index')->with(compact('estudiantes', 'laboratorios', 'asistencias', 'imparte'))->render();
    $pdf->writeHTML($view, true, true, true, true, 'center');

    $pdf->Output('ejemplo.pdf', 'I');
    return 1;
  }

  public function store(Request $request)
  {
    $items = $request->toArray();
    array_shift($items);
    foreach ($items as $key => $value) {
      $extract = explode('-', $key);
      if (isset($value) and $value !== '-') {
        if ($extract[0] === 'asistencia') {
          $cursaId = $extract[1];
          $asistenciaId = $extract[2];
          NotasAsistencia::updateOrCreate(
            [
              "asistencia_id" => $asistenciaId,
              "cursa_id" => $cursaId,
            ],
            [
              "asistencia" => $value,
            ]
          );
        } else if ($extract[0] === 'nota_primer_parcial') {
          Cursa::where("id", $extract[1])->update([
            "nota_primer_parcial" => $value
          ]);
        } else if ($extract[0] === 'nota_segundo_parcial') {
          Cursa::where("id", $extract[1])->update([
            "nota_segundo_parcial" => $value
          ]);
        } else if ($extract[0] === 'nota_evaluacion_final') {
          Cursa::where("id", $extract[1])->update([
            "nota_evaluacion_final" => $value
          ]);
        } else if ($extract[0] === 'laboratorio') {
          $cursaId = $extract[1];
          $laboratorioId = $extract[2];
          NotasLaboratorio::updateOrCreate(
            [
              "laboratorio_id" => $laboratorioId,
              "cursa_id" => $cursaId,
            ],
            [
              "nota" => $value
            ]
          );
        }
      }
    }
    return back();
  }
}

<?php

namespace App\Exports;

use App\Models\Imparte;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotasExport implements FromView, WithColumnWidths, ShouldAutoSize, WithStyles
{
  private $imparteId;
  private $laboratorios;
  private $asistencias;

  public function __construct($imparteId)
  {
    $this->imparteId = $imparteId;

    $imparte = Imparte::find($this->imparteId);
    $this->laboratorios = $imparte->laboratorios;
    $this->asistencias = $imparte->asistencias;
  }

  public function view(): View
  {
    $imparte = Imparte::find($this->imparteId);

    $estudiantes = $imparte->estudiantes;
    $laboratorios = $imparte->laboratorios;
    $asistencias = $imparte->asistencias;

    return view("docente.notas.index", compact('estudiantes', 'laboratorios', 'asistencias', 'imparte'));
  }

  public function columnWidths(): array
  {
    return [
      'A' => 5,
      'D' => 30,
      'E' => 15
    ];
  }

  public function styles(Worksheet $sheet): array
  {
    $styles = [
      'A' => ['alignment' => ['vertical' => 'center', 'horizontal' => 'center']],
    ];

    for ($i = 0; $i <= $this->asistencias->count(); $i++) {
      $char = chr(ord("F") + $i) . "2";
      $styles[$char] = ['alignment' => ['textRotation' => 90]];
    }

    $charx = chr(ord("F") + $this->asistencias->count() + 5);
    for ($i = 0; $i <= $this->laboratorios->count(); $i++) {
      $char = chr(ord($charx) + $i) . "2";
      $styles[$char] = ['alignment' => ['textRotation' => 90]];
    }

    return $styles;
  }
}

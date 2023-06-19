<?php

namespace App\Imports;

use App\Models\Estudiante;
use Maatwebsite\Excel\Concerns\ToModel;

class EstudiantesImport implements ToModel
{

  public function model(array $row)
  {
    if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
      return null;
    }
    
    return new Estudiante([
      'nombres' => $row[0],
      'apellido_paterno' => $row[1],
      'apellido_materno' => $row[2],
      'ci' => $row[3]
    ]);
  }
}

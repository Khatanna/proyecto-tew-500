<?php

namespace App\Imports;

use App\Models\Docente;
use Maatwebsite\Excel\Concerns\ToModel;

class DocentesImport implements ToModel
{
  public function model(array $row)
  {
    if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
      return null;
    }

    return new Docente([
      'nombres' => $row[0],
      'apellido_paterno' => $row[1],
      'apellido_materno' => $row[2],
      'ci' => $row[3]
    ]);
  }
}

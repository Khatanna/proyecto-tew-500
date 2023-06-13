<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Materia extends Model
{
  use HasFactory;

  protected $table = "materia";
  public $timestamps = false;
  protected $fillable = [
    "codigo",
    "nombre",
    "semestre"
  ];

  public function docentes()
  {
    return $this->belongsToMany(Docente::class, "imparte");
  }

  public function laboratorios($docenteId, $gestion, $periodo, $turno)
  {
    return $this->hasManyThrough(Laboratorio::class, Imparte::class)->where([
      "docente_id" => $docenteId,
      "gestion" => $gestion,
      "periodo" => $periodo,
      "turno" => $turno
    ]);
  }
}

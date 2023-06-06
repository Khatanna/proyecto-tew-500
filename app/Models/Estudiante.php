<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = "estudiante";

    public function imparte() {
      return $this->belongsToMany(Imparte::class, "Cursa");
    }

  public function asistencias(int $imparte_id, int $estudiante_id) {
    return $this->hasManyThrough(NotasAsistencia::class, Cursa::class)->where([
      ["imparte_id", "=", $imparte_id],
      ["estudiante_id", "=", $estudiante_id]
    ])->get();
  }
    public function laboratorios(int $imparte_id, int $estudiante_id) {
      return $this->hasManyThrough(NotasLaboratorio::class, Cursa::class)->where([
        ["imparte_id", "=", $imparte_id],
        ["estudiante_id", "=", $estudiante_id]
      ])->get();
    }
}

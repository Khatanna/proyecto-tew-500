<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
  use HasFactory;

  protected $table = "estudiante";
  public $timestamps = false;
  public $fillable = [
    'nombres',
    'apellido_paterno',
    'apellido_materno',
    'estado',
    'matricula',
    'ci'
  ];

  public function imparte()
  {
    return $this->belongsToMany(Imparte::class, "cursa")->withPivot('id');
  }

  public function asistencias(int $imparte_id)
  {
    return $this->hasManyThrough(NotasAsistencia::class, Cursa::class)->where([
      ["imparte_id", "=", $imparte_id]
    ])->get();
  }

  public function laboratorios(int $imparte_id)
  {
    return $this->hasManyThrough(NotasLaboratorio::class, Cursa::class)->where([
      ["imparte_id", "=", $imparte_id]
    ])->get();
  }
}

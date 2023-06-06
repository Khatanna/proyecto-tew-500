<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imparte extends Model
{
  protected $table = "imparte";
  protected $fillable = [
    'docente_id',
    'materia_id',
    'gestion',
    'periodo',
    'turno'
  ];
  public $timestamps = false;

  public function estudiantes()
  {
    return $this->belongsToMany(Estudiante::class, "Cursa");
  }

  public function asistencias()
  {
    return $this->hasMany(Asistencia::class);
  }

  public function laboratorios()
  {
    return $this->hasMany(Laboratorio::class);
  }
}

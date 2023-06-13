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
    'turno',
    'primer_parcial',
    'segundo_parcial'
  ];
  public $timestamps = false;

  public function estudiantes()
  {
    return $this->belongsToMany(Estudiante::class, "cursa")->withPivot('id', 'nota_primer_parcial', 'nota_segundo_parcial', 'promedio_general', 'nota_evaluacion_final', 'promedio_final', 'segundo_turno', 'estado');
  }

  public function asistencias()
  {
    return $this->hasMany(Asistencia::class);
  }

  public function laboratorios()
  {
    return $this->hasMany(Laboratorio::class);
  }

  public function materia()
  {
    return $this->belongsTo(Materia::class, "Materia_id", "id");
  }

  public function docente()
  {
    return $this->belongsTo(Docente::class, "Docente_id", "id");
  }
}

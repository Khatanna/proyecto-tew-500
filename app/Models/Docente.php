<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model implements Authenticatable
{
  use HasFactory;
  use AuthenticatableTrait;

  protected $table = "docente";
  public $timestamps = false;
  protected $primaryKey = 'id';
  protected $fillable = [
    'nombres',
    'apellido_paterno',
    'apellido_materno',
    'ci',
    'codigo',
    'estado',
    'contraseña'
  ];

  public function getAuthIdentifierName(): string
  {
    return 'codigo';
  }

  public function getAuthPassword(): string
  {
    return bcrypt($this->contraseña);
  }

  public function get_materias_by_semestre_and_gestion(array $semestres, int $gestion)
  {
    return $this->belongsToMany(Materia::class, "imparte")->whereIn("semestre", $semestres)->wherePivot("gestion", $gestion)->withPivot('gestion', 'periodo', 'turno')->orderByPivot("periodo");
  }

  public function get_materias_by_gestion(int $gestion)
  {
    return $this->belongsToMany(Materia::class, "imparte")->withPivot('gestion', 'periodo', 'turno')->wherePivot("gestion", $gestion)->orderByPivot("periodo");
  }

  public function materias()
  {
    return $this->belongsToMany(Materia::class, "imparte")->withPivot('gestion', 'periodo', 'turno')->withPivot('id');
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursa extends Model
{
  use HasFactory;

  protected $table = "cursa";
  public $fillable = [
    "imparte_id",
    "estudiante_id"
  ];

  public $timestamps = false;

  public function materias()
  {
    return $this->hasManyThrough(Materia::class, Imparte::class);
  }
}

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


  public function docentes()
  {
    return $this->belongsToMany(Docente::class, "Imparte");
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasAsistencia extends Model
{
  use HasFactory;

  protected $table = "notas_asistencia";
  public $timestamps = false;
  public $fillable = [
    "cursa_id",
    "asistencia_id",
    "asistencia"
  ];
}

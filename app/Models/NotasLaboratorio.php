<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasLaboratorio extends Model
{
  use HasFactory;

  protected $table = "notas_laboratorio";

  public $timestamps = false;
  public $fillable = [
    "nota",
    "cursa_id",
    "laboratorio_id"
  ];

  public function laboratorio()
  {
    return $this->belongsTo(Laboratorio::class, "Laboratorio_id", "id");
  }
}

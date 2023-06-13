<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
  use HasFactory;

  protected $table = "laboratorio";
  public $fillable = [
    'imparte_id',
    'fecha',
    'tema',
    'ponderacion',
    'habilitado'
  ];

  public $timestamps = false;

  public function notas()
  {
    return $this->hasMany(NotasLaboratorio::class);
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MateriaController extends Controller
{
  public function index()
  {
    $columns = Schema::getColumnListing('materia');

    $materias = Materia::paginate(15);
    return view('admin.dashboard.materias.index', compact('columns', 'materias'));
  }
}

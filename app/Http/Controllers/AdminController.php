<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index()
  {
    return view('admin.dashboard.index');
  }
}

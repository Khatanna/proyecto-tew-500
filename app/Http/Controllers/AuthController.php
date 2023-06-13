<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    if ($request->get('codigo') === 'ADMIN' and $request->get('password') === 'password') {
      return redirect()->route('admin.dashboard.docentes.index');
    }
    if (Docente::where([
        "codigo" => $request->get('codigo'),
        "contraseña" => $request->get('password')
      ])->first()?->estado === 'inactivo') {
      return back()->withErrors(["message-error" => "Comuniquese con el administrador para habilitar su inicio de sesion"]);
    }

    $credentials = $request->validate([
      'codigo' => ['uppercase:', 'required'],
      'password' => ['required']
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended()->with('status', 'Iniciaste sesión');
    }
    return redirect('login')->withErrors(["message-error" => "Error de sesión: revise sus credenciales"]);
  }

  public function logout(Request $request)
  {
    auth()->logout();
    $request->session()->regenerate();

    return redirect(RouteServiceProvider::HOME);
  }
}

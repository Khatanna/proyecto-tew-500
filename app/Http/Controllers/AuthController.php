<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'codigo' => ['uppercase:', 'required'],
      'password' => ['required']
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect()->intended()->with('status', 'Iniciaste sesión');
    }
    return redirect('login');
  }

  public function logout(Request $request)
  {
    auth()->logout();
    $request->session()->regenerate();

    return redirect(RouteServiceProvider::HOME);
  }
}

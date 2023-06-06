@extends('layouts.plantilla')

@section('title', 'Login')
@section('styles')
  <style>
    img {
      filter: drop-shadow(0px 10px 3px #14154d);
    }
  </style>
@endsection
@section('content')
  <div class="container">
    <div class="row justify-content-center align-items-center vh-100 ">
      <div class="col-md-8 shadow-lg p-4 rounded-2">
        <div class="row p-3">
          <div class="col-md-6 border-end border-warning">
            <img src="https://eispdm.com/public/imagenes/logo_eispdm.png" alt="" class="img-fluid">
          </div>
          <div class="col-md-6 d-flex justify-content-between flex-column">
            <h1 class="text-center mt-4">Inicio de sesión</h1>
            <form action="{{ route('auth.login') }}" method="post" class="row g-4">
              @csrf
              <label class="col-md-12">
                <input type="text" placeholder="Codigo" class="form-control" id="codigo" name="codigo" autocomplete="off" oninput="this.value = this.value.toUpperCase()">
              </label>
              <label class="col-md-12">
                <input type="password" placeholder="Contraseña" class="form-control" name="password" autocomplete="off" value="GMG12345678">
              </label>
              <div class="col-md-12">
                <a href="" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Registrarse</a>
              </div>
              <div class="col-md-12">
                <input type="submit" value="Iniciar sesión" class="btn btn-outline-warning w-100">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
@endsection

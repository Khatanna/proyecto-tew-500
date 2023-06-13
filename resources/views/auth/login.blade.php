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

    @error('message-error')
    <div class="alert alert-danger mt-2 position-absolute top-0 start-50 translate-middle-x" role="alert" id="alert">
      <strong>{{$message}}</strong>
      <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
    </div>
    @enderror
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
                <input type="password" placeholder="Contraseña" class="form-control" name="password" autocomplete="off" value="">
              </label>
              <div class="col-md-12">
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
  <script>
    const alert = document.getElementById("alert");

    if (alert !== null) {
      setTimeout(closeAlert, 3000);
    }

    function closeAlert() {
      const alertElement = document.getElementById("alert");

      for (let i = 1.0; i >= 0.0; i -= 0.1) {
        alertElement.style.opacity = i;
      }

      setTimeout(function () {
        alertElement.style.display = "none";
      }, 300);
    }

  </script>
@endsection

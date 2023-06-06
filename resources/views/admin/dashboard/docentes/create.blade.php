@extends('layouts.admin-panel')

@section('title', 'Panel de administración')
@section('styles')
  <style>

  </style>
@endsection
@section('content')
  <div class="row justify-content-center align-items-center vh-100">

    <div class="col-6">
      <h1>Registro de docente</h1>
      <form action="{{ route('admin.dashboard.docentes.store')}}" method="post" class="row g-3">
        @csrf
        <label for="nombres" class="col-md-6">
          <input type="text" placeholder="Nombres" class="form-control" name="nombres" id="nombres">
        </label>
        <label for="apellido_paterno" class="col-md-6">
          <input type="text" placeholder="Apellido paterno" class="form-control" name="apellido_paterno" id="apellido_paterno">
        </label>
        <label for="apellido_materno" class="col-md-6">
          <input type="text" placeholder="Apellido materno" class="form-control" name="apellido_materno" id="apellido_materno">
        </label>
        <label for="ci" class="col-md-6">
          <input type="text" placeholder="Número de carnet" class="form-control" name="ci" id="ci">
        </label>
        <div class="col-md-12">
          <input type="submit" value="Registrar docente" class="btn btn-outline-success float-end" role="button">
        </div>
      </form>
      @error('message-error')
      <div class="alert alert-danger mt-2" role="alert">
        ⚠ {{ $message }}
      </div>
      @enderror
    </div>
  </div>
@endsection
@section('scripts')

@endsection

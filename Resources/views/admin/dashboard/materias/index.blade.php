@extends('layouts.admin-panel')

@section('title', 'Panel de administración')
@section('styles')
  <style>
    #alert {
      transition: opacity 0.5s ease;
    }
  </style>
@endsection
@section('content')
  @error('message-error')
  <div class="alert alert-danger mt-2" role="alert" id="alert">
    <strong>{{$message}}</strong>
    <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
  </div>
  @enderror
  @error('message-success')
  <div class="alert alert-success mt-2" role="alert" id="alert">
    <strong>{{$message}}</strong>
    <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
  </div>
  @enderror
  <h1>Materias</h1>
  <table class="table table-hover table-light table-striped align-middle h-25" style="overflow: scroll">
    <thead>
    <tr>
      @foreach($columns as $column)
        <th>
          <a href="" class="nav-link dropdown-toggle">
            {{ ucfirst(join(' ', explode('_', $column))) }}
          </a>
        </th>
      @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($materias as $materia)
      <tr>
        <td>
          {{$materia->id}}
        </td>
        <td>
          {{ $materia->codigo }}
        </td>
        <td>{{$materia->nombre}}</td>
        <td>{{ucfirst($materia->semestre)}} semestre</td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="position-fixed bottom-0">
    {{$materias->links()}}
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

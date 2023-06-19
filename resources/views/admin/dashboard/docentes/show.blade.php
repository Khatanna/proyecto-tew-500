@extends('layouts.admin-panel')

@section('title', 'Panel de administración')
@section('styles')

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
  <a href="{{ url()->previous()}}" class="btn btn-sm btn-outline-danger mt-2">Volver</a>
  <h2>Docente: <strong>{{ $docente->nombres }} - ({{$docente->codigo }})</strong></h2>
  <table class="table table-striped align-middle">
    <thead>
    <tr>
      <th>
        Nro.
      </th>
      <th>Codigo de materia</th>
      <th>Nombre de materia</th>
      <th>Semestre</th>
      <th>Año</th>
      <th>P. academico</th>
      <th>Turno</th>
      <th>Operaciones</th>
    </tr>
    </thead>
    <tbody>
    @php
      $materias = $docente->materias()->paginate(12);
    @endphp

    @foreach($materias as $index => $materia)
      <tr>
        <td>{{$materia->pivot->id}}</td>
        <td>{{$materia->codigo}}</td>
        <td>{{$materia->nombre}}</td>
        <td>{{$materia->semestre}}</td>
        <td>{{$materia->pivot->gestion}}</td>
        <td>{{$materia->pivot->periodo}}</td>
        <td>{{$materia->pivot->turno}}</td>
        <td>
          <button class=" btn btn-sm btn-warning
        " data-bs-toggle="modal" data-bs-target="#modal{{$materia->pivot->id}}" type="button">
            Reasignar
          </button>

          <div class="modal fade" id="modal{{$materia->pivot->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Información de asignación</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('admin.dashboard.docentes.asignaciones.update')}}" method="post" class="row g-3" id="form-update">
                    @csrf
                    @method('put')
                    <label hidden>
                      <input type="hidden" name="old_gestion" value="{{$materia->pivot->gestion}}">
                      <input name="old_docente_id" value="{{$docente->id}}">
                      <input type="text" name="old_periodo" value="{{ $materia->pivot->periodo }}">
                      <input type="text" name="old_turno" value="{{ $materia->pivot->turno }}">
                    </label>
                    <label for="materia_id" class="col-md-12">
                      Materia:
                      <input type="hidden" name="materia_id" value="{{ $materia->id }}">
                      <input type="text" class="form-control" value="{{$materia->nombre}} ({{$materia->codigo}})" disabled>
                    </label>

                    <label for="docente_id" class="col-md-12">
                      Docente:
                      <select name="docente_id" id="docente_id" class="form-select" required>
                        <option value="" disabled selected>{{ $docente->nombres }}</option>
                        <option value="{{$docente->id}}" selected hidden>{{ $docente->nombres }}</option>
                        @foreach($docentes as $_docente)
                          <option value="{{$_docente->id}}">{{$_docente->nombres}}</option>
                        @endforeach
                      </select>
                    </label>
                    <label for="name" class="col-md-6">
                      Turno:
                      <select name="turno" id="" class="form-select">
                        <option value="" selected disabled>{{$materia->pivot->turno}}</option>
                        <option value="{{$materia->pivot->turno}}" selected hidden="">{{ $materia->pivot->turno }}</option>
                        <option value="mañana">mañana</option>
                        <option value="tarde">tarde</option>
                        <option value="noche">noche</option>
                      </select>
                    </label>

                    <label for="paralelo_id" class="col-md-6">
                      Paralelo:
                      <select name="paralelo" id="" class="form-select">
                        <option value="{{$materia->pivot->paralelo}}" selected disabled>{{$materia->pivot->paralelo}}</option>
                        <option value="{{$materia->pivot->paralelo}}" selected hidden="">{{ $materia->pivot->paralelo }}</option>
                        @foreach(array_filter(["A", "B", "C", "D"], fn($p) => $p !== $materia->pivot->paralelo) as $paralelo)
                          <option value="{{ $paralelo }}">{{$paralelo}}</option>
                        @endforeach
                      </select>
                    </label>
                    <fieldset class="col-md-6">
                      Periodo academico:
                      <div class="form-control d-flex justify-content-evenly">
                        <label for="I">
                          I:
                          <input type="radio" name="periodo" id="I" value="I" class="form-check-input" @if($materia->pivot->periodo === "I") checked @endif>
                        </label>
                        <label for="II">
                          II:
                          <input type="radio" name="periodo" id="II" value="II" class="form-check-input" @if($materia->pivot->periodo === "II") checked @endif>
                        </label>
                      </div>
                    </fieldset>
                    <label for="gestion_id" class="col-md-6">
                      Gestion:
                      <input type="number" min="2020" max="{{ \Carbon\Carbon::now()->year }}" step="1" value="{{ $materia->pivot->gestion }}" class="form-control" name="gestion">
                    </label>
                    <label for="primer_parcial_id" class="col-md-6">
                      Fecha primer parcial:
                      <input type="date" value="{{ $materia->pivot->primer_parcial }}" class="form-control" name="primer_parcial">
                    </label>
                    <label for="segundo_parcial_id" class="col-md-6">
                      Fecha segundo parcial:
                      <input type="date" value="{{ $materia->pivot->segundo_parcial }}" class="form-control" name="segundo_parcial">
                    </label>
                    <div class="col-md-12">
                      <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                      </button>
                      <button type="submit" class="btn btn-success float-end">Reasignar materia</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $materias->links() }}
@endsection
@section('scripts')
  <script>
    const alert = document.getElementById("alert");

    if (alert !== null) {
      setTimeout(closeAlert, 3000);
    }

    function reverseArray(array) {
      console.log(array.reverse());
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

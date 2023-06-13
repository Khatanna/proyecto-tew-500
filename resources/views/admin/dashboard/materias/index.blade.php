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
  <div class="row align-items-center">
    <div class="col-6">
      <h1>Materias</h1>
    </div>
    <div class="col-6 d-flex justify-content-end gap-2">
      <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalMateria" type="button">
        Crear Materia
      </button>

      <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAsignacion" type="button">
        Crear asignación
      </button>
    </div>
  </div>

  <div class="modal fade" id="modalMateria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="">Crear materia</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.dashboard.materias.store')}}" method="post" class="row g-3" id="form-update">
            @csrf
            <label for="nombre" class="col-md-12">
              Nombre de la Materia:
              <input type="text" class="form-control" name="nombre">
            </label>
            <label for="codigo" class="col-md-6">
              Codigo de materia:
              <input type="text" min="1" max="7" class="form-control" name="codigo">
            </label>
            <label for="semestr" class="col-md-6">
              Semestre:
              <select name="semestre" id="" class="form-select">
                <option value="" selected disabled>Semestre</option>
                <option value="primero">Primer semestre</option>
                <option value="segundo">Segundo semestre</option>
                <option value="tercero">Tercer semestre</option>
                <option value="cuarto">Cuarto semestre</option>
                <option value="quinto">Quinto semestre</option>
                <option value="sexto">Sexto semestre</option>
              </select>
            </label>
            <div class="col-md-12">
              <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
              </button>
              <button type="submit" class="btn btn-success float-end">Crear materia</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalAsignacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="">Información de asignacion</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.dashboard.docentes.asignaciones.store')}}" method="post" class="row g-3" id="form-update">
            @csrf
            <label for="materia_id" class="col-md-12">
              Materia:
              <select class="form-select" name="materia_id">
                <option value="" disabled selected>Materia</option>
                @foreach($materias as $materia)
                  <option value="{{$materia->id}}">{{$materia->nombre }} ({{$materia->codigo}})</option>
                @endforeach
              </select>
            </label>

            <label for="name" class="col-md-6">
              Turno:
              <select name="turno" id="" class="form-select">
                <option value="" selected disabled>Turno</option>
                <option value="mañana">mañana</option>
                <option value="tarde">tarde</option>
                <option value="noche">noche</option>
              </select>
            </label>

            <label for="docente_id" class="col-md-6">
              Docente:
              <select name="docente_id" id="docente_id" class="form-select" required>
                <option value="" disabled selected>Docente</option>
                @foreach($docentes as $docente)
                  <option value="{{$docente->id}}">{{$docente->nombres }} ({{$docente->codigo}})</option>
                @endforeach
              </select>
            </label>
            <fieldset class="col-md-6">
              Periodo academico:
              <div class="form-control d-flex justify-content-evenly">
                <label for="I">
                  I:
                  <input type="radio" name="periodo" id="I" value="I" class="form-check-input" checked>
                </label>
                <label for="II">
                  II:
                  <input type="radio" name="periodo" id="II" value="II" class="form-check-input">
                </label>
              </div>
            </fieldset>
            <label for="gestion_id" class="col-md-6">
              Gestion:
              <input type="number" min="2020" max="{{ \Carbon\Carbon::now()->year }}" step="1" value="" class="form-control" name="gestion" placeholder="{{\Carbon\Carbon::now()->year}}">
            </label>
            <div class="col-md-12">
              <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
              </button>
              <button type="submit" class="btn btn-success float-end">Asignar materia</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
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
      <th>Operaciones</th>
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
        <td>
          <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdate{{$materia->id}}" type="button">
            Modificar
          </button>

          <div class="modal fade" id="modalUpdate{{$materia->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="">Actualizar materia</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('admin.dashboard.materias.update', ["materia" => $materia])}}" method="post" class="row g-3" id="form-update">
                    @csrf
                    @method('put')
                    <label for="nombre" class="col-md-12">
                      Nombre de la Materia:
                      <input type="text" class="form-control" name="nombre" value="{{ $materia->nombre }}">
                    </label>
                    <label for="codigo" class="col-md-6">
                      Codigo de materia:
                      <input type="text" min="1" max="7" class="form-control" name="codigo" value="{{ $materia->codigo }}">
                    </label>
                    <label for="semestr" class="col-md-6">
                      Semestre:
                      <select name="semestre" id="" class="form-select">
                        <option value="" selected disabled>{{ $materia->semestre }}</option>
                        <option value="primero">Primer semestre</option>
                        <option value="segundo">Segundo semestre</option>
                        <option value="tercero">Tercer semestre</option>
                        <option value="cuarto">Cuarto semestre</option>
                        <option value="quinto">Quinto semestre</option>
                        <option value="sexto">Sexto semestre</option>
                      </select>
                    </label>
                    <div class="col-md-12">
                      <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                      </button>
                      <button type="submit" class="btn btn-success float-end">Actualizar materia</button>
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

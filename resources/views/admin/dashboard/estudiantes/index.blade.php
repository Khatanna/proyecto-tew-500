@extends('layouts.admin-panel')

@section('title', 'Panel de administración')
@section('styles')
  <style>
    #alert {
      transition: opacity 0.5s ease;
    }

    * {
      font-size: 0.9rem;
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
  @error('file')
  <div class="alert alert-danger mt-2" role="alert" id="alert">
    <strong>{{$message}}</strong>
    <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
  </div>
  @enderror
  <h1>Estudiantes</h1>

  <div class="col-12 my-3">
    <div class="row d-flex flex-row align-items-center">
      <form action="" class="col-md-10 d-flex align-items-center gap-2">
        <label for="" class="col-md-4">
          <input type="text" class="form-control" name="matricula" id="matricula" placeholder="Buscar estudiante por matricula" list="matriculas" autocomplete="off">
        </label>
        <label for="" class="col-md-auto">
          <input type="submit" value="Buscar estudiante" class=" w-100 btn btn-outline-success" id="input" autocomplete="off">
        </label>
        <datalist id="matriculas" style="color: red">
          @foreach($matriculas as $matricula)
            <option value="{{$matricula}}"></option>
          @endforeach
        </datalist>
      </form>
      <div class="col-md-2">
        <button class="btn btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#modalEstudiante" type="button">
          Registrar Estudiante
        </button>
        <div class="modal fade" id="modalEstudiante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de estudiante</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="{{ route('admin.dashboard.estudiantes.store')}}" method="post" class="row g-3">
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
                    <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                    </button>
                    <button type="submit" class="btn btn-success float-end">Registrar estudiante</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <table class="table table-hover table-light table-striped align-middle">
    <thead>
    <tr>
      <th>
        <a href="{{ route("admin.dashboard.estudiantes.index", ["orderBy" => "id", "type" => $type])}}" class="nav-link dropdown-toggle">
          Nro
        </a>
      </th>
      <th>
        <a href="{{ route("admin.dashboard.estudiantes.index", ["orderBy" => "nombres", "type" => $type])}}" class="nav-link dropdown-toggle">
          Nombres
        </a>
      </th>
      <th>
        <a href="{{ route("admin.dashboard.estudiantes.index", ["orderBy" => "apellido_paterno", "type" => $type])}}" class="nav-link dropdown-toggle">
          Apellido paterno
        </a>
      </th>
      <th>
        <a href="{{ route("admin.dashboard.estudiantes.index", ["orderBy" => "apellido_materno", "type" => $type])}}" class="nav-link dropdown-toggle">
          Apellido materno
        </a>
      </th>
      <th>
        <a href="{{ route("admin.dashboard.estudiantes.index", ["orderBy" => "ci", "type" => $type])}}" class="nav-link dropdown-toggle">
          C.I.
        </a>
      </th>
      <th>
        Correo institucional
      </th>
      <th>
        <a href="{{ route("admin.dashboard.estudiantes.index", ["orderBy" => "matricula", "type" => $type])}}" class="nav-link dropdown-toggle">
          Matricula
        </a>
      </th>
      <th>
        <a href="{{ route("admin.dashboard.estudiantes.index", ["orderBy" => "estado", "type" => $type])}}" class="nav-link dropdown-toggle">
          Estado
        </a>
      </th>
      <th>Operaciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($estudiantes as $index => $estudiante)
      <tr>
        @if($type === 'asc')
          <td>{{$index + 1}}</td>
        @else
          <td>{{$estudiantes->count() - $index}}</td>
        @endif
        <td onclick="window.location=''">
          {{ $estudiante->nombres }}</td>
        <td>{{ $estudiante->apellido_paterno }}</td>
        <td>{{ $estudiante->apellido_materno }}</td>
        <td>{{ $estudiante->ci }}</td>
        <td>{{ $estudiante->correo_institucional }}</td>
        <td @isset($codigo) style="color: slateblue; font-weight: bolder" @endisset>{{ $estudiante->matricula }}</td>
        <td>
          <small>
            <small><small>
                @if($estudiante->estado === "activo")
                  🟢
                @else
                  🔴
                @endif
              </small></small>
          </small>
          <small>
            {{ $estudiante->estado }}
          </small>
        </td>
        <td>
          <button class=" btn btn-sm btn-warning
        " data-bs-toggle="modal" data-bs-target="#modal{{$estudiante->id}}" type="button">
            Editar
          </button>

          <div class="modal fade" id="modal{{$estudiante->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Información de estudiante</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('admin.dashboard.estudiantes.update')}}" method="post" class="row g-3" id="form-update">
                    @csrf
                    @method('put')
                    <label for="nombres" class="col-md-6">
                      Nombres:
                      <input type="text" placeholder="Nombres" class="form-control" name="nombres" id="nombres" value="{{$estudiante->nombres}}">
                    </label>
                    <label for="apellido_paterno" class="col-md-6">
                      Apellido paterno:
                      <input type="text" placeholder="Apellido paterno" class="form-control" name="apellido_paterno" id="apellido_paterno" value="{{$estudiante->apellido_paterno}}">
                    </label>
                    <label for="apellido_materno" class="col-md-6">
                      Apellido materno:
                      <input type="text" placeholder="Apellido materno" class="form-control" name="apellido_materno" id="apellido_materno" value="{{ $estudiante->apellido_materno }}">
                    </label>
                    <label for="matricula" class="col-md-6">
                      Matricula:
                      <input type="text" placeholder="Matricula" class="form-control" name="matricula" id="matricula" value="{{$estudiante->matricula}}" readonly disabled>
                    </label>
                    <label for="old-ci" class="col-md-6 d-none">
                      <input type="text" placeholder="Número de carnet" class="form-control" name="old-ci" id="old-ci" value="{{$estudiante->ci}}" hidden="">
                    </label>
                    <label for="ci" class="col-md-6">
                      Carnet de identidad
                      <input type="text" placeholder="Número de carnet" class="form-control" name="ci" id="ci" value="{{$estudiante->ci}}">
                    </label>
                    <fieldset class="col-md-6">
                      Estado:
                      <div class="form-control d-flex justify-content-evenly">
                        <label for="activo">
                          Activo:
                          <input type="radio" name="estado" id="activo" value="activo" class="form-check-input" @if($estudiante->estado === "activo") checked @endif>
                        </label>
                        <label for="inactivo">
                          Inactivo:
                          <input type="radio" name="estado" id="inactivo" value="inactivo" class="form-check-input" @if($estudiante->estado === "inactivo") checked @endif>
                        </label>
                      </div>
                    </fieldset>
                    <div class="col-md-12">
                      <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                      </button>
                      <button type="submit" class="btn btn-success float-end">Actualizar información</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <a href="{{ route('admin.dashboard.estudiantes.show', ['id' => base64_encode($estudiante->id)]) }}" class="btn btn-sm btn-primary" role="button">Asignaciones</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="position-fixed bottom-0 ">
    {{ $estudiantes->links() }}
  </div>
  <div class="position-fixed bottom-0 end-0">
    <button class="btn btn-sm btn-success m-3" data-bs-toggle="modal" data-bs-target="#modalCrearMuchos" type="button">
      Añadir desde fichero
    </button>
  </div>
  <div class="modal fade" id="modalCrearMuchos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir registros</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.dashboard.estudiantes.store-many')}}" method="post" class="row g-3" enctype="multipart/form-data">
            @csrf
            <label for="file" class="col-md-12">
              Archivo:
              <input type="file" placeholder="archivo" class="form-control" name="file" id="file">

            </label>
            <div class="col-md-12">
              <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
              </button>
              <button type="submit" class="btn btn-success float-end">Enviar archivo</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @if($estudiantes->count() === 0)
    <div class="h-75 d-flex align-items-center justify-content-center flex-column">
      @isset($matricula)
        <h2 class="text-center">No hay estudiantes con la matricula ({{ $matricula }}) ahora mismo 😥</h2>
        <a href="{{ route('admin.dashboard.estudiantes.index') }}">Mostrar todos</a>
      @else
        <h1 class="text-center">No hay estudiantes ahora mismo 😥</h1>
      @endisset
    </div>
  @endif
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

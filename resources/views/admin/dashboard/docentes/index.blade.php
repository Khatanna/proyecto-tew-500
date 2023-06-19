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
  @if(session()->has('message-success'))
    <div class="alert alert-success mt-2" role="alert" id="alert">
      <strong>{{ session('message-success') }}</strong>
      <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
    </div>
  @endif
  @error('file')
  <div class="alert alert-danger mt-2" role="alert" id="alert">
    <strong>{{$message}}</strong>
    <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
  </div>
  @enderror
  <h1>Plantel docente</h1>

  <div class="col-12 my-3">
    <div class="row d-flex flex-row align-items-center">
      <form action="" class="col-md-10 d-flex align-items-center gap-2">
        <label for="" class="col-md-4">
          <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Buscar docente por (codigo de docente)" list="codigo-docentes" autocomplete="off">
        </label>
        <label for="" class="col-md-auto">
          <input type="submit" value="Buscar docente" class=" w-100 btn btn-outline-success" id="input" autocomplete="off">
        </label>
        <datalist id="codigo-docentes" style="color: red">
          @foreach($docentes_codigos as $codigo)
            <option value="{{$codigo}}"></option>
          @endforeach
        </datalist>
      </form>
      <div class="col-md-2">
        <button class=" btn btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#modalDocente" type="button">
          Registrar Docente
        </button>
        <div class="modal fade" id="modalDocente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Información de laboratorio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
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
                    <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                    </button>
                    <button type="submit" class="btn btn-success float-end">Registrar docente</button>
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
        <a href="{{ route("admin.dashboard.docentes.index", ["orderBy" => "id", "type" => $type]) }}" class="nav-link dropdown-toggle">Nro.
        </a></th>
      @foreach($columns as $column)
        <th>
          <a href="{{ route("admin.dashboard.docentes.index", ["orderBy" => $column, "type" => $type ])}}" class="nav-link dropdown-toggle">
            {{ ucfirst(join(' ', explode('_', $column))) }}
          </a>
        </th>
      @endforeach
      <th>Operaciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($docentes as $index => $docente)
      <tr>
        @if($type === 'asc')
          <td>{{$index + 1}}</td>
        @else
          <td>{{$docentes->count() - $index}}</td>
        @endif
        <td onclick="window.location=''">
          {{ $docente->nombres }}</td>
        <td>{{ $docente->apellido_paterno }}</td>
        <td>{{ $docente->apellido_materno }}</td>
        <td @isset($codigo) style="color: slateblue; font-weight: bolder" @endisset>{{ $docente->codigo }}</td>
        <td>{{ $docente->ci }}</td>
        <td>
          <small>
            <small><small>
                @if($docente->estado === "activo")
                  🟢
                @else
                  🔴
                @endif
              </small></small>
          </small>
          {{ $docente->estado }}
        </td>
        <td>
          <button class=" btn btn-sm btn-warning
        " data-bs-toggle="modal" data-bs-target="#modal{{$docente->id}}" type="button">
            Editar
          </button>

          <div class="modal fade" id="modal{{$docente->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Información de docente</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('admin.dashboard.docentes.update', ["docente" => $docente->id])}}" method="post" class="row g-3" id="form-update">
                    @csrf
                    @method('put')
                    <label for="nombres" class="col-md-6">
                      Nombres:
                      <input type="text" placeholder="Nombres" class="form-control" name="nombres" id="nombres" value="{{$docente->nombres}}">
                    </label>
                    <label for="apellido_paterno" class="col-md-6">
                      Apellido paterno:
                      <input type="text" placeholder="Apellido paterno" class="form-control" name="apellido_paterno" id="apellido_paterno" value="{{$docente->apellido_paterno}}">
                    </label>
                    <label for="apellido_materno" class="col-md-6">
                      Apellido materno:
                      <input type="text" placeholder="Apellido materno" class="form-control" name="apellido_materno" id="apellido_materno" value="{{ $docente->apellido_materno }}">
                    </label>
                    <label for="codigo" class="col-md-6">
                      Codigo de docente:
                      <input type="text" placeholder="Codigo" class="form-control" name="codigo" id="codigo" value="{{$docente->codigo}}" disabled>
                    </label>
                    <label for="old-ci" class="col-md-6 d-none">
                      <input type="text" placeholder="Número de carnet" class="form-control" name="old-ci" id="old-ci" value="{{$docente->ci}}" hidden="">
                    </label>
                    <label for="ci" class="col-md-6">
                      Carnet de identidad
                      <input type="text" placeholder="Número de carnet" class="form-control" name="ci" id="ci" value="{{$docente->ci}}">
                    </label>
                    <fieldset class="col-md-6">
                      Estado:
                      <div class="form-control d-flex justify-content-evenly">
                        <label for="activo">
                          Activo:
                          <input type="radio" name="estado" id="activo" value="activo" class="form-check-input" @if($docente->estado === "activo") checked @endif>
                        </label>
                        <label for="inactivo">
                          Inactivo:
                          <input type="radio" name="estado" id="inactivo" value="inactivo" class="form-check-input" @if($docente->estado === "inactivo") checked @endif>
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
          <a href="{{ route('admin.dashboard.docentes.show', ['id' => base64_encode($docente->id)]) }}" class="btn btn-sm btn-primary" role="button">Asignaciones</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="position-fixed bottom-0 ">
    {{ $docentes->links() }}
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
          <form action="{{ route('admin.dashboard.docentes.store-many')}}" method="post" class="row g-3" enctype="multipart/form-data">
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

  @if($docentes->count() === 0)
    <div class="h-75 d-flex align-items-center justify-content-center flex-column">
      @isset($codigo)
        <h2 class="text-center">No hay docentes con el codigo ({{ $codigo }}) ahora mismo 😥</h2>
        <a href="{{ route('admin.dashboard.docentes.index') }}">Mostrar todos</a>
      @else
        <h1 class="text-center">No hay docentes ahora mismo 😥</h1>
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

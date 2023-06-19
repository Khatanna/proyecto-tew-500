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
  <button class="btn btn-sm btn-outline-primary mt-2 float-end" data-bs-toggle="modal" data-bs-target="#modalAsignacion" type="button">
    Agregar asignación
  </button>


  <div class="modal fade" id="modalAsignacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Asignaciónes disponible</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @if($asignaciones->count() - $cursos->count() > 0)
            <div id="carouselAsignacion" class="carousel carousel-dark slide p-0">
              <div class="carousel-inner">
                @foreach($asignaciones->whereNotIn('id', $cursos->pluck('id')) as $index => $asignacion)
                  @php
                    $active = $loop->index === 0 ? 'active' : '';
                  @endphp
                  <div class="carousel-item {{ $active }}">
                    <div>
                      <small>
                        {{ $loop->index + 1 }} / {{ $asignaciones->count() - $cursos->count() }}
                      </small>
                    </div>
                    <form action="{{ route('admin.dashboard.estudiantes.asignaciones.store')}}" method="post" class="row g-3" id="form-update">
                      @csrf
                      <label hidden>
                        <input type="text" name="imparte_id" value="{{$asignacion->id}}">
                        <input type="text" name="estudiante_id" value="{{$estudiante->id}}">
                      </label>
                      <label for="" class="col-md-12">
                        Materia:
                        <input type="text" disabled value="{{ $asignacion->materia->nombre }} - {{ $asignacion->materia->codigo  }}" class="form-control">
                      </label>
                      <label for="" class="col-md-6">
                        Semestre:
                        <input type="text" disabled value="{{ $asignacion->materia->semestre  }}" class="form-control">
                      </label>
                      <label for="" class="col-md-6">
                        Gestion:
                        <input type="text" disabled value="{{ $asignacion->gestion  }}" class="form-control">
                      </label>
                      <label for="" class="col-md-6">
                        Periodo:
                        <input type="text" disabled value="{{ $asignacion->periodo  }}" class="form-control">
                      </label>
                      <label for="" class="col-md-6">
                        Turno:
                        <input type="text" disabled value="{{ $asignacion->turno  }}" class="form-control">
                      </label>
                      <div class="col-md-12 mt-3 z-2 position-relative">
                        <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-success float-end">Agregar asignación</button>
                      </div>
                    </form>
                  </div>
                @endforeach
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselAsignacion" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselAsignacion" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          @else
            <div class="bg-danger-subtle p-3 border rounded-1 text-body-secondary">Ya no hay mas materias para
              asignar😓
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>


  <h2><strong>{{ $estudiante->nombres }} {{$estudiante->apellido_paterno}} {{$estudiante->apellido_materno}} -
      ({{$estudiante->matricula}})</strong></h2>
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

    @foreach($cursos as $index => $curso)
      <tr>
        <td>{{ $curso->id }}</td>
        <td>{{ $curso->materia->codigo }}</td>
        <td>{{ $curso->materia->nombre }}</td>
        <td>{{ $curso->materia->semestre }}</td>
        <td>{{ $curso->gestion }}</td>
        <td>{{ $curso->periodo }}</td>
        <td>{{ $curso->turno }}</td>
        <td>
          <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modal{{$curso->id}}" type="button">
            Reasignar
          </button>

          <div class="modal fade" id="modal{{$curso->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Asignaciónes disponible</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div id="carousel{{$curso->id}}" class="carousel carousel-dark slide p-0">
                    <div class="carousel-inner">

                      @foreach($asignaciones->where('id', '!=', $curso->id) as $index => $asignacion)
                        @php
                          $active = $loop->index === 0 ? 'active' : '';
                        @endphp
                        <div class="carousel-item {{ $active }}">
                          <div>
                            <small>
                              {{ $loop->index + 1 }} / {{ $asignaciones->count() - 1 }}
                            </small>
                          </div>
                          <form action="{{ route('admin.dashboard.estudiantes.asignaciones.update')}}" method="post" class="row g-3" id="form-update">
                            @csrf
                            @method('put')
                            <label hidden>
                              <input type="text" name="old_imparte_id" value="{{ $curso->id }}">
                              <input type="text" name="imparte_id" value="{{$asignacion->id}}">
                              <input type="text" name="estudiante_id" value="{{$estudiante->id}}">
                            </label>
                            <label for="" class="col-md-12">
                              Materia:
                              <input type="text" disabled value="{{ $asignacion->materia->nombre }} - {{ $asignacion->materia->codigo  }}" class="form-control">
                            </label>
                            <label for="" class="col-md-6">
                              Semestre:
                              <input type="text" disabled value="{{ $asignacion->materia->semestre  }}" class="form-control">
                            </label>
                            <label for="" class="col-md-6">
                              Gestion:
                              <input type="text" disabled value="{{ $asignacion->gestion  }}" class="form-control">
                            </label>
                            <label for="" class="col-md-6">
                              Periodo:
                              <input type="text" disabled value="{{ $asignacion->periodo  }}" class="form-control">
                            </label>
                            <label for="" class="col-md-6">
                              Turno:
                              <input type="text" disabled value="{{ $asignacion->turno  }}" class="form-control">
                            </label>
                            <div class="col-md-12 mt-3 z-2 position-relative">
                              <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                              </button>
                              <button type="submit" class="btn btn-success float-end">Reasignar</button>
                            </div>
                          </form>
                        </div>
                      @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $curso->id }}" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $curso->id }}" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <form action="{{ route('admin.dashboard.estudiantes.asignaciones.delete', ["cursa_id" => $curso->pivot->id]) }}" method="post" class="d-inline-block">
            @csrf
            @method('delete')
            <button class="btn btn-sm btn-danger">Eliminar</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

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

@extends('layouts.plantilla')

@section('title', 'Laboratorios')
@section('styles')
  <style>

    * {
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid">
    @error('message-success')
    <div class="alert alert-success mt-2" role="alert" id="alert">
      <strong>{{$message}}</strong>
      <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
    </div>
    @enderror
    <div class="row justify-content-center vh-100 ">
      <div class="col-md-12 p-2">
        <div class="row my-2">
          <div class="col">
            <h1 class="text-center">{{$materia->nombre}}</h1>
            <h4 class="text-center">{{ $materia->codigo }}</h4>
            <div class="row">
              <div class="col">
                <a href="{{ route('home') }}" class="btn btn-sm btn-success">
                  Inicio
                </a>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalLaboratorio" type="button">
                  Crear laboratorio
                </button>
                <a href="{{ route('docente.estudiantes',  ["imparte" => $imparte->id])}}" class="btn btn-sm btn-outline-info float-end ">🗒
                  Ver Notas</a>
              </div>
            </div>

            <div class="modal fade" id="modalLaboratorio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Creación de laboratorio</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('docente.laboratorios.store')}}" method="post" class="row g-3 needs-validation" id="form-update" novalidate>
                      @csrf
                      <label hidden>
                        <input type="text" value="{{ $imparte->id }}" name="imparteId">
                      </label>
                      <label for="tema" class="col-md-12">
                        Tema:
                        <input type="text" placeholder="Tema" class="form-control" name="tema" id="tema" required>
                        <div class="invalid-feedback" style="font-size: 0.7rem">
                          El laboratorio debe tener un tema
                        </div>
                      </label>
                      <label for="fecha" class="col-md-6">
                        Fecha:
                        <input type="date" placeholder="Fecha" class="form-control" name="fecha" id="fecha" required>
                        <div class="invalid-feedback" style="font-size: 0.7rem">
                          El laboratorio requiere una fecha
                        </div>
                      </label>
                      <label for="ponderacion" class="col-md-6 ">
                        Ponderacion:
                        <div class="input-group">
                          <span class="input-group-text" id="basic-addon1">📝</span>
                          <input type="number" placeholder="Ponderación" class="form-control" name="ponderacion" id="ponderacion" value="" min="1" max="{{ 50 - $laboratorios->pluck('ponderacion')->sum() }}" required>
                          <div class="invalid-feedback" style="font-size: 0.7rem">
                            El rango permitido esta entre [1
                            - {{ 50 - $laboratorios->pluck('ponderacion')->sum() }}]
                          </div>
                        </div>
                      </label>
                      <label for="asistencia" class="col-md-6 d-flex align-items-center">
                        Incluir asistencia:
                        <input type="checkbox" class="form-check-input ms-2" name="asistencia" id="asistencia">
                      </label>
                      <!--
                        <label for="reajuste" class="col-md-6 d-flex align-items-center">
                          ¿Reajustar ponderacion?:
                          <input type="checkbox" class="form-check-input ms-2" name="reajuste" id="reajuste">
                        </label>
                       -->
                      <div class="col-md-12">
                        <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-success float-end">Crear laboratorio</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-bordered align-middle text-center">
          <thead>
          <tr>
            <th rowspan="2">#</th>
            <th rowspan="2">Tema de laboratorio</th>
            <th colspan="3">Fecha</th>
            <th rowspan="2">Ponderacion</th>
            <th rowspan="2">Habilitado</th>
            <th rowspan="2">Operaciones</th>
          </tr>
          <tr>
            <th>Dia</th>
            <th>Mes</th>
            <th>Año</th>
          </tr>
          </thead>
          <tbody>
          @foreach($laboratorios as $laboratorio)
            <tr>
              <td>{{ $laboratorio->id }}</td>
              <td @if(!$laboratorio->habilitado) style="text-decoration: line-through" @endif>
                {{ $laboratorio->tema }}
              </td>
              <td>{{\Carbon\Carbon::createFromFormat("Y-m-d", $laboratorio->fecha)->dayName}}</td>
              <td>{{\Carbon\Carbon::createFromFormat("Y-m-d", $laboratorio->fecha)->month}}</td>
              <td>{{\Carbon\Carbon::createFromFormat("Y-m-d", $laboratorio->fecha)->year}}</td>
              <td>{{ $laboratorio->ponderacion }}%</td>
              <td>{{ $laboratorio->habilitado ? 'si' : 'no' }}</td>
              <td>
                <button class=" btn btn-sm btn-warning
        " data-bs-toggle="modal" data-bs-target="#modal{{$laboratorio->id}}" type="button">
                  Modificar
                </button>

                <div class="modal fade" id="modal{{$laboratorio->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Información de laboratorio</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="{{ route('docente.laboratorios.update', ["laboratorio" => $laboratorio->id])}}" method="post" class="row g-3" id="form-update">
                          @csrf
                          @method('put')
                          <label for="" class="col-md-12">
                            Tema:
                            <input type="text" class="form-control" name="tema" id="tema" value="{{$laboratorio->tema}}">
                          </label>
                          <label for="" class="col-md-6">
                            Fecha:
                            <input type="date" class="form-control" name="fecha" id="fecha" value="{{$laboratorio->fecha}}">
                          </label>
                          <label for="" class="col-md-6 ">
                            Ponderacion:
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1">📝</span>
                              <input type="number" class="form-control" name="ponderacion" id="ponderacion" value="{{ $laboratorio->ponderacion }}">
                            </div>
                          </label>
                          <label for="" class="col-md-6 d-flex justify-content-start align-items-center">
                            Habilitar:
                            <input type="checkbox" class="form-check-input ms-2" name="habilitado" id="habilitado" @if($laboratorio->habilitado) checked @endif >
                          </label>
                          <div class="col-md-12">
                            <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Cancelar
                            </button>
                            <button type="submit" class="btn btn-success float-end">Actualizar laboratorio</button>
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

    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
  </script>
@endsection


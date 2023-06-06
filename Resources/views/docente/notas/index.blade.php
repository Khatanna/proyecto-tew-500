@extends('layouts.plantilla')

@section('title', 'Notas')
@section('styles')
  <style>
    img {
      filter: drop-shadow(0px 10px 3px #14154d);
    }

    * {
      font-size: 0.8rem;
    }
  </style>
@endsection
@section('content')
  <div class="container-fluid">
    <div class="row justify-content-center align-items-center vh-100 ">
      <div class="col-md-12 shadow-lg p-4 rounded-2">
        <table class="table table-bordered ">
          <thead>
          <tr>
            <th rowspan="5">N°</th>
            <th colspan="3" rowspan="5">Apellido y nombres</th>
            <th rowspan="5">C.I.</th>
          </tr>
          <tr>
            <th colspan="{{ $asistencias->count() + 1 }}">Asistencia</th>
            <th colspan="{{ $laboratorios->count() }}">Laboratorio</th>
          </tr>
          <tr>
            <th rowspan="">
              <div class="d-flex align-items-start justify-content-center py-2" style="writing-mode: vertical-rl; height: 180px">
                Tema
              </div>
            </th>

            @foreach($asistencias as $asistencia)
              <th>
                <div class="d-flex align-items-start justify-content-center py-2">
                  <small>
                    <small>
                      <div style="writing-mode: vertical-rl; height: 180px">
                        {{ $asistencia->tema }}
                        <br>
                        <small>
                          <b>
                            fecha: {{ $asistencia->fecha }}
                          </b>
                        </small>
                      </div>
                    </small>
                  </small>
                </div>
              </th>
            @endforeach
            @foreach($laboratorios as $laboratorio)
              <th>
                <div class="d-flex align-items-start justify-content-center py-2">
                  <small>
                    <small>
                      <div style="writing-mode: vertical-rl; height: 180px">
                        {{ $laboratorio->tema }}
                        <br>
                        <small>
                          <b>
                            fecha: {{ $laboratorio->fecha }}
                          </b>
                        </small>
                      </div>
                    </small>
                  </small>
                </div>
              </th>
            @endforeach
            <th>Evaluación parcial</th>
          </tr>

          <tr>
            <th>
              Mes
            </th>
            <th>
            </th>
            <th>
            </th>
            <th></th>
            <th></th>
            <th>1P</th>
          </tr>
          <tr>
            <th>
              Dia
            </th>
            <th>
            </th>
            <th>
            </th>
            <th></th>
            <th></th>
            <th>10%</th>
          </tr>
          </thead>
          <tbody>
          @foreach($estudiantes as $estudiante)
            <tr>
              <th scope="row">{{$estudiante->id}}</th>
              <td>{{ $estudiante->apellido_paterno }}</td>
              <td>{{ $estudiante->apellido_materno }}</td>
              <td>{{ $estudiante->nombres }}</td>
              <td>{{ $estudiante->ci }}</td>
              <td></td>
              @if($estudiante->asistencias($imparte_id, $estudiante->id)->count() > 0)
                @foreach($estudiante->asistencias($imparte_id, $estudiante->id) as $asistencia)
                  <td ondblclick="convertToTextbox(this)">{{ $asistencia->asistencia }}</td>
                @endforeach
              @else
                @for($i = 0; $i < $asistencias->count(); $i++)
                  <td></td>
                @endfor
              @endif
              @isset($estudiante->laboratorios($imparte_id, $estudiante->id)[0])
                @foreach($estudiante->laboratorios($imparte_id, $estudiante->id) as $laboratorio)
                  <td ondblclick="convertToTextbox(this)" class="laboratorio">{{ $laboratorio->nota }}</td>
                @endforeach
              @else
                @for($i = 0; $i < $laboratorios->count(); $i++)
                  <td ondblclick="convertToTextbox(this)" class="laboratorio_input laboratorio">0</td>
                @endfor
              @endisset
              <td class="primerParcial">0</td>
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
    function setParcial() {
      const laboratorios = Array.from(document.getElementsByClassName("laboratorio"));
      const parciales = Array.from(document.getElementsByClassName('primerParcial'));
      console.log(laboratorios);
      for (let i = 0; i < laboratorios.length; i++) {
        if (laboratorios[i].children.length === 1) {
          parciales[i].innerText = parseInt(laboratorios[i].children[0].value) * 0.10;
        } else {
          // parciales[i].innerText = parseInt(laboratorios[i].innerHTML) * 0.10;
        }
      }
    }

    setParcial();

    Array.from(document.getElementsByClassName("laboratorio_input")).forEach(e => {
      e.addEventListener('keyup', (e) => {

        setParcial()
      })
    })

    function convertToTextbox(cell) {
      // Obtener el valor actual de la celda
      var value = cell.innerText;

      // Crear un elemento de entrada de texto
      var input = document.createElement("input");
      input.type = "text";
      input.value = value;
      input.style = "width: 25px";

      // Reemplazar la celda con el cuadro de texto
      cell.innerHTML = "";
      cell.appendChild(input);

      // Enfocar el cuadro de texto
      input.focus();

      // Al hacer clic fuera del cuadro de texto, convertirlo nuevamente en una celda
      input.onblur = function () {
        cell.innerHTML = input.value;
      };
    }
  </script>
@endsection


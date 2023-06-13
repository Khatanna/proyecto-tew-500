@extends('layouts.plantilla')

@section('title', 'Notas')
@section('styles')
  <style>
    img {
      filter: drop-shadow(0px 10px 3px #14154d);
    }

    html {
      font-size: 0.8rem;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input {
      min-width: 25px;
      max-width: 50px;
      text-align: center;
    }

    input:active, input:focus-visible {
      outline: 1px solid green;
      border-radius: 0;
    }

    input[type="number"] {
      -moz-appearance: textfield;
    }

    * {
    }
  </style>
@endsection
@section('content')
  <form action="{{ route('docente.estudiantes.notas.store') }}" method="post">
    @csrf
    <div class="container-fluid" id="document">
      <div class="row mb-5">
        <div class="col-md-12 p-2">
          <table class="table table-sm table-bordered align-middle text-center" id="table">
            <thead>
            <tr>
              <th rowspan="4" class="align-middle">N°</th>
              <th colspan="3" rowspan="4" style="vertical-align: middle">Apellido y nombres</th>
              <th rowspan="4" class="align-middle">C.I.</th>
              <th colspan="{{ $asistencias->count() + 2 }}">Asistencia</th>
              <th rowspan="2" colspan="2">Evaluación parcial</th>
              <th rowspan="4" class="align-middle">25%</th>
              <th colspan="{{ $laboratorios->count() + 1 }}">Trabajos - Laboratorios</th>
              <th rowspan="4" class="align-middle">50%</th>
              <th rowspan="3">Promedio General</th>
              <th rowspan="3">Evaluacion Final</th>
              <th rowspan="3">Promedio Final</th>
              <th rowspan="3">2do. Turno</th>
              <th rowspan="4">Observaciones</th>
            </tr>
            <tr>
              <th class="align-middle">
                Tema
              </th>
              @php
                $height = $asistencias->pluck('tema')->max(fn ($item) => strlen($item)) * 7;
              @endphp
              @foreach($asistencias as $asistencia)
                <th class="position-relative" style="height: {{ $height }}px">
                  <div class="position-absolute top-50 start-50" style="transform: translate(-50%, -50%) rotate(-90deg); white-space: nowrap;">
                    {{ $asistencia->tema }}
                  </div>
                </th>
              @endforeach
              <th rowspan="3" class="align-middle">5%</th>
              <th class="align-middle">
                Tema
              </th>
              @foreach($laboratorios as $laboratorio)
                <th class="position-relative" style="height: {{ $height }}px">
                  <div class="position-absolute top-50 start-50" style="transform: translate(-50%, -50%) rotate(-90deg); white-space: nowrap;">
                    {{ $laboratorio->tema }}
                  </div>
                </th>
              @endforeach
            </tr>
            <tr>
              <th>Mes</th>
              @foreach($asistencias as $asistencia)
                <th>
                  {{\Carbon\Carbon::createFromFormat("Y-m-d", $asistencia->fecha)->monthName}}
                </th>
              @endforeach
              <th>1P</th>
              <th>2P</th>
              <th>N°</th>
              @foreach($laboratorios as $index => $laboratorio)
                <th>
                  {{$index+ 1}}
                </th>
              @endforeach
            </tr>
            <tr>
              <th>Dia</th>
              @foreach($asistencias as $asistencia)
                @php
                  $fechaAsistencia = \Carbon\Carbon::createFromFormat('Y-m-d', $asistencia->fecha ?? 0);
                  $fechaPrimerParcial = \Carbon\Carbon::createFromFormat('Y-m-d', $imparte->primer_parcial ?? date('y-m-d'));
                  $fechaSegundoParcial = \Carbon\Carbon::createFromFormat('Y-m-d', $imparte->segundo_parcial ?? date('y-m-d'));
                @endphp

                <th class="@if ($fechaAsistencia < $fechaPrimerParcial)
                  bg-success-subtle
                @elseif ($fechaAsistencia > $fechaPrimerParcial && $fechaAsistencia < $fechaSegundoParcial)
                  bg-warning-subtle
                @else
                  bg-primary-subtle
                @endif
                ">{{\Carbon\Carbon::createFromFormat("Y-m-d", $asistencia->fecha)->day}}</th>
              @endforeach
              <th>10%</th>
              <th>15%</th>
              <th>%</th>
              @foreach($laboratorios as $laboratorio)
                @php
                  $fechaLaboratorio = \Carbon\Carbon::createFromFormat('Y-m-d', $laboratorio->fecha);
                  $fechaPrimerParcial = \Carbon\Carbon::createFromFormat('Y-m-d', $imparte->primer_parcial ?? date('y-m-d'));
                  $fechaSegundoParcial = \Carbon\Carbon::createFromFormat('Y-m-d', $imparte->segundo_parcial ?? date('y-m-d'));
                @endphp

                <th class="@if ($fechaLaboratorio < $fechaPrimerParcial)
                  bg-success-subtle
                @elseif ($fechaLaboratorio > $fechaPrimerParcial && $fechaLaboratorio < $fechaSegundoParcial)
                  bg-warning-subtle
                @else
                  bg-primary-subtle
                @endif
                "
                >
                  {{ $laboratorio->ponderacion }}%
                </th>
              @endforeach
              <th>80%</th>
              <th>20%</th>
              <th>100%</th>
              <th>61%</th>
            </tr>
            </thead>
            <tbody>
            @foreach($estudiantes as $index => $estudiante)
              <tr>
                <td>{{$index + 1}}</td>
                <td class="text-start">{{ $estudiante->apellido_paterno }}</td>
                <td class="text-start">{{ $estudiante->apellido_materno }}</td>
                <td class="text-start" style="white-space: nowrap">{{ $estudiante->nombres }}</td>
                <td class="text-start" style="white-space: nowrap;">{{ $estudiante->ci }}</td>
                <td></td>
                @for($i = 0; $i < $asistencias->count(); $i++)
                  @php
                    $asistencia = $estudiante->asistencias($imparte->id)->get($i)
                  @endphp
                  <td class="p-0">
                    <label>
                      <input
                        class="border-0 p-0 form-control-sm"
                        type="text"
                        readonly
                        name="asistencia-{{$estudiante->pivot->id}}-{{$asistencias->get($i)->id}}"
                        value="{{$asistencia->asistencia ?? '-' }}"
                        ondblclick="readonly(this)"
                        onfocusout="focusOut(this)"
                        oninput="this.value = this.value === 'a' || this.value === 'f' || this.value === 'p' ? this.value.toUpperCase() : '-'">
                    </label>
                    <div style="display: none">
                      {{ $asistencia->asistencia ?? '-' }}
                    </div>
                  </td>
                @endfor
                <td class="p-0" style="white-space: nowrap">
                  @php
                    $nota_asistencia = $estudiante->asistencias($imparte->id, $estudiante->id)->count() > 0 ?  $estudiante->asistencias($imparte->id, $estudiante->id)->reduce(function ($acc, $item) {
                        if($item->asistencia === "A") {
                          $acc += 100;
                        } else if($item->asistencia === "P") {
                          $acc += 50;
                        }
                        return $acc;
                      },0) / $asistencias->count() * 0.05 : 0;
                  @endphp
                  {{ floor($nota_asistencia)}}
                </td>
                <td class="p-0">
                  <label for="">
                    <input
                      class="border-0 p-0 form-control-sm"
                      type="number"
                      id="{{ $estudiante->id }}"
                      ondblclick="readonly(this)"
                      onfocusout="focusOut(this)"
                      name="nota_primer_parcial-{{$estudiante->pivot->id}}"
                      value="{{$estudiante->pivot->nota_primer_parcial }}">
                  </label>
                  <div class="d-none">
                    {{ $estudiante->pivot->nota_primer_parcial }}
                  </div>
                </td>
                <td class="p-0">
                  <label for="">
                    <input
                      class="border-0 p-0 form-control-sm"
                      type="number"
                      name="nota_segundo_parcial-{{$estudiante->pivot->id}}"
                      ondblclick="readonly(this)"
                      onfocusout="focusOut(this)"
                      value="{{ $estudiante->pivot->nota_segundo_parcial }}">
                  </label>
                </td>
                <td class="p-0">{{ ($estudiante->pivot->nota_primer_parcial) + ($estudiante->pivot->nota_segundo_parcial ) }}</td>
                <td></td>
                @for($i = 0; $i < $laboratorios->count(); $i++)
                  @php
                    $laboratorio = $laboratorios->get($i);
                  @endphp
                  <td class="p-0">
                    <label>
                      <input
                        class="border-0 p-0 form-control-sm"
                        type="number"
                        readonly
                        name="laboratorio-{{ $estudiante->pivot->id }}-{{ $laboratorios->get($i)->id }}"
                        value="{{$estudiante->laboratorios($imparte->id)->get($i)->nota ?? 0}}" ondblclick="this.readOnly = false" onfocusout="x(this, {{$laboratorio->ponderacion ?? 0}})"
                      >
                    </label>
                    <div style="display: none">
                      {{ $estudiante->laboratorios($imparte->id)->get($i)->nota ?? 0 }}
                    </div>
                  </td>
                @endfor
                <td>
                  {{ $estudiante->laboratorios($imparte->id)->filter(fn ($l) => $l->laboratorio->habilitado)->pluck('nota')->sum() }}
                </td>
                <td>{{ $estudiante->pivot->promedio_general }}</td>
                <td>
                  <label for="">
                    <input
                      class="border-0 p-0 form-control-sm"
                      type="number"
                      name="nota_evaluacion_final-{{$estudiante->pivot->id}}"
                      ondblclick="readonly(this)"
                      onfocusout="focusOut(this)"
                      value="{{ $estudiante->pivot->nota_evaluacion_final }}">
                  </label>

                  <div style="display: none">
                    {{ $estudiante->pivot->nota_evaluacion_final }}
                  </div>
                </td>
                <td>{{$estudiante->pivot->promedio_final}}</td>
                <td>{{ $estudiante->pivot->segundo_turno }}</td>
                @php
                  $estado = $estudiante->pivot->estado === "aprobado" ? 'success' : ($estudiante->pivot->estado === "reprobado" ? 'danger' : 'dark');
                @endphp
                <td class="bg-{{$estado}}-subtle">{{ $estudiante->pivot->estado }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="position-fixed bottom-0 start-0 m-3">
      <a class="btn btn-secondary" href="{{ route('home') }}">Inicio</a>
      <a class="btn btn-success" href="{{ route('docente.laboratorios.index',["imparte" => $imparte->id] ) }}">Volver</a>
    </div>
    <div class="position-fixed bottom-0 end-0 m-3">
      <button class="btn btn-primary">Guardar cambios</button>
      <a class="btn btn-success" href="{{ route('docente.estudiantes.excel', ["imparte" => $imparte->id]) }}">Exportar
        a excel</a>
      <a class="btn btn-danger" onclick="pdf()" target="_blank">Exportar
        a PDF</a>
    </div>
  </form>
@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <script>
    function readonly(input) {
      input.readOnly = false
    }

    function focusOut(input) {
      input.readOnly = true
    }

    function pdf() {
      const {jsPDF} = window.jspdf;
      const body = document.getElementById('document');

      window.html2canvas(body)
        .then(canvas => {

          const imgData = canvas.toDataURL('image/png');
          const pdf = new jsPDF('l', 'mm', 'a4');

          console.log(pdf.internal.pageSize.getWidth())
          console.log(pdf.internal.pageSize.getWidth() * 1.3)
          const imgProps = pdf.getImageProperties(imgData);
          const pdfWidth = pdf.internal.pageSize.getWidth();
          const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

          pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
          pdf.save('Notas.pdf');
        })
    }
  </script>
@endsection


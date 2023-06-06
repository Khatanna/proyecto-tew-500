@extends('layouts.plantilla')

@section('title', 'Home')

@section('styles')
  <style>

  </style>
@endsection

@section('content')
  @if(session('status'))
    <div class="toast show position-absolute top-0 start-50 mt-5 translate-middle-x z-3" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <img src="https://eispdm.com/public/imagenes/logo_eispdm.png" class="rounded mr-2" alt="..." width="25">
        <strong class="me-auto">EISPDM</strong>

        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ session('status') }}
      </div>
    </div>
  @endif
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 vh-100 border-end">
        <h1 class="text-center">Semestres</h1>
        <form action="{{ route('home') }}" class="row g-3" method="get">
          @foreach(['Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto'] as $semestre)
            <label for="{{ $semestre }}" class="form-check-label">
              <input type="checkbox" name="{{ $semestre }}" id="{{ $semestre }}" class="semestre-check form-check-input" @foreach($checked as $key => $value)
                @if($key === $semestre and $value === 'on')
                  checked
                @endif
                @endforeach>
              {{ $semestre }} semestre
            </label>
          @endforeach
          <label for="all" class="form-check-label">
            <input type="checkbox" name="all" id="all" class="form-check-input"
                   @isset($checked['all'])
                     checked
              @endisset>
            Todos
          </label>
          <label for="gestion">
            Gestion
            <select name="gestion" id="gestion" onchange="this.form.submit()" class="form-select">
              @isset($gestion)
                <option value="2020" @if($gestion === "2020") selected @endif>2020</option>
                <option value="2021" @if($gestion === "2021") selected @endif>2021</option>
                <option value="2022" @if($gestion === "2022") selected @endif>2022</option>
                <option value="2023" @if($gestion === "2023") selected @endif>2023</option>
              @endisset
            </select>
          </label>
          <input type="submit" value="Filtrar" class="btn btn-sm btn-outline-secondary">
        </form>
      </div>
      <div class="col-md-10 vh-100">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
          <div class="container-fluid">
            <div class="navbar-brand d-flex align-items-center gap-2" href="#">
              <div>
                <x-avatar :name="auth()->user()->nombres"/>
              </div>
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ auth()->user()->nombres }}
                  </a>
                  <ul class="dropdown-menu">
                    <li>
                      <form action="{{ route('auth.logout') }}" method="post">
                        @csrf
                        <input type="submit" value="Cerrar sesión" role="button" class="dropdown-item">
                      </form>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">

              </ul>
              <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar estudiante" aria-label="Search">
                <button class="btn btn-success" type="submit">Buscar</button>
              </form>
            </div>
          </div>
        </nav>
        <h1 class="text-center">Materias</h1>
        <div class="row mx-2">
          @foreach($materias->filter(fn($m) => $m->pivot->periodo == "I") as $materia)
              <div class="col-md-3 border rounded-2 p-3 d-flex flex-column justify-content-between me-2">
                <div class="row">
                  <div class="fs-3">
                    {{ $materia->codigo }}
                  </div>
                  <div>
                    {{ $materia->nombre }}
                  </div>
                  <div>
                    <b>{{ $materia->pivot->periodo }}</b> / {{ $materia->pivot->gestion }}
                  </div>
                  <div>
                    <small>
                      turno: {{ $materia->pivot->turno }}
                      @if($materia->pivot->turno === "noche")
                        🌚
                      @elseif($materia->pivot->turno === "tarde")
                        🌤
                      @else
                        🌞
                      @endif
                    </small>
                  </div>
                </div>
                <div class="mt-4">
                  <a href="{{ route('docente.estudiantes', ["codigo" => $materia->codigo,"periodo" => $materia->pivot->periodo,"gestion" => $materia->pivot->gestion, "turno" => $materia->pivot->turno])}}" class="btn btn-outline-warning">🗒 Ver Notas</a>
                </div>
              </div>
          @endforeach
        </div>
        <hr>
        <div class="row mx-2">
          @foreach($materias->filter(fn($m) => $m->pivot->periodo == "II") as $materia)
            <div class="col-md-3 border rounded-2 p-3 d-flex flex-column justify-content-between me-2">
              <div class="row">
                <div class="fs-3">
                  {{ $materia->codigo }}
                </div>
                <div>
                  {{ $materia->nombre }}
                </div>
                <div>
                  <b>{{ $materia->pivot->periodo }}</b> / {{ $materia->pivot->gestion }}
                </div>
                <div>
                  <small>
                    turno: {{ $materia->pivot->turno }}
                    @if($materia->pivot->turno === "noche")
                      🌚
                    @elseif($materia->pivot->turno === "tarde")
                      🌤
                    @else
                      🌞
                    @endif
                  </small>
                </div>
              </div>
              <div class="mt-4">
                <a href="{{ route('docente.estudiantes', ["codigo" => $materia->codigo,"periodo" => $materia->pivot->periodo,"gestion" => $materia->pivot->gestion, "turno" => $materia->pivot->turno])}}" class="btn btn-outline-warning">🗒 Ver Notas</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    const checkboxes = Array.from(document.getElementsByClassName('semestre-check'));
    const all = document.getElementById('all');

    all.addEventListener('click', (e) => {
      checkboxes.forEach(checkbox => checkbox.checked = false)
    })

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('click', () => {
        all.checked = false;
      })
    })
  </script>
@endsection

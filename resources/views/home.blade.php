@extends('layouts.plantilla')

@section('title', 'Home')

@section('styles')
  <style>
    .input-wrapper {
      position: relative;
    }

    #passwordInput {
      padding-right: 30px; /* Espacio para el icono dentro del campo de entrada */
    }

    #eyeIcon {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }

  </style>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
              @foreach($gestiones as $gestion)
                <option value="{{$gestion}}" @if($gestion === $gestion_selected) selected @endif>{{ $gestion }}</option>
              @endforeach
            </select>
          </label>
          <input type="submit" value="Filtrar" class="btn btn-sm btn-outline-secondary">
        </form>
      </div>
      <div class="col-md-10">
        @if(session('message-success'))
          <div class="alert alert-success mt-2" role="alert" id="alert">
            <strong>{{session('message-success')}}</strong>
            <span class="alert-close float-end btn-close" onclick="closeAlert()"></span>
          </div>
        @endif
        <div class="row justify-content-center gap-2 v-100">
          <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
              <div class="navbar-brand d-flex align-items-center gap-2 me-auto" href="#">
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
              <button class="fs-3 btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalAjustes" type="button">
                ⚙ Ajustes
              </button>

              <div class="modal fade" id="modalAjustes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Información y datos</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('docente.perfil.update', ["docente" => auth()->user()->id])}}" method="post" class="row g-3">
                        @csrf
                        @method('put')
                        <label for="" class="col-md-6">
                          Codigo de docente:
                          <input type="text" class="form-control" value="{{ auth()->user()->codigo }}" readonly disabled>
                        </label>
                        <label for="contraseña" class="col-md-6">
                          Contraseña

                          <div class="input-wrapper">
                            <input type="password" placeholder="contraseña" class="form-control" name="contraseña" id="contraseña" value="{{ auth()->user()->contraseña }}">
                            <i id="eyeIcon" class="far fa-eye" onclick="togglePasswordVisibility()"></i>
                          </div>
                        </label>
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
            </div>
          </nav>
          <div class="row">
            @foreach($materias->filter(fn($m) => $m->pivot->periodo == "I") as $materia)
              <div class="col-md-4 pe-3">
                <div class="row border rounded-2 p-2">
                  <div class="fs-3">
                    {{ $materia->codigo }}
                  </div>
                  <div>
                    {{ $materia->nombre }}
                  </div>
                  <div>
                    Gestion: <b>{{ $materia->pivot->periodo }}</b> / {{ $materia->pivot->gestion }}
                  </div>
                  <div>
                    <small>
                      Turno: {{ $materia->pivot->turno }}
                      @if($materia->pivot->turno === "noche")
                        🌚
                      @elseif($materia->pivot->turno === "tarde")
                        🌤
                      @else
                        🌞
                      @endif
                    </small>
                  </div>
                  <div class="mt-4">
                    <a href="{{ route('docente.estudiantes', ["imparte" => $materia->pivot->id])}}" class="btn btn-outline-warning w-100">🗒
                      Ver Notas</a>
                    <div class="d-flex gap-2">
                      <a href="{{ route('docente.laboratorios.index', ["imparte" => $materia->pivot->id]) }}" class="btn btn-outline-primary w-50 mt-2">🔬
                        Laboratorios</a>
                      <a href="{{ route('docente.asistencias.index', ["imparte" => $materia->pivot->id]) }}" class="btn btn-outline-success  w-50 mt-2">🙋‍♀️🙋‍♂️
                        Asistencias</a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <div class="row">
            @foreach($materias->filter(fn($m) => $m->pivot->periodo == "II") as $materia)
              <div class="col-md-4 pe-3">
                <div class="row border rounded-2 p-2">
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
                  <div class="mt-4">
                    <a href="{{ route('docente.estudiantes',  ["imparte" => $materia->pivot->id])}}" class="btn btn-outline-warning w-100">🗒
                      Ver Notas</a>
                    <div class="d-flex gap-2">
                      <a href="{{ route('docente.laboratorios.index', ["imparte" => $materia->pivot->id]) }}" class="btn btn-outline-primary w-50 mt-2">🔬
                        Laboratorios</a>
                      <a href="{{ route('docente.asistencias.index', ["imparte" => $materia->pivot->id]) }}" class="btn btn-outline-success  w-50 mt-2">🙋‍♀️🙋‍♂️
                        Asistencias</a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
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

    function togglePasswordVisibility() {
      const passwordInput = document.getElementById("contraseña");
      const eyeIcon = document.getElementById("eyeIcon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      }
    }

  </script>
@endsection

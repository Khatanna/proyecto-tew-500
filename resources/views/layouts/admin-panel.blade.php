<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>@yield('title')</title>

  <!-- Styles -->
  @vite(['resources/js/app.js', 'resources/css/app.scss'])

  @yield('styles')
  <style>
    #plantel-list {
      display: none;
    }

    #plantel:hover, #plantel-list > li:hover {
      background-color: #2d3748;
    }

    #plantel:hover + #plantel-list,
    #plantel-list:hover {
      display: block;
    }
  </style>
</head>

<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-2 bg-dark vh-100 text-white shadow-lg">
      <h1 class="text-center">E.I.S.P.D.M</h1>
      <div class="row mt-3">
        <div class="col-12">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle rounded rounded-1 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="plantel">
                Plantel Docente
              </a>
              <ul class="list-unstyled" id="plantel-list">
                <li class="plantel-item ms-3 px-2">
                  <a class="dropdown-item" href="{{ route('admin.dashboard.docentes.index') }}">Ver todos</a>
                </li>
                <li class="plantel-item ms-3 px-2">
                  <a class="dropdown-item" href="{{ route('admin.dashboard.docentes.create') }}">Registrar</a>
                </li>
                <li class="plantel-item ms-3 px-2">

                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle rounded rounded-1 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="plantel">
                Materias
              </a>
              <ul class="list-unstyled" id="plantel-list">
                <li class="plantel-item ms-3 px-2">
                  <a class="dropdown-item" href="{{ route('admin.dashboard.materias.index') }}">Ver todas</a>
                </li>
                <li class="plantel-item ms-3 px-2">
                  <a class="dropdown-item" href="{{ route('admin.dashboard.docentes.create') }}">Registrar</a>
                </li>
                <li class="plantel-item ms-3 px-2">
                  <a class="dropdown-item" href="{{ route('admin.dashboard.docentes.create') }}">Crear asignacion</a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle rounded rounded-1 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="plantel">
                Estudiantes
              </a>
              <ul class="list-unstyled" id="plantel-list">
                <li class="plantel-item ms-3 px-2">
                  <a class="dropdown-item" href="{{ route('admin.dashboard.docentes.index') }}">Ver todos</a>
                </li>
                <li class="plantel-item ms-3 px-2">
                  <a class="dropdown-item" href="{{ route('admin.dashboard.docentes.create') }}">Registrar</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-10 shadow-lg">
      @yield('content')
    </div>
  </div>
</div>
@yield('scripts')
</body>

</html>


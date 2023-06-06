<div class="row justify-content-center align-items-center vh-100 ">
  <div class="col-md-6 shadow-lg p-4 rounded-2">
    <h3 class="text-center mb-4">Crear docente</h3>
    <form action="@isset($docente)
      {{ route('admin.update-docente')}}
    @else
      {{ route('admin.post-docente')}}
    @endisset" method="post" class="row g-3">
      @csrf
      @isset($docente)
        @method('put')
      @endisset
      <label for="nombres" class="col-md-6">
        <input type="text" placeholder="Nombres" class="form-control" name="nombres" id="nombres" value="@isset($docente)
      {{ $docente->nombres }}
    @endisset">
      </label>
      <label for="apellido_paterno" class="col-md-6">
        <input type="text" placeholder="Apellido paterno" class="form-control" name="apellido_paterno" id="apellido_paterno" value="@isset($docente)
      {{ $docente->apellido_paterno }}
    @endisset">
      </label>
      <label for="apellido_materno" class="col-md-6">
        <input type="text" placeholder="Apellido materno" class="form-control" name="apellido_materno" id="apellido_materno" value="@isset($docente)
      {{ $docente->apellido_materno }}
    @endisset">
      </label>
      <label for="ci" class="col-md-6">
        @isset($docente)
          <input type="text" placeholder="Número de carnet" class="form-control" name="old-ci" id="ci" value="{{ $docente->ci }}" hidden>

        @endisset
        <input type="text" placeholder="Número de carnet" class="form-control" name="ci" id="ci" value="@isset($docente)
      {{ $docente->ci }}
    @endisset">
      </label>
      <div class="col-md-12">
        <input type="submit" value="Crear docente" class="btn btn-outline-success float-end" role="button">
        @isset($docente)
          <input type="submit" value="Actualizar docente" class="btn btn-outline-primary float-start" role="button">

        @endisset
      </div>
    </form>
    <h3 class="text-center mb-4">Buscar docentes</h3>
    <form action="{{ route('admin.get-docente')}}" method="post" class="row g-3">
      @csrf
      <label for="ci" class="col-md-12">
        <input type="text" placeholder="Número de carnet" class="form-control" name="ci" id="ci">
      </label>
      <div class="col-md-12">
        <input type="submit" value="Buscar docente" class="btn btn-outline-success float-end" role="button">
      </div>
    </form>
    <h3 class="text-center mb-4">Asignar docentes</h3>
    <form action="{{ route('admin.get-docente')}}" method="post" class="row g-3">
      @csrf
      <label for="ci" class="col-md-12">
        <input type="text" placeholder="Número de carnet" class="form-control" name="ci" id="ci">
      </label>
      <div class="col-md-12">
        <input type="submit" value="Buscar docente" class="btn btn-outline-success float-end" role="button">
      </div>
      @isset($docente)
        <label>
          Materia:
          <select name="materia" class="form-select">
            @foreach($materias as $materia)
              <option value="">{{ $materia->codigo }}</option>
            @endforeach
          </select>
        </label>
        <label for="">
          Gestion:
          <input type="number" min="2020" max="2023" step="1" value="2020" class="form-control"/>
        </label>
        <div>
          Periodo:
          <label for="" class="form-check-label">
            <input type="radio" class="form-check-input" name="periodo" checked>
            I
          </label>
          <label for="" class="form-check-label">
            <input type="radio" class="form-check-input" name="periodo">
            II
          </label>
          <label for="" class="form-check-label float-end">
            Turno:
            <select name="" id="" class="form-select d-inline">
              <option value="">Mañana</option>
              <option value="">Tarde</option>
              <option value="">Noche</option>
            </select>
          </label>
        </div>
      @endisset
    </form>
  </div>
</div>

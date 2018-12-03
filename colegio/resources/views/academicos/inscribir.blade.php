@extends('main')

@section('title')
  Inscribir Alumnos
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Inscripciones</li>
    <li class="active">Inscribir Alumnos</li>
  </ol>
@endsection
@section('content')
  <div class="box">
    <div class="box-body">
      <form method="POST" action="{{route('inscribir.store')}}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('est') ? 'has-error' : '' }}">
          <label for="est">Estudiante</label>
          <select class="form-control"  name="est" id="est">
            <option value="">Seleccione una opcion...</option>
            @foreach ($estudiantes as $menu)
              <option value="{{$menu->est_ced}}">{{$menu->est_nombres}} {{$menu->est_apellidos}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group {{ $errors->has('sec') ? 'has-error' : '' }}">
          <label for="sec">Seccion y materia</label>
          <select class="form-control"  name="sec" id="sec">
            <option value="">Seleccione una opcion...</option>
            @foreach ($secciones as $menu)
              <option value="{{$menu->id}}">{{$menu->codsec}}-{{$menu->des}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <input class="btn btn-primary" type="submit" value="Crear">
        </div>
    </form>
    </div>
  </div>
@endsection
@section('js')
  <script type="text/javascript">
      $('#est').select2();
      $('#sec').select2();
  </script>
@endsection

@extends('main')

@section('title')
  Inscribir Seccion
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Academicos</li>
    <li class="active">Inscribir Seccion</li>
  </ol>
@endsection

@section('content')
  <div class="box">
    <div class="box-body">
      <form method="POST" action="{{route('Iseccion.store')}}" accept-charset="UTF-8">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('Estudiante') ? 'has-error' : '' }}">
          <label for="Estudiante">Estudiante</label>
          <select class="form-control"  name="Estudiante" id="est">
            <option value="">Seleccione una opcion...</option>
            @foreach ($estudiantes as $menu)
              <option value="{{$menu->est_ced}}">{{$menu->est_nombres}} {{$menu->est_apellidos}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group {{ $errors->has('Seccion') ? 'has-error' : '' }}">
          <label for="Seccion">Seccion</label>
          <select class="form-control"  name="Seccion" id="sec">
            <option value="">Seleccione una opcion...</option>
            @php
              $sec = $secciones[0]->codsec;
            @endphp
            <option value="$sec">Seccion {{$sec}}</option>
            @for ($i=1; $i <sizeof($secciones) ; $i++)
              @if (strnatcasecmp( $secciones[$i]->codsec,$sec) != 0)
                <option value="{{$secciones[$i]->codsec}}">Seccion {{$secciones[$i]->codsec}}</option>
                @php
                  $sec = $secciones[$i]->codsec;
                @endphp
              @endif
            @endfor
          </select>
        </div>
        <div class="form-group">
          <button class="btn btn-success" type="submit"><i class="fa fa-upload"></i> Inscribir</button>
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

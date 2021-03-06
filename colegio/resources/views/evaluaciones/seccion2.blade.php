@extends('main')

@section('title')
  Boletines Primaria
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Evaluaciones</li>
    <li class="active">Boletines Primaria</li>
  </ol>
@endsection

@section('content')
  <div id="alerta" class="alert alert-danger alert-dismissible" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>Error</h4>
    Esta Seccion no tiene ningun estudiante inscrito
  </div>
  <div class="box">
    <div class="box-body">
      <form id="form" method="GET" action="{{route('boletines_primaria_listar')}}" accept-charset="UTF-8">
        {{ csrf_field() }}
        @if (Auth::user()->tipo_id != 6)
        <div class="form-group" id="cmat">
          <label for="mat">Seccion</label>
          <select required class="form-control"  name="sec" id="mater">
            <option disabled selected value="">Seleccione una opcion...</option>
            @if (sizeof($secciones) > 0)
              @php
                $sec = $secciones[0]->codsec;
              @endphp
              @for ($i=1; $i <sizeof($secciones) ; $i++)
                @if (strnatcasecmp( $secciones[$i]->codsec,$sec) != 0 && $secciones[$i]->codsec[0] != '0'  && $secciones[$i]->codsec[0] != 'D')
                  <option value="{{$secciones[$i]->codsec}}">Seccion {{$secciones[$i]->codsec}}</option>
                  @php
                    $sec = $secciones[$i]->codsec;
                  @endphp
                @endif
              @endfor
            @endif
          </select>
        </div>
        @else
          <div class="form-group" id="cmat">
            <label for="mat">Estudiante</label>
            <select required class="form-control"  name="sec" id="mater">
              <option disabled selected value="">Seleccione una opcion...</option>
              @php
                $cedula = -100;
              @endphp
              @for ($i=0; $i <sizeof($hijos) ; $i++)
                @if ($cedula != $hijos[$i]->rep_cedalum)
                  @if ( $hijos[$i]->cod_sec[0] != '0'  && $hijos[$i]->cod_sec[0] != 'D')
                    <option value="{{$hijos[$i]->rep_cedalum}}">{{$hijos[$i]->est_nombres}} {{$hijos[$i]->est_apellidos}}</option>
                    @php
                      $cedula = $hijos[$i]->rep_cedalum;
                    @endphp
                  @endif
                @endif
              @endfor
            </select>
          </div>
        @endif
        <div class="form-group" id="clap">
          <label for="lapso">Lapso</label>
          <select class="form-control"  name="lapso" id="lap">
            <option value="">Seleccione una opcion...</option>
            <option value="1">Primer Lapso</option>
            <option value="2">Segundo Lapso</option>
            <option value="3">Tercer Lapso</option>
          </select>
        </div>
        <div class="form-group">
          <button class="btn btn-success" type="submit"><i class="fa fa-download"></i> Cargar Boletines</button>
        </div>
        </form>
    </div>
  </div>
@endsection
@section('js')
  <script type="text/javascript">
  $('#mater').select2();
  alerta = document.getElementById("alerta");
  if ({{$error}} == 1) {
    alerta.style="display: block;";
  }
  </script>
@endsection

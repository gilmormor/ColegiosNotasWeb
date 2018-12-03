@extends('main')

@section('title')
  Boletines Secundaria
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Evaluaciones</li>
    <li class="active">Boletines Secundaria</li>
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
      <form id="form" method="GET" action="{{route('boletines_listar')}}" accept-charset="UTF-8">
        {{ csrf_field() }}
        @if (Auth::user()->tipo_id != 6)
        <div class="form-group" id="cmat">
          <label for="mat">Seccion</label>
          <select required class="form-control"  name="sec" id="mater">
            <option disabled selected value="">Seleccione una opcion...</option>
            @php
              $sec = $secciones[0]->codsec;
            @endphp
            <option value="{{$sec}}">Seccion {{$sec}}</option>
            @for ($i=1; $i <sizeof($secciones) ; $i++)
              @if (strnatcasecmp( $secciones[$i]->codsec,$sec) != 0 && $secciones[$i]->codsec[0] != 'P'  && $secciones[$i]->codsec[0] != 'M')
                <option value="{{$secciones[$i]->codsec}}">Seccion {{$secciones[$i]->codsec}}</option>
                @php
                  $sec = $secciones[$i]->codsec;
                @endphp
              @endif
            @endfor
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
                  @if ( $hijos[$i]->cod_sec[0] != 'P'  && $hijos[$i]->cod_sec[0] != 'M')
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

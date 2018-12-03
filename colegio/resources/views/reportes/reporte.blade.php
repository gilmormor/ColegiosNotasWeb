@extends('main')

@section('title')
  Reporte de Estudiantes Inscritos
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Reportes</li>
    <li class="active">Estudiantes Inscritos</li>
  </ol>
@endsection
@section('content')
  <div class="box">
    <div class="box-body">
      <div class="table-responsive">
        <div class="row">
          <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$cant}}</h3>
              <p>Estudiantes Inscritos</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
          </div>
        </div>
        </div>
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
              <tr>
                  <th>Cedula</th>
                  <th>Nombre</th>
                  <th>Seccion</th>
              </tr>
          </thead>
          <tbody>
            @php
              $cedula = "";
            @endphp
            @foreach ($users as $user2)
              @if ($cedula != $user2->est_ced)
                @php
                  $cedula = $user2->est_ced;
                @endphp

              <tr class="odd gradeX">
                <td>{{$user2->est_ced}}</td>
                <td>{{$user2->est_nombres}} {{$user2->est_apellidos}}</td>
                <td>
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "M3")
                    Pre-Escolar seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "P1")
                    Primer Grado seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "P2")
                    Segundo Grado seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "P3")
                    Tercer Grado seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "P4")
                    Cuarto Grado seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "P5")
                    Quinto Grado seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "P6")
                    Sexto Grado seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "01")
                    Primer Año seccion{{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "02")
                    Segundo Año seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "03")
                    Tercer Año seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "D4")
                    Cuarto Año seccion {{$user2->cod_sec[3]}}
                  @endif
                  @if ($user2->cod_sec[0].$user2->cod_sec[1] == "D5")
                    Quinto Año seccion {{$user2->cod_sec[3]}}
                  @endif
                </td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
      {!! $users->render() !!}
    </div>
  </div>
@endsection

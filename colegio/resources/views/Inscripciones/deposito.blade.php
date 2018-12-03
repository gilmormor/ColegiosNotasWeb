<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

        <title>{{ config('app.name', 'SGD') }}</title>

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css')}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/skin-blue.min.css')}}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
        <!-- Bootstrap Toggle Styles -->
      	<link href="{{ asset('adminlte/plugins/bootstrap-toggle/bootstrap-toggle.min.css') }}" rel="stylesheet">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}">
        <!-- CSS personalizado-->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/estilos.css')}}">
        <!-- Pace style -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/pace/pace.min.css')}}">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
      <!-- Site wrapper -->
      <div class="wrapper">

        <header class="main-header">
          <!-- Logo -->
          <div class="logo">
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Colegio</b></span>
          </div>
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top">
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('avatar/'.Auth::user()->avatar.'') }}" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{Auth::user()->nombre}} {{Auth::user()->apellido}}</span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <img src="{{ asset('avatar/'.Auth::user()->avatar.'') }}" class="img-circle" alt="User Image">

                      <p>
                        {{Auth::user()->nombre}} {{Auth::user()->apellido}}
                        <small>{{Auth::user()->email}}</small>
                      </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-body">
                      <div class="pull-right">
                        <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}
                        </form>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
        </header>
        <!-- =============================================== -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper deposito">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              Deposito
            </h1>
            <ol class="breadcrumb">
              <li><i class="fa fa-dashboard"></i> Sistema</a></li>
              <li>Depositos</li>
            </ol>
          </section>

          <!-- Main content -->
          <section class="content">
            @include('partials.errors')
            <div class="callout callout-info">
              <h4><i class="icon fa fa-info"></i> Solo se aceptan depositos con fecha a partir de: {{$filtros[0]->fecha_dep=date("d-m-Y",strtotime($filtros[0]->fecha_dep))}}</h4>
              <p>Debe ingresar el numero de deposito coorespondiente. El monto total en efectivo debe ser mayor o igual a
                <strong>Total a depositar</strong>. Si <strong>Total Depositos</strong> es menor al <strong>Total a depositar</strong>
                no podra entrar al sistema. Debe tomar en cuenta que si usted hace los depositos en cheque estps deben ser validados por
                el colegio. Verifique los montos.
              </p>
              </div>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Estudiante(s) Representado(s)</h3>
                </div>
                <div class="box-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Cedula</th>
                        <th>Nombre</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($hijos as $hijo)
                        <tr>
                          <th style="width: 15%">{{$hijo->est_ced}}</th>
                          <th>{{$hijo->est_nombres}} {{$hijo->est_apellidos}}</th>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <!--Deposito Softservica-->
                @if ($filtros[0]->depsoftservi == 1)
                  <form method="POST" action="{{ route('softservi') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="col-md-4">
                      @if ($sof == 1)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Deposito no encontrado.
                        </div>
                      @elseif ($sof == 2)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          EL deposito ya ha sido usado.
                        </div>
                      @elseif ($sof == 3)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Solo se aceptan depositos con fecha a partir de: <strong>{{$filtros[0]->fecha_dep}}</strong>.
                        </div>
                      @elseif ($sof == 4)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Por favor ingrese un deposito realizado a esta cuenta: <strong>{{$filtros[0]->numcuentasoft}}</strong>
                        </div>
                      @endif
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><strong>Softservi C.A</strong></h3>
                        </div>
                        <div class="box-body">
                          <div class="form-group {{ $errors->has('NumeroDepositoSotfservi') ? 'has-error' : '' }}">
                            <label for="NumeroDepositoSotfservi">Numero del deposito</label>
                            <input type="number" name="NumeroDepositoSotfservi" class="form-control" required>
                            <table class="table table-striped">
                              <thead>
                                <tr class="bg-light-blue-active color-palette">
                                  <th>#Dep</th>
                                  <th>Fecha</th>
                                  <th>Efectivo</th>
                                  <th>Cheque</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $totale = 0;
                                  $totalc = 0;
                                @endphp
                                @foreach ($deps as $sof)
                                  @php
                                    $totale += $sof->dep_monto;
                                    $totalc += $sof->dep_montocheque;
                                  @endphp
                                  <tr>
                                    <th>{{$sof->dep_referencia}}</th>
                                    <th>{{date("d-m-Y",strtotime($sof->dep_fecha))}}</th>
                                    <th class="text-right">{{ number_format($sof->dep_monto, 2, ",", ".")}}</th>
                                    <th class="text-right">{{ number_format($sof->dep_montocheque, 2, ",", ".")}}</th>
                                  </tr>
                                @endforeach
                                <tr>
                                  <th colspan="2" class="text-center"><strong>Total Depositos</strong></th>
                                  <th class="text-right" id="sum_sof">{{number_format($totale, 2, ",", ".")}}</th>
                                  <th class="text-right">{{number_format($totalc, 2, ",", ".")}}</th>
                                </tr>
                                <tr>
                                  <th colspan="2" class="bg-light-blue-active color-palette text-center">Monto por Estudiante</th>
                                  <th class="text-right">{{number_format($filtros[0]->mntoweb, 2, ",", ".")}}</th>
                                </tr>
                                @php
                                  $totalp = $filtros[0]->mntoweb * sizeof($hijos);
                                @endphp
                                <tr>
                                  <th colspan="2" class="bg-light-blue-active color-palette text-center">Total a pagar</th>
                                  <th class="text-right">{{number_format($totalp, 2, ",", ".")}}</th>
                                </tr>
                                @php
                                  $faltante = $totalp - $totale;
                                  if ($faltante < 0) {
                                    $faltante = 0;
                                  }
                                @endphp
                                <tr>
                                  <th colspan="2" class="text-center text-danger">Faltante</th>
                                  <th id="falts" class="text-right">{{number_format($faltante, 2, ",", ".")}}</th>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <button class="btn bg-light-blue-active color-palette center-block" type="submit">
                            <i class="fa fa-upload"></i> Guardar deposito
                          </button>
                        </div>
                      </div><!--Fin box primary -->
                    </div><!--Fin col-->
                  </form>
                @endif
                <!--Deposito Colegio-->
                @if ($filtros[0]->depcolegio == 1)
                  <form method="POST" action="{{ route('colegio') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="col-md-4">
                      @if ($col == 1)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Deposito no encontrado.
                        </div>
                      @elseif ($col == 2)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          EL deposito ya ha sido usado.
                        </div>
                      @elseif ($col == 3)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Solo se aceptan depositos con fecha a partir de: <strong>{{$filtros[0]->fecha_dep}}</strong>.
                        </div>
                      @elseif ($col == 4)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Por favor ingrese un deposito realizado a esta cuenta: <strong>{{$filtros[0]->numcuentacol}}</strong>
                        </div>
                      @endif
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><strong>Colegio</strong></h3>
                        </div>
                        <div class="box-body">
                          <div class="form-group {{ $errors->has('NumeroDepositoColegio') ? 'has-error' : '' }}">
                            <label for="NumeroDepositoColegio">Numero del deposito</label>
                            <input type="number" name="NumeroDepositoColegio" class="form-control">
                            <table class="table table-striped">
                              <thead>
                                <tr class="bg-light-blue-active color-palette">
                                  <th>#Dep</th>
                                  <th>Fecha</th>
                                  <th>Efectivo</th>
                                  <th>Cheque</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $totale = 0;
                                  $totalc = 0;
                                @endphp
                                @foreach ($depc as $col)
                                  @php
                                    $totale += $col->dep_monto;
                                    $totalc += $col->dep_montocheque;
                                  @endphp
                                  <tr>
                                    <th>{{$col->dep_referencia}}</th>
                                    <th>{{date("d-m-Y",strtotime($col->dep_fecha))}}</th>
                                    <th class="text-right">{{number_format($col->dep_monto, 2, ",", ".")}}</th>
                                    <th class="text-right">{{number_format($col->dep_montocheque, 2, ",", ".")}}</th>
                                  </tr>
                                @endforeach
                                <tr>
                                  <th colspan="2" class="text-center"><strong>Total Depositos</strong></th>
                                  <th class="text-right">{{number_format($totale, 2, ",", ".")}}</th>
                                  <th class="text-right">{{number_format($totalc, 2, ",", ".")}}</th>
                                </tr>
                                <tr>
                                  <th colspan="2" class="bg-light-blue-active color-palette text-center">Deuda</th>
                                  <th class="text-right">{{number_format($cuotas, 2, ",", ".")}}</th>
                                </tr>
                                <tr>
                                  <th colspan="2" class="bg-light-blue-active color-palette text-center">Monto por Inscripcion</th>
                                  <th class="text-right">{{number_format($filtros[0]->mtoinsc, 2, ",", ".")}}</th>
                                </tr>
                                @php
                                  $totalp = ($filtros[0]->mtoinsc * sizeof($hijos)) + $cuotas;
                                @endphp
                                <tr>
                                  <th colspan="2" class="bg-light-blue-active color-palette text-center">Total a pagar</th>
                                  <th class="text-right">{{number_format($totalp, 2, ",", ".")}}</th>
                                </tr>
                                @php
                                  $faltante = $totalp - $totale;
                                  if ($faltante < 0) {
                                    $faltante = 0;
                                  }
                                @endphp
                                <tr>
                                  <th colspan="2" class="text-center text-danger">Faltante</th>
                                  <th id="faltc" class="text-right">{{number_format($faltante, 2, ",", ".")}}</th>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <button class="btn bg-light-blue-active color-palette center-block" type="submit">
                            <i class="fa fa-upload"></i> Guardar deposito
                          </button>
                        </div>
                      </div><!--Fin box primary -->
                    </div><!--Fin col-->
                  </form>
                @endif
                <!--Deposito Junta Padres-->
                @if ($filtros[0]->depconpadres == 1)
                  <form method="POST" action="{{ route('padres') }}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <div class="col-md-4">
                      @if ($pad == 1)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Deposito no encontrado.
                        </div>
                      @elseif ($pad == 2)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          EL deposito ya ha sido usado.
                        </div>
                      @elseif ($pad == 3)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Solo se aceptan depositos con fecha a partir de: <strong>{{$filtros[0]->fecha_dep}}</strong>.
                        </div>
                      @elseif ($pad == 4)
                        <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h4><i class="icon fa fa-ban"></i> Importante!</h4>
                          Por favor ingrese un deposito realizado a esta cuenta: <strong>{{$filtros[0]->numcuentapad}}</strong>
                        </div>
                      @endif
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><strong>Junta de Padres</strong></h3>
                        </div>
                        <div class="box-body">
                          <div class="form-group {{ $errors->has('NumeroDepositoPadres') ? 'has-error' : '' }}">
                            <label for="NumeroDepositoPadres">Numero del deposito</label>
                            <input type="number" name="NumeroDepositoPadres" class="form-control">
                            <table class="table table-striped">
                              <thead>
                                <tr class="bg-light-blue-active color-palette">
                                  <th>#Dep</th>
                                  <th>Fecha</th>
                                  <th>Efectivo</th>
                                  <th>Cheque</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $totale = 0;
                                  $totalc = 0;
                                @endphp
                                @foreach ($depjp as $jp)
                                  @php
                                    $totale += $jp->dep_monto;
                                    $totalc += $jp->dep_montocheque;
                                  @endphp
                                  <tr>
                                    <th>{{$jp->dep_referencia}}</th>
                                    <th>{{date("d-m-Y",strtotime($jp->dep_fecha))}}</th>
                                    <th class="text-right">{{number_format($jp->dep_monto, 2, ",", ".")}}</th>
                                    <th class="text-right">{{number_format($jp->dep_montocheque, 2, ",", ".")}}</th>
                                  </tr>
                                @endforeach
                                <tr>
                                  <th colspan="2">Total Depositos</th>
                                  <th class="text-right">{{number_format($totale, 2, ",", ".")}}</th>
                                  <th class="text-right">{{number_format($totalc, 2, ",", ".")}}</th>
                                </tr>
                                <tr>
                                  <th colspan="2" class="bg-light-blue-active color-palette text-center">Total a pagar</th>
                                  <th class="text-right">{{number_format($filtros[0]->mtoconpadres, 2, ",", ".")}}</th>
                                </tr>
                                @php
                                  $faltante = $filtros[0]->mtoconpadres - $totale;
                                  if ($faltante < 0) {
                                    $faltante = 0;
                                  }
                                @endphp
                                <tr>
                                  <th colspan="2" class="text-center text-danger">Faltante</th>
                                  <th id="faltp" class="text-right">{{number_format($faltante, 2, ",", ".")}}</th>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <button class="btn bg-light-blue-active color-palette center-block" type="submit">
                            <i class="fa fa-upload"></i> Guardar deposito
                          </button>
                        </div>
                      </div><!--Fin box primary -->
                    </div><!--Fin col-->
                  </form>
                @endif
              </div><!--Fin row -->
              <form method="POST" action="{{ route('siguiente') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="row">
                  <input type="text" name="vald" id="vald" style="display:none">
                  <div class="col-xs-12">
                    <div class="form-group">
                      <button class="btn btn-lg bg-light-blue-active color-palette col-xs-12" type="submit" style="display:none" id="sig">
                        Siguiente
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </section>
            <!-- /.content -->
          </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer deposito">
          <div class="pull-right hidden-xs">
            <b>Version</b> 2
          </div>
          <strong>Softservica &copy; 2017, todos los derechos reservados.
        </footer>

      </div>
        <!-- jQuery 3 -->
        <script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- datepicker -->
        <script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
        <!-- Slimscroll -->
        <script src="{{ asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('adminlte/dist/js/adminlte.min.js')}}"></script>
        <!-- Bootstrap Toggle Js -->
        <script src="{{ asset('adminlte/plugins/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
        <!-- PACE -->
        <script src="{{ asset('adminlte/bower_components/PACE/pace.min.js')}}"></script>
        <script type="text/javascript">
          if ({{$filtros[0]->depsoftservi}} == 1 && {{$filtros[0]->depcolegio}} == 1 && {{$filtros[0]->depconpadres}} == 1) {
            var falts = parseFloat(document.getElementById("falts").innerHTML);
            var faltc = parseFloat(document.getElementById("faltc").innerHTML);
            var faltp = parseFloat(document.getElementById("faltp").innerHTML);
            var sig  = falts + faltp + faltc;
          }
          else if ({{$filtros[0]->depsoftservi}} == 1 && {{$filtros[0]->depcolegio}} == 1) {
            var falts = parseFloat(document.getElementById("falts").innerHTML);
            var faltc = parseFloat(document.getElementById("faltc").innerHTML);
            var sig  = falts + faltp;
          }
          else if ({{$filtros[0]->depsoftservi}} == 1 && {{$filtros[0]->depconpadres}} == 1) {
            var falts = parseFloat(document.getElementById("falts").innerHTML);
            var faltp = parseFloat(document.getElementById("faltp").innerHTML);
            var sig  = falts + faltc;
          }
          else if ({{$filtros[0]->depcolegio}} == 1 && {{$filtros[0]->depconpadres}} == 1) {
            var faltc = parseFloat(document.getElementById("faltc").innerHTML);
            var faltp = parseFloat(document.getElementById("faltp").innerHTML);
            var sig  = faltp + faltc;
          }
          else if ({{$filtros[0]->depsoftservi}} == 1) {
            var falts = parseFloat(document.getElementById("falts").innerHTML);
            var sig  = falts;
          }
          else if ({{$filtros[0]->depcolegio}} == 1) {
            var faltc = parseFloat(document.getElementById("faltc").innerHTML);
            var sig  = faltc;
          }
          else if ({{$filtros[0]->depconpadres}} == 1) {
            var faltp = parseFloat(document.getElementById("faltp").innerHTML);
            var sig  = faltp;
          }
          if (sig == 0) {
            document.getElementById("sig").removeAttribute('style');
            document.getElementById("vald").value = sig;
          }
          else {
            document.getElementById("sig").setAttribute('style', 'display:none');
          }
        </script>
    </body>
</html>

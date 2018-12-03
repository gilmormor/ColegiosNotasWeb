<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

        <title>{{ $nombrec[0]->nomcorto }}</title>

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
          <a href="{{route('home')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b><i class="fa fa-dashboard"></i></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ $nombrec[0]->nomcorto }}</b></span>
          </a>
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>

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
                      <div class="pull-left">
                        <a href="{{route('perfil')}}" class="btn btn-default btn-flat">Perfil</a>
                      </div>
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

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
              <div class="pull-left image">
                <img src="{{ asset('avatar/'.Auth::user()->avatar.'') }}" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                <p>{{Auth::user()->nombre}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
              <li class="header">Menu de navegación</li>
              <li>
                <a href="{{route('home')}}">
                  <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
              </li>
              @foreach ($menus as $key => $item)
  								@if ($item['parent'] != 0)
  										@break
  									@endif
  									@include('partials.menu', ['item' => $item])
  							@endforeach
            </ul>
          </section>
          <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              @yield('title')
            </h1>
              @yield('breadcrumb')
          </section>

          <!-- Main content -->
          <section class="content">
            @include('partials.errors')
            @yield('content')
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
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
          $(document).ajaxStart(function() { Pace.restart(); });
        </script>
        @yield('js')
    </body>
</html>

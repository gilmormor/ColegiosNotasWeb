<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}">

  <title>{{ config('app.name', 'SGD') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport')}}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/square/blue.css')}}">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a>Colegio</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Registrar Usuario</p>

    <form method="POST" action="{{ route('registro.store') }}">
      {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('cedula') ? ' has-error' : '' }}">
        <input type="text" class="form-control" placeholder="Cedula 12345678" name="cedula" required autofocus>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @if ($errors->has('cedula'))
            <span class="help-block">
                <strong>{{ $errors->first('cedula') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
        </div>
        <div class="col-xs-6">
          <a href="{{route('home')}}" class="btn btn-primary btn-block btn-flat">Volver</a>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <!--
    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>
    -->
    <hr>
    @if ($error == 1)
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i>Error!</h4>
        Su cedula no se encuentra en nuestros registros contacte con nosotros
      </div>
    @endif
    @if ($error == 2)
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i>Alerta!</h4>
        Usted ya se encuentra resgistrado
      </div>
    @endif

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
</body>
</html>

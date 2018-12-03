@extends('main')
@section('title')
  Perfil
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li class="active">Perfil</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ asset('avatar/'.Auth::user()->avatar.'') }}" alt="User profile picture">

          <h3 class="profile-username text-center">{{Auth::user()->nombre}} {{Auth::user()->apellido}}</h3>

          <p class="text-muted text-center">{{Auth::user()->email}}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Cedula</b> <a class="pull-right">{{Auth::user()->cedula}}</a>
            </li>
            <li class="list-group-item">
              <b>Rol</b> <a class="pull-right">{{Auth::user()->tipo->name}}</a>
            </li>
            <li class="list-group-item">
              <b>Telefono</b> <a class="pull-right">{{Auth::user()->telefono}}</a>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <div class="col-md-9">
      <div class="box">
        <div class="box-body">
          <form role="form" enctype="multipart/form-data" action="{{ route('perfil.update',Auth::user()->id) }}" method="POST">
              <input name="_method" type="hidden" value="PUT">
              {{ csrf_field() }}
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Nombres</label>
                          <input class="form-control" value="{{Auth::user()->nombre}}" required="" name="name" type="text" id="name">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Apellidos</label>
                          <input class="form-control" value="{{Auth::user()->apellido}}" required="" name="last_name" type="text" id="last_name">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label>Email</label>
                          <input class="form-control" value="{{Auth::user()->email}}" required="" name="email" type="email" id="email">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Telefono</label></label>
                          <input class="form-control" value="{{Auth::user()->telefono}}" required="" name="phone" type="number" id="phone">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Cedula</label>
                          <input class="form-control" value="{{Auth::user()->cedula}}" required="" name="cedula" type="number" id="cedula">
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Contrase&ntilde;a</label>
                          <input type="password" name="password" class="form-control" placeholder="*******" value="">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Repetir contrase&ntilde;a</label>
                          <input type="password" name="password_confirmation" class="form-control" placeholder="*******" value="">
                      </div>
                  </div>
              </div>
              <button type="submit" class="btn btn-success btn-fill pull-right"><i class="fa fa-pencil"></i> Actualizar perfil</button>
              <div class="clearfix"></div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
@endsection

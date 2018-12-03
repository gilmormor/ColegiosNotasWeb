@extends('main')

@section('title')
  Modificar Depositos
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Admistrativo</li>
    <li class="active">Editar Depositos Softservi C.A</li>
  </ol>
@endsection
@section('content')
  @if ($paso == 1)
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Importante!</h4>
        Deposito cambiado.
    </div>
  @endif
  <div class="alert alert-danger alert-dismissible" style="Display:none" id="dne">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Importante!</h4>
    Deposito no encontrado.
  </div>
  <div class="alert alert-danger alert-dismissible" style="Display:none" id="usa">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Importante!</h4>
    Deposito ya usado use otro.
  </div>
  <form method="POST" action="{{ route('editardep.softservi') }}" accept-charset="UTF-8">
    {{ csrf_field() }}
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Editar Deposito</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="form-group col-md-6">
            <label for="NumeroDeposito">Numero del deposito</label>
            <input type="number" name="NumeroDeposito" class="form-control" id="ref">
          </div>
          <div class="form-group col-md-6">
            <label for="cedula">Cedula</label>
            <input type="number" name="cedula" class="form-control" disabled="disabled" id="cedula">
          </div>
          <div class="form-group col-md-6">
            <label for="estatus">Estatus</label>
            <input type="text" name="estatus" class="form-control" disabled="disabled" id="status">
          </div>
          <div class="form-group col-md-6">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" disabled="disabled" id="fecha">
          </div>
          <div class="form-group col-md-6">
            <label for="Monto">Monto Efectivo</label>
            <input type="number" name="Monto" class="form-control" disabled="disabled" id="montoE">
          </div>
          <div class="form-group col-md-6">
            <label for="montoc">Monto Cheque</label>
            <input type="number" name="montoc" class="form-control" disabled="disabled" id="montoC">
          </div>
        </div>
      </div>
    </div>
    <div class="form-group ">
      <button class="btn btn-success" type="button" onclick="cargar();"><i class="fa fa-upload"></i> Cargar Deposito</button>
      <button class="btn btn-info" type="submit" id="sig" style="display:none"><i class="fa fa-money"></i> Hacer Efectivo</button>
    </div>
  </form>
@endsection

@section('js')
  <script>
    function cargar(){
      $.get("editardepositosof/table/"+document.getElementById("ref").value+"",function(response,state){
        if (response.falla == 1) {
          document.getElementById("dne").removeAttribute('style');
        }else if (response.falla == 0) {
          document.getElementById("dne").setAttribute('style', 'display:none');
        }
        if (response.refe != null) {
          document.getElementById("cedula").value = response.refe[0].dep_cedula;
          if (response.refe[0].dep_status != 0) {
            var sta = "Deposito Usado";
            var usado = false;
          }else {
            var sta = "Deposito no Usado";
            var usado = true;
          }
          document.getElementById("status").value = sta;
          document.getElementById("fecha").value = response.refe[0].dep_fechavalor;
          document.getElementById("montoE").value = response.refe[0].dep_montocheque;
          document.getElementById("montoC").value = response.refe[0].dep_montocheque;
          if (usado) {
            document.getElementById("sig").removeAttribute('style');
            document.getElementById("usa").setAttribute('style', 'display:none');
          }else {
            document.getElementById("sig").setAttribute('style', 'display:none');
            document.getElementById("usa").removeAttribute('style');
          }

        }
      });
    };
  </script>
@endsection

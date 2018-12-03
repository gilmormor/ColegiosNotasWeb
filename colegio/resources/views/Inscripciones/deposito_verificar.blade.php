@extends('main')

@section('title')
  Inscripciones por Deposito
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Inscripciones</li>
    <li class="active">Depositos</li>
  </ol>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
        <form method="GET" action="{{route('inscripciones.depositos')}}" accept-charset="UTF-8">
          {{ csrf_field() }}
          @if ($filtros[0]->depsoftservi == 1)
            <div class="form-group {{ $errors->has('DepositoSoftservica') ? 'has-error' : '' }}">
              <label for="DepositoSoftservica">Ingrese el numero de referencia del deposito de Softservica</label>
              <input type="number" name="DepositoSoftservica" class="form-control" id="sof" required>
            </div>
          @endif

          @if ($filtros[0]->depcolegio == 1)
            <div class="form-group {{ $errors->has('DepositoColegio') ? 'has-error' : '' }}">
              <label for="DepositoColegio">Ingrese el numero de referencia del deposito del Colegio</label>
              <input type="number" name="DepositoColegio" class="form-control" id="col" required>
            </div>
          @endif

          @if ($filtros[0]->depconpadres == 1)
            <div class="form-group {{ $errors->has('DepositoJuntaPadres') ? 'has-error' : '' }}">
              <label for="DepositoJuntaPadres">Ingrese el numero de referencia del deposito de la junta de condimino de padres</label>
              <input type="number" name="DepositoJuntaPadres" class="form-control" id="pad" required>
            </div>
          @endif
          <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Cargar depositos</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    function cargar_dep(){
      @if ($filtros[0]->depconpadres == 1 && $filtros[0]->depcolegio == 1 && $filtros[0]->depsoftservi == 1)
        var id = ""+document.getElementById("sof").value+"-"+document.getElementById("col").value+"-"+document.getElementById("pad").value;
      @endif

      $.get("vefificar/deposito/"+id+"",function(reponse,state){
        console.log(reponse);
      });
    }
  </script>
@endsection

@extends('main')

@section('title')
  Inscripciones por Punto Venta
@endsection
@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Sistema</a></li>
    <li>Inscripciones</li>
    <li class="active">Punto Venta</li>
  </ol>
@endsection
@section('content')
  <div class="car">
    <form method="POST" action="{{route('puntoventa.store') }}" accept-charset="UTF-8">
      {{ csrf_field() }}
        @if ($filtros[0]->depsoftservi == 1)
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Deposito para Softservica</h3>
            </div>
            <div class="box-body">
            <div class="row">
              <div class="form-group col-md-6 {{ $errors->has('NumeroCuentaSoftservica') ? 'has-error' : '' }}">
                <label for="NumeroCuentaSoftservica">Numero de cuenta del deposito</label>
                <input type="number" name="NumeroCuentaSoftservica" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('NumeroReferenciaSoftservica') ? 'has-error' : '' }}">
                <label for="NumeroReferenciaSoftservica">Numero de referencia del deposito</label>
                <input type="number" name="NumeroReferenciaSoftservica" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('FechaDepositoSoftservica') ? 'has-error' : '' }}">
                <label for="FechaDepositoSoftservica">Fecha del deposito</label>
                <input type="text" class="form-control datepicker" name="FechaDepositoSoftservica" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('MontoDepositoSoftservica') ? 'has-error' : '' }}">
                <label for="MontoDepositoSoftservica">Monto del deposito</label>
                <input type="number" step="0.01" name="MontoDepositoSoftservica" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('CedulaEstudianteSoftservica') ? 'has-error' : '' }}">
                <label for="CedulaEstudianteSoftservica">Cedula del estudiante</label>
                <input type="number" name="CedulaEstudianteSoftservica" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('FormaPagoSoftservica') ? 'has-error' : '' }}">
                <label for="FormaPagoSoftservica">Forma de pago</label>
                <select class="form-control" name="FormaPagoSoftservica" required>
                  <option value="" disabled selected>Seleccione una opcion</option>
                  <option value="4">Tarjeta de credito</option>
                  <option value="5">Tarjeta de debito</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        @endif
        @if ($filtros[0]->depcolegio == 1)
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Deposito para el Colegio</h3>
            </div>
            <div class="box-body">
            <div class="row">
              <div class="form-group col-md-6 {{ $errors->has('NumeroCuentaColegio') ? 'has-error' : '' }}">
                <label for="NumeroCuentaColegio">Numero de cuenta del deposito</label>
                <input type="number" name="NumeroCuentaColegio" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('NumeroReferenciaColegio') ? 'has-error' : '' }}">
                <label for="NumeroReferenciaColegio">Numero de referencia del deposito</label>
                <input type="number" name="NumeroReferenciaColegio" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('FechaDepositoColegio') ? 'has-error' : '' }}">
                <label for="FechaDepositoColegio">Fecha del deposito</label>
                <input type="text" class="form-control datepicker" name="FechaDepositoColegio" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('MontoDepositoColegio') ? 'has-error' : '' }}">
                <label for="MontoDepositoColegio">Monto del deposito</label>
                <input type="number" step="0.01" name="MontoDepositoColegio" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('CedulaEstudianteColegio') ? 'has-error' : '' }}">
                <label for="CedulaEstudianteColegio">Cedula del estudiante</label>
                <input type="number" name="CedulaEstudianteColegio" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('FormaPagoColegio') ? 'has-error' : '' }}">
                <label for="FormaPagoColegio">Forma de pago</label>
                <select class="form-control" name="FormaPagoColegio" required>
                  <option value="" disabled selected>Seleccione una opcion</option>
                  <option value="4">Tarjeta de credito</option>
                  <option value="5">Tarjeta de debito</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        @endif
        @if ($filtros[0]->depconpadres == 1)
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Deposito Junta de Representantes</h3>
            </div>
            <div class="box-body">
            <div class="row">
              <div class="form-group col-md-6 {{ $errors->has('NumeroCuentaJuntaRepre') ? 'has-error' : '' }}">
                <label for="NumeroCuentaJuntaRepre">Numero de cuenta del deposito</label>
                <input type="number" name="NumeroCuentaJuntaRepre" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('NumeroReferenciaJuntaRepre') ? 'has-error' : '' }}">
                <label for="NumeroReferenciaJuntaRepre">Numero de referencia del deposito</label>
                <input type="number" name="NumeroReferenciaJuntaRepre" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('FechaDepositoJuntaRepre') ? 'has-error' : '' }}">
                <label for="FechaDepositoJuntaRepre">Fecha del deposito</label>
                <input type="text" class="form-control datepicker" name="FechaDepositoJuntaRepre" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('MontoDepositoJuntaRepre') ? 'has-error' : '' }}">
                <label for="MontoDepositoJuntaRepre">Monto del deposito</label>
                <input type="number" step="0.01" name="MontoDepositoJuntaRepre" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('CedulaEstudianteJuntaRepre') ? 'has-error' : '' }}">
                <label for="CedulaEstudianteJuntaRepre">Cedula del estudiante</label>
                <input type="number" name="CedulaEstudianteJuntaRepre" class="form-control" required>
              </div>
              <div class="form-group col-md-6 {{ $errors->has('FormaPagoJuntaRepre') ? 'has-error' : '' }}">
                <label for="FormaPagoJuntaRepre">Forma de pago</label>
                <select class="form-control" name="FormaPagoJuntaRepre" required>
                  <option value="" disabled selected>Seleccione una opcion</option>
                  <option value="4">Tarjeta de credito</option>
                  <option value="5">Tarjeta de debito</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        @endif
          <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Cargar depositos</button>
    </form>
  </div>
@endsection
@section('js')
  <script type="text/javascript">
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true
    })
  </script>
@endsection

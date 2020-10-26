@extends('layouts.app')

@section('content')
<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-warning" style="background: rgb(255, 255, 255,0.3)">
              <div class="card-header">
                <h3 class="">Editar Venta</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('venta.update',$venta->id)}}" method="POST">

                @csrf
                <input type="hidden" name="mes_id" value="{{$mes->id}}">
                <input type="hidden" name="_method" value="PUT">
                <!-- Button trigger modal -->
                

                <div class="card-body">
                  <div class="form-group">
                    <label for="cliente_id">Cliente</label>
                    <div class="col">
                        <select id="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror" name="cliente_id" value="{{ old('cliente_id')?old('cliente_id'):$venta->cliente_id }}" >

                           @if(old('cliente_id'))

                           <option value="{{old('cliente_id')}}">{{App\Cliente::find(old('cliente_id'))->nit_ci}} - {{App\Cliente::find(old('cliente_id'))->nombre_rs}}</option>
                           @else

                           <option value="{{$venta->cliente_id}}">{{$venta->cliente->nit_ci}} - {{$venta->cliente->nombre_rs}}</option>
                           @endif

                           @foreach($clientes as $cliente)
                           @if(((old('cliente_id'))?old('cliente_id') :$venta->cliente_id )!=$cliente->id)
                           <option id="option{{$cliente->id}}" value="{{$cliente->id}}">{{$cliente->nit_ci}} - {{$cliente->nombre_rs}}</option>
                           @endif
                           @endforeach
                        </select>
                        @error('cliente_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="especificacion">Especificación</label>
                      <div class="col">
                          <input name="especificacion" readonly type="number" id="especificacion" class="form-control @error('especificacion') is-invalid @enderror" value="{{ old('especificacion')?old('especificacion'): $venta->especificacion }}">

                          @error('especificacion')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="fecha">Fecha</label>
                      <div class="col">
                          <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ old('fecha')?old('fecha'): $venta->fecha }}" required autocomplete="fecha" >
                          @error('fecha')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nro_factura">Numero de Factura</label>
                      <div class="col">
                          <input id="nro_factura" type="number" class="form-control @error('nro_factura') is-invalid @enderror" name="nro_factura" value="{{ old('nro_factura')? old('nro_factura'):$venta->nro_factura }}" required  >

                          @error('nro_factura')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="estado">Estado</label>
                      <div class="col">
                        <select name="estado" id="estado" >
                          <option value="{{old('estado')? old('estado') :$venta->estado}}">{{old('estado')? (old('estado')=='1'? 'Verificado': 'Anulado') : ($venta->estado==1? 'Verificado': 'Anulado') }} </option>
                          <option value="{{old('estado')? (1-old('estado')) : (1-$venta->estado)}}">{{old('estado')? (old('estado')!='1'? 'Verificado': 'Anulado') : ($venta->estado!=1? 'Verificado': 'Anulado') }} </option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="importe">Importe</label>
                      <div class="col">
                          <input id="importe" type="number" step=".01" class="form-control @error('importe') is-invalid @enderror" name="importe" value="{{ old('importe')? old('importe') : $venta->importe }}" required  >
                          @error('importe')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="cod_control">Codigo de Control</label>
                      
                      <div class="col">
                          <input id="cod_control" type="text" class="form-control @error('cod_control') is-invalid @enderror" name="cod_control" value="{{ old('cod_control')? old('cod_control'):$venta->cod_control }}"  >
                          @error('cod_control')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="row justify-content-center">
                        <div class="col-5">
                            <div class="row justify-content-end">
                            <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                        <div class="col-2"></div>

                        </form>
                        <div class="col-5">
                            <a href="{{route('venta.mes',$mes)}}" class='btn btn-danger'>Cancelar</a>
                        </div>
                    </div>
                </div>            
            </div>
</div>
</div>

@endsection

@section('scripts')
 <script>

  

  $('#cod_control').keyup(onChangeText);
  function onChangeText(){
    
    var cod=$('#cod_control').val();
    
    switch(cod.length){
      
      case 12:
        if(cod.charAt(cod.length-1)!='-'){
          cod=cod.substring(0,11)+'-'+cod.substring(11,12);
          $('#cod_control').val(cod); break;
        }
        
      default:
      if(cod.length>14){
        cod=cod.substring(0,14);
        $('#cod_control').val(cod);
      }
      if(cod.length<11){
        let grupos=cod.split('-');
        if(grupos[grupos.length-1].length==2){
          cod=cod+'-';
          $('#cod_control').val(cod);
        }
      }

    }
  }

 </script>
@endsection
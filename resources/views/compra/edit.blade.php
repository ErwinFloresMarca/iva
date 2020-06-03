@extends('layouts.app')

@section('content')
<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-warning" style="background: rgb(255, 255, 255,0.3)">
              <div class="card-header">
                <h3 class="">Editar Compra</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('compra.update',$compra->id)}}" method="POST">

                @csrf
                <input type="hidden" name="mes_id" value="{{$mes->id}}">
                <input type="hidden" name="_method" value="PUT">
                <!-- Button trigger modal -->
                

                <div class="card-body">
                  <div class="form-group">
                    <label for="mes">Proveedor</label>
                    <div class="col">
                        <select id="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror" name="proveedor_id" value="{{ old('proveedor_id')?old('proveedor_id'):$compra->proveedor_id }}" >

                           @if(old('proveedor_id'))

                           <option value="{{old('proveedor_id')}}">{{App\Proveedor::find(old('proveedor_id'))->NIT}} - {{App\Proveedor::find(old('proveedor_id'))->razon_social}}</option>
                           @else

                           <option value="{{$compra->proveedor_id}}">{{$compra->proveedor->NIT}} - {{$compra->proveedor->razon_social}}</option>
                           @endif

                           @foreach($proveedores as $proveedor)
                           @if(((old('proveedor_id'))?old('proveedor_id') :$compra->proveedor_id )!=$proveedor->id)
                           <option id="option{{$proveedor->id}}" value="{{$proveedor->id}}">{{$proveedor->NIT}} - {{$proveedor->razon_social}}</option>
                           @endif
                           @endforeach
                        </select>
                        @error('proveedor_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="especificacion">Especificación</label>
                      <div class="col">
                          <select name="especificacion" id="especificacion" class="form-control @error('especificacion') is-invalid @enderror" value="{{ old('especificacion')?old('especificacion'): $compra->especificacion }}">
                            <option value="1">Local</option>
                            <option value="2">Nacional</option>
                            <option value="3">Inter Nacional</option>
                          </select>
                          @error('especificacion')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  <div class="form-group">
                      <label for="exampleInputEmail1">Fecha</label>
                      <div class="col">
                          <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ old('fecha')?old('fecha'): $compra->fecha }}" required autocomplete="fecha" >
                          @error('fecha')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="razon_social">Numero de Factura</label>
                      
                      <div class="col">
                          <input id="nro_factura" type="number" class="form-control @error('nro_factura') is-invalid @enderror" name="nro_factura" value="{{ old('nro_factura')? old('nro_factura'):$compra->nro_factura }}" required  >

                          @error('nro_factura')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                      
                    </div>

                    <div class="form-group">
                      <label for="nro_autorizacion">Importe</label>
                      <div class="col">
                          <input id="importe" type="number" step=".01" class="form-control @error('importe') is-invalid @enderror" name="importe" value="{{ old('importe')?old('importe') :$compra->importe }}" required  >
                          @error('importe')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="razon_social">Codigo de Control</label>
                      
                      <div class="col">
                          <input id="cod_control" type="text" class="form-control @error('cod_control') is-invalid @enderror" name="cod_control" value="{{ old('cod_control')? old('cod_control'):$compra->cod_control }}" required  >
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
                            <a href="{{route('compra.mes',$mes)}}" class='btn btn-danger'>Cancelar</a>
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
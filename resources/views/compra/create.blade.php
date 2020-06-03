@extends('layouts.app')

@section('content')

<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-success" style="background: rgb(255, 255, 255,0.3)">
              <div class="card-header">
                <h3 class="card-title">Nueva Compra</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('compra.store')}}" method="POST">
                @csrf
                <input type="hidden" name="mes_id" value="{{$mes->id}}">
                <!-- Button trigger modal -->
                
<button id="btnMostrarSeleccion" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSelect">
  Selecionar Proveedor
</button>

<!-- Modal  Select-->
<div class="modal fade" id="modalSelect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Selecionar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input id="provSelect" type="hidden" name='prooveedorSeleccionado' value='false'>
        <div class="form-group">
                    <label for="mes">Proveedor</label>
                    <div class="col">
                        <select id="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror" name="proveedor_id" value="{{ old('proveedor_id')?old('proveedor_id'):'' }}" >
                           @foreach($proveedores as $proveedor)
                           <option id="option{{$proveedor->id}}" value="{{$proveedor->id}}">{{$proveedor->NIT}} - {{$proveedor->razon_social}}</option>
                           @endforeach
                        </select>
                        @error('proveedor_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick='guardarSeleccion()' class="btn btn-primary" data-dismiss="modal">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal-->

<button id="btnMostrarRegistro" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProveedor">
  Registrar Proveedor
</button>

<!-- Modal nuevo Proveedor-->
<div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input id="nuevoProveedor" type="hidden" name='nuevoProveedor' value='false'>
                <div class="form-group">
                    <label for="exampleInputEmail1">NIT</label>
                    <div class="col">
                        <input id="NIT" type="number" class="form-control @error('NIT') is-invalid @enderror" name="NIT" value="{{ old('NIT') }}"  autocomplete="NIT" >
                        @error('NIT')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="razon_social">Razón Social</label>
                    
                    <div class="col">
                        <input id="razon_social" type="text" class="form-control @error('razon_social') is-invalid @enderror" name="razon_social" value="{{ old('razon_social') }}" autocomplete="razon_social" >

                        @error('razon_social')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <label for="nro_autorizacion">Numero de Autorización</label>
                    <div class="col">
                        <input id="nro_autorizacion" type="number" class="form-control @error('nro_autorizacion') is-invalid @enderror" name="nro_autorizacion" value="{{ old('nro_autorizacion') }}"  autocomplete="nro_autorizacion" >
                        @error('nro_autorizacion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick='guardarCambiosNuevoProveedor()' class="btn btn-primary" data-dismiss="modal">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal-->


                <div class="card-body">
                  <font size='5'>
                  <div id='groupMostrarProv' class="form-group" style="display: none">
                      <label for="">NIT: </label> <label id="labelMostrarNIT"></label><br>
                      <label for="">Razon Social: </label> <label id="labelMostrarRazonSocial"></label>
                  </div>
                  </font>
                    <div class="form-group">
                      <label for="especificacion">Especificación</label>
                      <div class="col">
                          <select name="especificacion" id="especificacion" class="form-control @error('especificacion') is-invalid @enderror" value="{{ old('especificacion')?old('especificacion'): '' }}">
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
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Fecha</label>
                      <div class="col">
                          <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ old('fecha')?old('fecha'): date('d-m-y') }}" required autocomplete="fecha" >
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
                          <input id="nro_factura" type="number" class="form-control @error('nro_factura') is-invalid @enderror" name="nro_factura" value="{{ old('nro_factura') }}" required  >

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
                          <input id="importe" type="number" step=".01" class="form-control @error('importe') is-invalid @enderror" name="importe" value="{{ old('importe') }}" required  >
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
                          <input id="cod_control" type="text" class="form-control @error('cod_control') is-invalid @enderror" name="cod_control" value="{{ old('cod_control') }}" required  >
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
  function guardarCambiosNuevoProveedor(){
    $("#nuevoProveedor").val('true');
    $("#provSelect").val('false');
    $("#btnMostrarRegistro").removeClass('btn-primary');
    $("#btnMostrarRegistro").removeClass('btn-danger');
    $("#btnMostrarRegistro").removeClass('btn-success');
    $("#btnMostrarRegistro").addClass('btn-success');
    $("#btnMostrarSeleccion").removeClass('btn-primary');
    $("#btnMostrarSeleccion").removeClass('btn-danger');
    $("#btnMostrarSeleccion").removeClass('btn-success');
    $("#btnMostrarSeleccion").addClass('btn-danger');
    //console.log("guardando cambios");
    let prov = getDatosNuevo();
    $('#labelMostrarNIT').text(prov.NIT);
    $('#labelMostrarRazonSocial').text(prov.razon_social);
    $('#groupMostrarProv').show();
  }
  function guardarSeleccion(){
    $("#nuevoProveedor").val('false');
    $("#provSelect").val('true');
    $("#btnMostrarRegistro").removeClass('btn-primary');
    $("#btnMostrarRegistro").removeClass('btn-danger');
    $("#btnMostrarRegistro").removeClass('btn-success');
    $("#btnMostrarRegistro").addClass('btn-danger');
    $("#btnMostrarSeleccion").removeClass('btn-primary');
    $("#btnMostrarSeleccion").removeClass('btn-danger');
    $("#btnMostrarSeleccion").removeClass('btn-success');
    $("#btnMostrarSeleccion").addClass('btn-success');
    //console.log("guardando seleccion");
    let prov = getDatosSelect();
    $('#labelMostrarNIT').text(prov.NIT);
    $('#labelMostrarRazonSocial').text(prov.razon_social);
    $('#groupMostrarProv').show();
  }
  function getDatosSelect(){
    var id=$("#proveedor_id").val();
    let option='#option'+id;
    var prov=$(option).text();
    return {
      NIT: prov.split('-')[0],
      razon_social:prov.split('-')[1]
    }
  }
  function getDatosNuevo(){

    return {
      NIT: $("#NIT").val(),
      razon_social: $("#razon_social").val()
    }
  }

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
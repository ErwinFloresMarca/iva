@extends('layouts.app')

@section('content')

<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-success" style="background: rgb(255, 255, 255,0.3)">
              <div class="card-header">
                <h3 class="card-title">Nueva Venta</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('venta.store')}}" method="POST">
                @csrf
                <input type="hidden" name="mes_id" value="{{$mes->id}}">
                <!-- Button trigger modal -->
                
<button id="btnMostrarSeleccion" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalSelect">
  Selecionar Cliente
</button>

<!-- Modal  Select-->
<div class="modal fade" id="modalSelect" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Selecionar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input id="provSelect" type="hidden" name='prooveedorSeleccionado' value='false'>
        <div class="form-group">
                    <label for="mes">Cliente</label>
                    <div class="col">
                        <select id="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror" name="cliente_id" value="{{ old('cliente_id')?old('cliente_id'):'' }}" >
                           @foreach($clientes as $cliente)
                           <option id="option{{$cliente->id}}" value="{{$cliente->id}}">{{$cliente->nit_ci}} - {{$cliente->nombre_rs}}</option>
                           @endforeach
                        </select>
                        @error('cliente_id')
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
  Registrar Cliente
</button>

<!-- Modal nuevo Proveedor-->
<div class="modal fade" id="modalProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input id="nuevoCliente" type="hidden" name='nuevoCliente' value='false'>
                <div class="form-group">
                    <label for="exampleInputEmail1">NIT o CI</label>
                    <div class="col">
                        <input id="nit_ci" type="number" class="form-control @error('nit_ci') is-invalid @enderror" name="nit_ci" value="{{ old('nit_ci') }}"  autocomplete="nit_ci" >
                        @error('nit_ci')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="nombre_rs">Nombre o Razón Social</label>
                    
                    <div class="col">
                        <input id="nombre_rs" type="text" class="form-control @error('nombre_rs') is-invalid @enderror" name="nombre_rs" value="{{ old('nombre_rs') }}" autocomplete="nombre_rs" >

                        @error('nombre_rs')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick='guardarCambiosNuevoCliente()' class="btn btn-primary" data-dismiss="modal">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal-->


                <div class="card-body">
                  <font size='5'>
                  <div id='groupMostrarProv' class="form-group" style="display: none">
                      <label for="">NIT o CI: </label> <label id="labelnit_ci"></label><br>
                      <label for="">Nombre o Razon Social: </label> <label id="labelnombre_rs"></label>
                  </div>
                  </font>
                    <div class="form-group">
                      <label for="especificacion">Especificación</label>
                      <div class="col">
                          <input type="number" readonly name="especificacion" id="especificacion" class="form-control @error('especificacion') is-invalid @enderror" value="{{ old('especificacion')?old('especificacion'): '3' }}">
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
                      <label for="fecha">Fecha</label>
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
                      <label for="estado">Estado</label>
                      <div class="col">
                          <select id="estado" class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ old('estado')?old('estado'): 1 }}" required >
                            <option value="1">Verificado</option>  
                            <option value="0">Anulado</option>
                          </select> 
                          @error('estado')
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
                          <input id="cod_control" type="text" class="form-control @error('cod_control') is-invalid @enderror" name="cod_control" value="{{ old('cod_control') }}"  >
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
  function guardarCambiosNuevoCliente(){
    $("#nuevoCliente").val('true');
    $("#clienteSelect").val('false');
    $("#btnMostrarRegistro").removeClass('btn-primary');
    $("#btnMostrarRegistro").removeClass('btn-danger');
    $("#btnMostrarRegistro").removeClass('btn-success');
    $("#btnMostrarRegistro").addClass('btn-success');
    $("#btnMostrarSeleccion").removeClass('btn-primary');
    $("#btnMostrarSeleccion").removeClass('btn-danger');
    $("#btnMostrarSeleccion").removeClass('btn-success');
    $("#btnMostrarSeleccion").addClass('btn-danger');
    //console.log("guardando cambios");
    let cliente = getDatosNuevo();
    $('#labelnit_ci').text(cliente.nit_ci);
    $('#labelnombre_rs').text(cliente.nombre_rs);
    $('#groupMostrarProv').show();
  }
  function guardarSeleccion(){
    $("#nuevoCliente").val('false');
    $("#clienteSelect").val('true');
    $("#btnMostrarRegistro").removeClass('btn-primary');
    $("#btnMostrarRegistro").removeClass('btn-danger');
    $("#btnMostrarRegistro").removeClass('btn-success');
    $("#btnMostrarRegistro").addClass('btn-danger');
    $("#btnMostrarSeleccion").removeClass('btn-primary');
    $("#btnMostrarSeleccion").removeClass('btn-danger');
    $("#btnMostrarSeleccion").removeClass('btn-success');
    $("#btnMostrarSeleccion").addClass('btn-success');
    //console.log("guardando seleccion");
    let cliente = getDatosSelect();
    $('#labelnit_ci').text(cliente.nit_ci);
    $('#labelnombre_rs').text(cliente.nombre_rs);
    $('#groupMostrarProv').show();
  }
  function getDatosSelect(){
    var id=$("#cliente_id").val();
    let option='#option'+id;
    var prov=$(option).text();
    return {
      nit_ci: prov.split('-')[0],
      nombre_rs:prov.split('-')[1]
    }
  }
  function getDatosNuevo(){

    return {
      nit_ci: $("#nit_ci").val(),
      nombre_rs: $("#nombre_rs").val()
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
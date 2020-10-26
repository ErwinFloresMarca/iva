@extends('layouts.app')

@section('content')

<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Nuevo Proveedor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('proveedor.store')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">NIT</label>
                    <div class="col">
                        <input id="NIT" type="number" class="form-control @error('NIT') is-invalid @enderror" name="NIT" value="{{ old('NIT') }}" required autocomplete="NIT" >
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
                        <input id="razon_social" type="text" class="form-control @error('razon_social') is-invalid @enderror" name="razon_social" value="{{ old('razon_social') }}" required autocomplete="razon_social" >

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
                        <input id="nro_autorizacion" type="number" class="form-control @error('nro_autorizacion') is-invalid @enderror" name="nro_autorizacion" value="{{ old('nro_autorizacion') }}" autocomplete="nro_autorizacion" >
                        @error('nro_autorizacion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </form>
            </div>
</div>
</div>

@endsection
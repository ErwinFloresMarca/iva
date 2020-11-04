@extends('layouts.app')

@section('body_options')
background='{{asset("img/agricultor1.jpg")}}' style='background-size: cover;'
@endsection

@section('content')

<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-success" style="background: rgb(255, 255, 255,0.5)">
              <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('cliente.store')}}" method="POST">
                @csrf
                <div class="card-body ">
                  <div class="form-group">
                    <label for="nit_ci">CI o NIT</label>
                    <div class="col">
                        <input id="nit_ci" type="number" class="form-control @error('nit_ci') is-invalid @enderror" name="nit_ci" value="{{ old('nit_ci') }}" autocomplete="nit_ci" >
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
                        <input id="nombre_rs" type="text" class="form-control @error('nombre_rs') is-invalid @enderror" name="nombre_rs" value="{{ old('nombre_rs') }}" required autocomplete="nombre_rs" >

                        @error('nombre_rs')
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
                            <div class='row justify-content-end'>
                            <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                           
                        </div>
                        <div class='col-2'></div>
                        </form>
                        <div class="col-5">
                            <a href="{{route('cliente.index')}}" class='btn btn-danger'>Cancelar</a>
                        </div>  
                </div>
              
            </div>
</div>
</div>

@endsection
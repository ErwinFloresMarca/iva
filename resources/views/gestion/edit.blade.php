@extends('layouts.app')

@section('content')
<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-warning">
              <div class="card-header">
                <h3 class="">Editar Gestion</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('gestion.update',$gestion)}}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="gestion">gestion</label>
                    <div class="col">
                        <input id="gestion" type="number" min="1900" max="2099" class="form-control @error('gestion') is-invalid @enderror" name="gestion" value="{{ (old('gestion'))?old('gestion') :$gestion->gestion }}" required autocomplete="gestion" >
                        @error('gestion')
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
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                           
                        </div>
                        <div class='col-2'></div>
                        </form>
                        <div class="col-5">
                            <a href="{{route('gestion.index')}}" class='btn btn-danger'>Cancelar</a>
                        </div>
                        
                    
                  </div>
                  
                </div>
              
            </div>
</div>
</div>

@endsection
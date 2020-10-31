@extends('layouts.app')

@section('body_options')
background='{{asset("img/general.jpg")}}' style='background-size: cover;'
@endsection

@section('content')

<div class='row justify-content-center'>
<div class="col-sm-6">
        <div class="card card-primary" style="background: rgb(255, 255, 255,0.5)">
              <div class="card-header">
                <h3 class="card-title">Nuevo Mes</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('mes.store')}}" method="POST">
                @csrf
                <input type="hidden" name="gestion_id" value="{{$gestion->id}}">
                <div class="card-body">
                  <div class="form-group">
                    <label for="mes">Mes</label>
                    <div class="col">
                        <select id="mes" class="form-control @error('mes') is-invalid @enderror" name="mes" value="{{ old('mes') }}" required >
                            @php
                                $list_meses=['ENERO'=>true,'FEBRERO'=>true,'MARZO'=>true,'ABRIL'=>true,'MAYO'=>true,'JUNIO'=>true,
                                             'JULIO'=>true,'AGOSTO'=>true,'SEPTIEMBRE'=>true,'OCTUBRE'=>true,'NOVIEMBRE'=>true,'DICIEMBRE'=>true ];
                                foreach($gestion->meses as $current_mes)
                                    $list_meses[$current_mes->mes]=false;
                                
                                    
                            @endphp
                            @foreach($list_meses as $key => $value)
                            @if($value)
                            <option value="{{$key}}">{{$key}}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('mes')
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
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            
                        </div>
                        <div class="col-2"></div>

                        </form>
                        <div class="col-5">
                            <a href="{{route('mes.gestion',$gestion)}}" class='btn btn-danger'>Cancelar</a>
                        </div>
                    </div>
                  



                </div>
             
            </div>
</div>
</div>

@endsection
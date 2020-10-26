@extends('layouts.app')

@section('content')
<div>
    <a href="{{route('cliente.create')}}" class="btn btn-success">
    
    <i class="fas fa-file"></i> Nuevo
    </a>
    
    <br>
    <table  class="table">
            <thead>
            <tr>
              <th>CI o NIT</th>
              <th>Nombre o Razón Social</th>
              <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clientes as $cliente)
            <tr>
                <td>{{$cliente->nit_ci}}</td>
                <td>{{$cliente->nombre_rs}}</td>
                <td>
                <div class="row">
                    <div clas='col-sm-5'>
                        <div class='row justify-content-center'>
                            <a href="{{route('cliente.edit',$cliente)}}" class="btn btn-warning ">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div clas='col-sm-5'>
                    <div class='row justify-content-center'>
                        <form action="{{route('cliente.destroy',$cliente)}}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                            
                            <button type="submit" class="btn btn-danger" ><i class="fas fa-trash"></i> Eliminar</button>
                        </form>
                            
                        </div>
                    </div>
                </div>
                 </td>
            </tr>
            @endforeach
            </tbody>
    </table>
    
</div>

@endsection
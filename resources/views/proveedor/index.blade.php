@extends('layouts.app')

@section('content')
<div>
    <a href="{{route('proveedor.create')}}" class="btn btn-success">
    
    <i class="fas fa-file"></i> Nuevo
    </a>
    
    <br>
    <table  class="table">
            <thead>
            <tr>
              <th>NIT</th>
              <th>Razón Social</th>
              <th>Nro. de Autorizacion</th>
              <th>Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($proveedores as $proveedor)
            <tr>
                <td>{{$proveedor->NIT}}</td>
                <td>{{$proveedor->razon_social}}</td>
                <td>{{$proveedor->nro_autorizacion}}</td>
                <td>
                <div class="row">
                    <div clas='col-sm-5'>
                        <div class='row justify-content-center'>
                            <a href="{{route('proveedor.edit',$proveedor)}}" class="btn btn-warning ">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div clas='col-sm-5'>
                    <div class='row justify-content-center'>
                        <form action="{{route('proveedor.destroy',$proveedor)}}" method="POST">
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
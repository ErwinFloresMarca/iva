@extends('layouts.app')

@section('content')
<div>
    <div class="row justify-content-center">
        <h1 style="font-family: Stencil">GESTION {{$gestion->gestion}}</h1>

    </div>
    
    <div class='row justify-content-center'>
            
        <div class="col-sm-6">
            
            <a href="{{route('mes.create.mes',$gestion)}}" class="btn btn-success">
        
            <i class="fas fa-folder-open"></i> Nueva Mes
            </a>
            
        
            <br>
            <br>
            <table  class="table align-content-center">
                <thead>
                   
                <tr>
                    <th class="text-center"> <h3>Mes</h3> </th>
                    <th class="text-center"> <h3>Registros</h3> </th>
                    <th class="text-center"> <h3>Opciones</h3> </th>
                </tr>
                    
                </thead>
                <tbody>
                @foreach ($gestion->meses as $mes)
                <tr class="text-center">
                    <td>
                        <div class=" alert-light" role="alert">
                        <i class="fas fa-folder-open"></i>{{$mes->mes}}
                        </div>

                             
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-5">
                                <div class="row justify-content-end">
                                <a href="{{route('compra.mes',$mes)}}" class="btn btn-sm btn-outline-primary">
                                    COMPRAS
                                </a>
                                </div>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-5">
                                <div class="row justify-content-start">
                                <a href="{{route('compra.mes',$mes)}}" class="btn btn-sm btn-outline-primary">
                                    VENTAS
                                </a>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                    <div class="row justify-content-center">
                        
                        
                        <div clas='col-4'>
                       
                            <form action="{{route('mes.destroy',$mes->id)}}" method="POST" onSubmit="return confirm('Esta seguro de que quiere Eliminar la Mes?');">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                               
                                <button type="submit" class="btn btn-danger" ><i class="fas fa-trash"></i> Eliminar</button>
                            
                            </form>                    
                        </div>
                    </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
</div>

@endsection
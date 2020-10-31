@extends('layouts.app')
@section('body_options')
background='{{asset("img/archivos.jpg")}}' style='background-size: cover;'
@endsection
@section('content')
<div>
    
    <div class='row justify-content-center'>
        <div class="col-sm-6">
            <a href="{{route('gestion.create')}}" class="btn btn-success">
        
            <i class="fas fa-folder-open"></i> Nueva Gestion
            </a>
            
        
            <br>
            <br>
            <table  class="table" style="background: rgb(255, 255, 255,0.5)">
                <thead>
                <tr>
                <th>Gestion</th>
                <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($gestiones->sortByDesc('gestion') as $gestion)
                <tr>
                    <td>
                        <a href="{{route('mes.gestion',$gestion)}}" class="btn btn-lg btn-light">
                            <i class="fas fa-folder-open"></i>{{$gestion->gestion}}
                        </a>
                        
                    </td>
                    
                    <td>
                    <div class="row">
                        <div clas='col-sm-5'>
                            <div class='row justify-content-center'>
                                <a href="{{route('gestion.edit',$gestion)}}" class="btn btn-warning ">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </div>
                        </div>
                        <div class="col-2"></div>
                        <div clas='col-sm-5'>
                        <div class='row justify-content-center'>
                            <form action="{{route('gestion.destroy',$gestion)}}" method="POST" onSubmit="return confirm('Esta seguro de que quiere Eliminar la Gestion?');">
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
    </div>
    
    
</div>

@endsection
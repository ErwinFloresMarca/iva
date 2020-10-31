@extends('layouts.app')

@section('body_options')
background='{{asset("img/proveedor.jpg")}}' style='background-size: cover;'
@endsection

@section('content')
<div id="app">
    <a href="{{route('proveedor.create')}}" class="btn btn-success">
    
    <i class="fas fa-file"></i> Nuevo
    </a>
    
    <br>
    <table  class="table" style="background: rgb(255, 255, 255,0.5)">
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
                <td>
                    @php
                        $autorizacion=App\Autorizacion::obtenerNroAutorizacion($proveedor->id,App\Gestion::ultimaGestion()->id);
                    @endphp
                    @if($autorizacion)
                    {{$autorizacion->nro_autorizacion}}
                    @else
                    <template v-if="autorizaciones[{{$proveedor->id}}]">
                    <input type="text" v-model="autorizaciones[{{$proveedor->id}}]" readonly width="100%" style="border: 0px">
                    </template>
                    <template v-else>
                    <button @click="registrar({{$proveedor->id}})" class="btn btn-danger">Registar Para Esta Gestion</button>
                    </template>
                    @endif
                </td>
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
    
    <div :class="{modal: true, fade: true, show: showForm }" :style="'display: '+((showForm)? 'block': 'none') " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" :aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Autorizacion</h5>
                <button @click="showForm=false" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Numero de Autorizacion</label>
                    <input type="number" v-model="nuevaAutorizacion.nro_autorizacion" class="form-control" placeholder="introduzca numero de autorizacion">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="showForm=false">Close</button>
                <button type="button" class="btn btn-primary" @click="enviar">Guardar Cambios</button>
            </div>
            </div>
        </div>
    </div>

</div>
<script>
    new Vue({
        el: '#app',
        data () {
            return {
                gestion: {!! json_encode(App\Gestion::ultimaGestion()) !!},
                nuevaAutorizacion:{},
                showForm: false,
                autorizaciones:[],
            }
        },
        computed: {},
        methods: {
            registrar(proveedor_id){
                this.showForm=true;
                this.nuevaAutorizacion={};
                this.nuevaAutorizacion.proveedor_id=proveedor_id;
                this.nuevaAutorizacion.gestion_id=this.gestion.id;
            },
            enviar(){
                const app=this;
                axios.post('/api/autorizaciones',this.nuevaAutorizacion).then((data)=>{
                    app.autorizaciones[app.nuevaAutorizacion.proveedor_id]=data.data.autorizacion.nro_autorizacion;
                    app.showForm=false;
                    app.mensageSuccess('Registrado','Autorizacion registrada!!!!');
                }).catch((err)=>{
                    console.error(err);
                });
            },
            mensageSuccess(titulo,mensaje){
              toastr.options = {"closeButton":false,"debug":false,"newestOnTop":false,"progressBar":false,"positionClass":"toast-top-right","preventDuplicates":false,"onclick":null,"showDuration":"300","hideDuration":"1000","timeOut":"5000","extendedTimeOut":"1000","showEasing":"swing","hideEasing":"linear","showMethod":"fadeIn","hideMethod":"fadeOut"};
              toastr.success(mensaje,titulo);
            },
        }
    });
</script>
@endsection
@extends('layouts.app')

@section('body_options')
background='{{asset("img/proveedor.jpg")}}' style='background-size: cover;'
@endsection

@section('content')
<div class='row justify-content-center' id="app">
<div class="col-sm-6">
        <div class="card card-warning" style="background: rgb(255, 255, 255,0.5)">
              <div class="card-header">
                <h3 class="">Editar Proveedor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('proveedor.update',$proveedor)}}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">NIT</label>
                    <div class="col">
                        <input id="NIT" type="number" class="form-control @error('NIT') is-invalid @enderror" name="NIT" value="{{ (old('NIT'))?old('NIT') :$proveedor->NIT }}" required autocomplete="NIT" >
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
                        <input id="razon_social" type="text" class="form-control @error('razon_social') is-invalid @enderror" name="razon_social" value="{{ (old('razon_social'))? old('razon_social'): $proveedor->razon_social }}" autocomplete="razon_social" >

                        @error('razon_social')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <label for="nro_autorizacion">Numeros de Autorización</label>
                    <div class="col">
                        <table width="100%" height="100px">
                            <thead>
                                <tr>
                                    <th width="20%">
                                        Gestion
                                    </th>
                                    <th width="46%">
                                        Nro. Autorizacion
                                    </th>
                                    <th width="34%">
                                        Opciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(autorizacion, index) in autorizaciones" :key="'auth'+index">
                                    <td>
                                        @{{ autorizacion.gestion.gestion }}
                                    </td>
                                    <td>
                                        <template v-if="!autorizacion.edit">
                                            @{{ autorizacion.nro_autorizacion }}
                                        </template>
                                        <template v-else>
                                            <el-input v-model="autorizacion.nro_autorizacion" icon="el-icon-edit">
                                                <template slot="prepend"><i class="el-icon-edit"></i></template>
                                            </el-input>
                                        </template>
                                    </td>
                                    <td>
                                        <a v-if="!autorizacion.edit" 
                                            class="btn btn-warning"
                                            @click="edit(index)" 
                                        >
                                            Editar
                                        </a>
                                        <a v-else class="btn btn-success" @click="guardar(index)">Guardar</a>
                                        <a class="btn btn-danger" @click="eliminar(index)">eliminar</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                            <a href="{{route('proveedor.index')}}" class='btn btn-danger'>Cancelar</a>
                        </div>
                        
                    
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
                autorizaciones:{!!json_encode(App\Autorizacion::with('gestion')->where('proveedor_id',$proveedor->id)->get())!!},
            }
        },
        computed: {},
        methods: {
            recargar(){
                const aux=this.autorizaciones;
                this.autorizaciones={};
                this.autorizaciones=aux;
            },
            guardar(index){
                const app=this;
                axios.put('/api/autorizaciones/'+this.autorizaciones[index].id ,this.autorizaciones[index]).then((data)=>{
                    app.autorizaciones[index]=data.data.autorizacion;
                    app.recargar();
                    app.mensageSuccess('Actualizado','Autorizacion altualizada!!!!');
                }).catch((err)=>{
                    console.error(err);
                });
            },
            edit(index){
                this.autorizaciones[index].edit=true;
                this.recargar();
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
            eliminar(index){
                const id=this.autorizaciones[index].id;
                const app=this;
                axios.delete('/api/autorizaciones/'+id).then((data)=>{
                    app.autorizaciones.splice(index,1);
                    app.recargar();
                    app.mensageSuccess('Eliminado','Autorizacion eliminada!!!!');
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
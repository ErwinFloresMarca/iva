@extends('layouts.app')

@section('scripts')
<script>
const app=new Vue({
    el: '#app',
    data(){
        return {
            imageUrl: '',
            tabAuthData:[],
            proveedor: {!! (Auth::user()->proveedor)? Auth::user()->proveedor : 'null' !!},
            editProveedor: false,
            provErrors: {},
            avatar:{!! Auth::user()->avatar? '"'.Illuminate\Support\Facades\Storage::url(Auth::user()->avatar->url).'"': 'null' !!},
            user: {!! Auth::user() !!},
            editUser: false,
            userErrors: {},
            nuevoProv: {},
            autorizaciones: {!! (Auth::user()->proveedor)? Auth::user()->proveedor->autorizaciones : 'null' !!},
            showFormProveedor: false,
            error: {},
            gestiones: {!! json_encode(App\Gestion::all()) !!},
            showForm: false,
            nuevaAutorizacion: {},
            numeroDeAuthorizacion: {!! (Auth::user()->proveedor)? ( App\Autorizacion::obtenerNroAutorizacion(Auth::user()->proveedor->id,App\Gestion::ultimaGestion()->id)? App\Autorizacion::obtenerNroAutorizacion(Auth::user()->proveedor->id,App\Gestion::ultimaGestion()->id): 'null' ) : 'null' !!},
        };
    },
    created(){
        this.loadTabAuths();
        if(this.avatar){
            this.imageUrl = this.avatar;
        }
    },
    methods: {
        handleAvatarSuccess(res, file) {
            this.$message({
                message:'imagen subida exitosamente',
                type:'success',
                showClose:true,
            })
            this.imageUrl = URL.createObjectURL(file.raw);
        },
        beforeAvatarUpload(file) {
            const isLt2M = file.size / 1024 / 1024 < 2;

            if (!isLt2M) {
            this.$message.error('La imagen excede los 2MB!');
            }
            return isLt2M;
        },
        
        saveUser(){
            const app=this;
            axios.put('/api/user/'+this.user.id,this.user).then((data)=>{
                app.user=data.data.user;
                app.editUser=false;
                this.userErrors = {};
                app.mensageSuccess('Actualizado','Informacion actualizada!!!!');
            }).catch((err)=>{
                this.userErrors = {};
                if(err.request){
                    let errors = JSON.parse(err.request.response).errors;
                    this.userErrors = errors;
                    if(this.userErrors==null)
                        this.userErrors = {};
                }
            });
        },
        eliminarAuth(index){
            const app=this;
            var auth = this.tabAuthData[index];
            axios.delete('/api/autorizaciones/'+auth.autorizacion_id).then((data)=>{
                let auts=[];
                for(let i=0;i<app.autorizaciones.length;i++){
                    if(auth.autorizacion_id!=app.autorizaciones[i].id){
                        auts.push(app.autorizaciones[i]);
                    }
                }
                app.autorizaciones=auts;
                app.mensageSuccess('Eliminado','Autorizacion Eliminado!!!!');
                app.loadTabAuths();
            }).catch((err)=>{
                console.error(err);
            });
        },
        saveAuth(index){
            const app=this;
            var auth = this.tabAuthData[index];
            auth.proveedor_id=this.proveedor.id;
            if(auth.autorizacion_id){
                axios.put('/api/autorizaciones/'+auth.autorizacion_id,auth).then((data)=>{
                    
                    app.mensageSuccess('Actualizado','Autorizacion Actualizada!!!!');
                    app.loadTabAuths();
                }).catch((err)=>{
                    this.$message({
                        type: 'error',
                        message: 'Este numero de autorizacion ya se encuentra registrado.',
                        showClose:true,
                    })
                    console.error(err);
                });
            }
            else{
                axios.post('/api/autorizaciones',auth).then((data)=>{
                    app.autorizaciones.push(data.data.autorizacion);
                    app.loadTabAuths();
                    app.mensageSuccess('Registrado','Autorizacion registrada!!!!');
                }).catch((err)=>{
                    this.$message({
                        type: 'error',
                        message: 'Este numero de autorizacion ya se encuentra registrado.',
                        showClose:true,
                    })
                    console.error(err);
                });
            }
        },
        mensageSuccess(titulo,mensaje){
            toastr.options = {"closeButton":false,"debug":false,"newestOnTop":false,"progressBar":false,"positionClass":"toast-top-right","preventDuplicates":false,"onclick":null,"showDuration":"300","hideDuration":"1000","timeOut":"5000","extendedTimeOut":"1000","showEasing":"swing","hideEasing":"linear","showMethod":"fadeIn","hideMethod":"fadeOut"};
            toastr.success(mensaje,titulo);
        },
        loadTabAuths(){
            this.tabAuthData=this.getDataAuths();
        },
        getDataAuths(){
            var data = [];
            for(let j = 0;j<this.gestiones.length;j++){
                let insert=false;
                for(let i = 0;i<this.autorizaciones.length;i++){
                    if(this.autorizaciones[i].gestion_id==this.gestiones[j].id){
                        data.push({
                            gestion: this.gestiones[j].gestion,
                            nro_autorizacion: this.autorizaciones[i].nro_autorizacion,
                            autorizacion_id: this.autorizaciones[i].id,
                            edit: false,
                            gestion_id: this.gestiones[j].id
                        });
                        insert=true;
                    }
                }
                if(!insert){
                    data.push({
                            gestion: this.gestiones[j].gestion,
                            nro_autorizacion: null,
                            autorizacion_id: null,
                            edit: false,
                            gestion_id: this.gestiones[j].id
                        }); 
                }
            }
        
            return data;
        },
        saveProveedor(){
            this.nuevoProv.userId = this.user.id,
            axios.put('/api/proveedor/'+this.proveedor.id,this.proveedor).then((data)=>{
                this.proveedor = data.data.proveedor;
                this.$message({
                    message: "Informacion Registrada",
                    type: 'success',
                    showClose: true,
                });
                this.provErrors = {};
                this.editProveedor = false ;
            }).catch((error)=>{
                this.provErrors = {};
                if(error.request){
                    let errors = JSON.parse(error.request.response).errors;
                    this.provErrors = errors;
                    if(this.provErrors==null)
                        this.provErrors = {};
                }
                 
                this.$message({
                    message: error.toString(),
                    type: "error",
                    showClose: true
                });
            });
        },
    },
});
</script>
@endsection

@section('content')
<style>
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>

<div id="app" >
    <el-row :gutter="20" >
        <el-col :span="12" :offset="0">
        <h1 style="font-family: 'Franklin Gothic Medium'">USUARIO <el-button v-if="!editUser" type="warning" size="small" @click="editUser=true" icon="el-icon-edit" circle></el-button></h1>
        <br>
        <el-row type='flex' justify='center'>
        <el-upload
            class="avatar-uploader"
            :action="'/api/user/upload_avatar/'+user.id"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload">
            <img v-if="imageUrl" :src="imageUrl" class="avatar">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
        </el-row>
        
        <el-form :model="user" ref="userForm" label-width="160px" :inline="false" size="normal">
            <el-form-item label="Usuario" size="normal">
                <el-input v-model="user.username" placeholder="nombre de usuario" size="normal" :readonly="true"></el-input>
            </el-form-item>
            <el-form-item label="Nombre de usuario" size="normal" :error="userErrors.name? userErrors.name[0]: null">
                <el-input v-model="user.name" placeholder="nombre de usuario" size="normal" :readonly="!editUser"></el-input>
            </el-form-item>
            <el-form-item label="Email" size="normal" :error="userErrors.email? userErrors.email[0]: null">
                <el-input v-model="user.email" placeholder="correo electronico" size="normal" :readonly="!editUser"></el-input>
            </el-form-item>
            <el-form-item v-if="editUser" label="Contraseña" size="normal" :error="userErrors.password? userErrors.password[0]: null">
                <el-input v-model="user.password" type='password' placeholder="deje vacio si no desea cambiarlo" size="normal" :readonly="!editUser"></el-input>
            </el-form-item>
            <el-form-item v-if="editUser">
                <el-button type="primary" @click="saveUser">Guardar</el-button>
                <el-button @click="editUser=!editUser" type="danger">Cancelar</el-button>
            </el-form-item>
        </el-form>
        
        </el-col>
        <el-col :span="12" :offset="0">
        <h1 style="font-family: 'Franklin Gothic Medium'">INSTITUCION <el-button v-if="!editProveedor" type="warning" size="small" @click="editProveedor=true" icon="el-icon-edit" circle></el-button>
        </h1>
        <br>
        <el-form :model="proveedor" ref="formProveedor" label-width="100px" :inline="false" size="normal">
            <el-form-item label="NIT" :error="provErrors.NIT? provErrors.NIT[0]: null">
                <el-input v-model="proveedor.NIT" :readonly="!editProveedor"></el-input>
            </el-form-item>
            <el-form-item label="Razón social" :error="provErrors.razon_social? provErrors.razon_social[0]: null">
                <el-input v-model="proveedor.razon_social" :readonly="!editProveedor"></el-input>
            </el-form-item>
            <el-form-item v-if='editProveedor'>
                <el-button type="primary" @click="saveProveedor">Guardar</el-button>
                <el-button  @click="editProveedor=!editProveedor" type="danger">Cancelar</el-button>
            </el-form-item>
        </el-form>
        <h3 style="font-family: 'Franklin Gothic Medium'">Numeros de Autorizacion</h3>
        <el-table :data="getDataAuths()" border stripe max-height='170px'>
            <el-table-column 
                :prop="'gestion'"
                :key="'gestion'"
                label="Gestion">
            </el-table-column>
            <el-table-column 
                label="Nro. Autorizacion">
                <template slot-scope="scope">
                    <template v-if="tabAuthData[scope.$index].edit">
                        <el-input type='number' v-model="tabAuthData[scope.$index].nro_autorizacion" placeholder="Nro. Autorizacion" size="normal" ></el-input>
                    </template>
                    <template v-else>
                        @{{tabAuthData[scope.$index].nro_autorizacion}}
                    </template>
                </template>
            </el-table-column>
            <el-table-column
                label="Opciones">
                <template slot-scope="scope">
                    <template v-if="tabAuthData[scope.$index].edit">
                        <el-button type="default" size="small" @click="saveAuth(scope.$index)" icon="el-icon-s-claim" circle></el-button>
                    </template>
                    <template v-else>
                        <template v-if='tabAuthData[scope.$index].nro_autorizacion'>
                            <el-button type="warning" size="small" @click="tabAuthData[scope.$index].edit=true" icon="el-icon-edit" circle></el-button>
                            <el-button type="danger" size="small" @click="eliminarAuth(scope.$index)" icon="el-icon-delete" circle></el-button>
                        </template>
                        <template v-else>
                            <el-button type="success" size="small" @click="tabAuthData[scope.$index].edit=true" icon="el-icon-plus" circle></el-button>
                        </template>
                    </template>
                </template>
            </el-table-column>
        </el-table>
        
        </el-col>
        
    </el-row>
</div>
@endsection
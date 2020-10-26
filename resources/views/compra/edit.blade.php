@extends('layouts.app')

@section('content')
<div class='row justify-content-center' id="app">
  <div class="col-sm-6">
    <div class="card card-warning" style="background: rgb(255, 255, 255,0.3)">
      <div class="card-header">
        <h3 class="">Editar Compra</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{route('compra.update',$compra->id)}}" method="POST">

        @csrf
        <input type="hidden" name="mes_id" value="{{$mes->id}}">
        <input type="hidden" name="_method" value="PUT">
        <!-- Button trigger modal -->


        <div class="card-body">
          <div class="form-group">
            <label for="mes">Proveedor</label>
            <div class="col">
              <input v-bind:value="proveedor_id" type="hidden" name="proveedor_id">
              <el-select v-model="proveedor_id" filterable placeholder="Seleccione Proveedor">
                <el-option
                  v-for="item in proveedores"
                  :key="'prov-'+item.id"
                  :label="item.NIT+' - '+item.razon_social"
                  :value="item.id">
                </el-option>
              </el-select>
              @error('proveedor_id')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
              <template v-if="!tieneNroAutorizacion&&(proveedor_id)">
                <div class="alert alert-danger" role="alert">
                  <strong>Este proveedor no cuenta con un numero de autorizacion para esta Gestion!!!</strong>
                </div>
                <a @click="registrar(prov.id)" class="btn btn-danger" style="color: white">Registar Nro de Autorización</a>
              </template>
            </div>
          </div>
          <div class="form-group">
            <label for="especificacion">Especificación</label>
            <div class="col">
              <select name="especificacion" id="especificacion" class="form-control @error('especificacion') is-invalid @enderror" value="{{ old('especificacion')?old('especificacion'): $compra->especificacion }}">
                <option value="1">Local</option>
                <option value="2">Nacional</option>
                <option value="3">Inter Nacional</option>
              </select>
              @error('especificacion')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Fecha</label>
              <div class="col">
                <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" value="{{ old('fecha')?old('fecha'): $compra->fecha }}" required autocomplete="fecha">
                @error('fecha')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="razon_social">Numero de Factura</label>

              <div class="col">
                <input id="nro_factura" type="number" class="form-control @error('nro_factura') is-invalid @enderror" name="nro_factura" value="{{ old('nro_factura')? old('nro_factura'):$compra->nro_factura }}" required>

                @error('nro_factura')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

            </div>

            <div class="form-group">
              <label for="nro_autorizacion">Importe</label>
              <div class="col">
                <input id="importe" type="number" step=".01" class="form-control @error('importe') is-invalid @enderror" name="importe" value="{{ old('importe')?old('importe') :$compra->importe }}" required>
                @error('importe')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="razon_social">Codigo de Control</label>

              <div class="col">
                <input id="cod_control" type="text" class="form-control @error('cod_control') is-invalid @enderror" name="cod_control" value="{{ old('cod_control')? old('cod_control'):$compra->cod_control }}">
                @error('cod_control')
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
                <div class="row justify-content-end">
                  <button type="submit" class="btn btn-success">Guardar</button>
                </div>
              </div>
              <div class="col-2"></div>
      </form>
              <div class="col-5">
                <a href="{{route('compra.mes',$mes)}}" class='btn btn-danger'>Cancelar</a>
              </div>
            </div>
          </div>
        </div>
        <!-- modal registrar numero de autorizacion -->
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
        <!-- end modal registrar -->
    </div>
  </div>
</div>

<script>
  new Vue({
    el: '#app',
    data() {
      return {
        gestion: {!!json_encode($mes->gestion) !!},
        nuevaAutorizacion: {},
        showForm: false,
        autorizaciones: [],
        proveedores: {!!json_encode(App\Proveedor::with('autorizaciones')->get()) !!},
        proveedor_id: {{ old('proveedor_id')?old('proveedor_id'):$compra->proveedor_id }},
        prov: {},
        tieneNroAutorizacion: false,
      }
    },
    watch: {
      proveedor_id: function(newVal, oldVal) {
        this.tieneNroAutorizacion = false;
        const app = this;
        this.prov = this.proveedores.filter((proveedor) => {
          return (proveedor.id === parseInt(newVal))
        })[0];
        if ((this.prov.autorizaciones.filter((auth) => {
            return (auth.gestion_id === app.gestion.id)
          })).length > 0) {
          this.tieneNroAutorizacion = true;
        }
      },
    },
    computed: {},
    created(){
      this.tieneNroAutorizacion = false;
      const app = this;
      this.prov = this.proveedores.filter((proveedor) => {
        return (proveedor.id === parseInt(this.proveedor_id))
      })[0];
      if ((this.prov.autorizaciones.filter((auth) => {
          return (auth.gestion_id === app.gestion.id)
        })).length > 0) {
        this.tieneNroAutorizacion = true;
      }
    },
    methods: {
      registrar(proveedor_id) {
        this.showForm = true;
        this.nuevaAutorizacion = {};
        this.nuevaAutorizacion.proveedor_id = proveedor_id;
        this.nuevaAutorizacion.gestion_id = this.gestion.id;
        console.log("registrar");
      },
      enviar() {
        const app = this;
        axios.post('/api/autorizaciones', this.nuevaAutorizacion).then((data) => {
          app.proveedores[app.proveedores.indexOf(app.prov)].autorizaciones.push(data.data.autorizacion)
          app.prov.autorizaciones.push(data.data.autorizacion);
          app.tieneNroAutorizacion = true;
          app.showForm = false;
          app.mensageSuccess('Registrado','Autorizacion registrada para '+app.prov.razon_social+'!!!!');
        }).catch((err) => {
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

@section('scripts')
<script>
  $('#cod_control').keyup(onChangeText);

  function onChangeText() {

    var cod = $('#cod_control').val();

    switch (cod.length) {

      case 12:
        if (cod.charAt(cod.length - 1) != '-') {
          cod = cod.substring(0, 11) + '-' + cod.substring(11, 12);
          $('#cod_control').val(cod);
          break;
        }

        default:
          if (cod.length > 14) {
            cod = cod.substring(0, 14);
            $('#cod_control').val(cod);
          }
          if (cod.length < 11) {
            let grupos = cod.split('-');
            if (grupos[grupos.length - 1].length == 2) {
              cod = cod + '-';
              $('#cod_control').val(cod);
            }
          }

    }
  }
</script>
@endsection
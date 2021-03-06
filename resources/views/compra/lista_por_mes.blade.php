@extends('layouts.app')

@section('scripts')
<script>
const app=new Vue({
    el: '#app',
    data(){
        return {
            authsNumevos: [],
            gestion: {!! json_encode($mes->gestion) !!},
            nuevaAutorizacion:{},
            showForm: false,
        };
    },
    methods: {

        registrarNumAuth(id){
            this.showForm=true;
            this.nuevaAutorizacion={};
            this.nuevaAutorizacion.proveedor_id=id;
            this.nuevaAutorizacion.gestion_id=this.gestion.id;
        },

        enviar(){
            const app=this;
            axios.post('/api/autorizaciones',this.nuevaAutorizacion).then((data)=>{
                app.authsNumevos[app.nuevaAutorizacion.proveedor_id]=data.data.autorizacion.nro_autorizacion;
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
    },
});  
</script>
@endsection

@section('content')
<style>
    th {
        border-color: black;
    }
</style>
<div id="app">
    
    <div class="row justify-content-center"  style="font-family: Stencil">
        <h1>GESTION {{$mes->gestion->gestion}} / {{$mes->mes}}</h1>

    </div>
    
    <div class='row justify-content-center'>
            
        <div class="col-12">
            
            <div class="row">
                <div class="col-6">
                <a href="{{route('compra.create.mes',$mes)}}" class="btn btn-success">
                    <i class="fas fa-folder-open"></i> Nueva Compra
                </a>
                </div>
                <div class="col-5 ">
                <div class="row justify-content-end">
                   <a href="{{route('compra.excel',$mes->id)}}" class="btn btn-success"> GENERAR EXCEL</a> &nbsp; <a href="{{route('compra.pdf.carta',$mes->id)}}" class="btn btn-danger"> GENERAR PDF CARTA</a> 
                </div>
                <div class="col"></div>
            </div>
            @php 
                function getWhitTwooDecimals($number){
                    $number=round($number, 2);
                    $vals=explode('.',''.$number);
                    if(isset($vals[1])){
                        if(strlen($vals[1])==2)
                            return ''.$number;
                        else
                            return ''.$number.'0';
                    }
                    else
                        return ''.$number.'.00';
                }
                use App\utils;
           @endphp
    
            <br>
            <table width="100%" border=2>
                <thead style="background: #149916" border = '2px'>
                <tr align="center" style="vertical-align: middle;">
                <th width="5px"  rowspan="2" >ESPECI FICACION</th>
                <th rowspan="2">No.</th>
                <th rowspan="2">FECHA</th>
                <th rowspan="2">NIT PROVEEDOR</th>
                <th width='125px' rowspan="2">RAZON SOCIAL PROVEEDOR</th>
                <th rowspan="2">No. FACTURA</th>
                <th rowspan="2">No. DE DUI</th>
                <th rowspan="2">No. DE AUTORIZACION</th>
                <th width='135px'>IMPORTE TOTAL DE LA COMPRA</th>
                <th width='72px'>IMPORTE NO SUJETO A CREDITO FISCAL</th>
                <th>SUB TOTAL</th>
                <th width='125px'>DESCUENTOS BONIFICACIONES Y REBAJAS OBTENIDAS</th>
                <th width='99px'>IMPORTE BASE PARA EL CREDITO FISCAL</th>
                <th>CREDITO FISCAL</th>
                <th width='97px' rowspan="2">CODIGO DE CONTROL</th>
                <th width='79px' rowspan="2">TIPO DE COMPRA</th>
                <th rowspan="2">Opciones</th>
                </tr>
                <tr  align="center">
                <th>A</th>
                <th>B</th>
                <th>C=A-B</th>
                <th>D</th>
                <th>E=C-D</th>
                <th>F=E*13%</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $i=1;
                    $totalImporteCompra=0;
                    $totalImporteNoSujetoACreditoFiscal=0;
                    $totalSubTotal=0;
                    $totalDBRO=0;
                    $totalImporteBaseParaCreditoFiscal=0;
                    $totalCreditoFiscal=0;
                @endphp
                @foreach ($mes->compras->sortBy('fecha') as $compra)
                <tr align="center">
                    <td>{{$compra->especificacion}}</td>
                    <td>
                        {{$i++}}                     
                    </td>
                    <td>{{Utils::formatDate($compra->fecha)}}</td>
                    <td>{{$compra->proveedor->NIT}}</td>
                    <td>{{$compra->proveedor->razon_social}}</td>
                    <td>{{$compra->nro_factura}}</td>
                    <td></td>
                    <td>
                        @php 
                        $auth=App\Autorizacion::obtenerNroAutorizacion($compra->proveedor->id,$mes->gestion->id);
                        @endphp
                        @if($auth!=null)
                            {{$auth->nro_autorizacion}}
                        @else
                            <template v-if="authsNumevos['{!!$compra->proveedor->id!!}']">
                                @{{authsNumevos['{!!$compra->proveedor->id!!}']}}
                            </template>
                            <template v-else>
                                <el-button @click="registrarNumAuth({!!$compra->proveedor->id!!})" type="danger" plain>Registrar</el-button>
                            </template>
                        @endif
                    </td>
                    <td>{{$compra->importe}}</td>
                    <td>{{$compra->importe*0.3}}</td>
                    <td>{{$compra->importe-($compra->importe*0.3)}}</td>
                    <td>0,00</td>
                    <td>{{$compra->importe-($compra->importe*0.3)-0.00}}</td>
                    <td>{{($compra->importe-($compra->importe*0.3)-0.00)*0.13}}</td>
                    <td>{{$compra->cod_control}}</td>
                    <td>{{$compra->especificacion}}</td>
                    <td>
                    
                                <a href="{{route('compra.edit',$compra)}}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                            
                            <form action="{{route('compra.destroy',$compra->id)}}" method="POST" onSubmit="return confirm('Esta seguro de que quiere Eliminar la compra?');">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                                
                                <button type="submit" class="btn btn-danger btn-sm" ><i class="fas fa-trash "></i> </button>
                            </form>
                            
                    </td>
                </tr>
                @php
                //calculo totales
                    $totalImporteCompra+=$compra->importe;
                    $totalImporteNoSujetoACreditoFiscal+=$compra->importe*0.3;
                    $totalSubTotal+=$compra->importe-($compra->importe*0.3);
                    
                    $totalImporteBaseParaCreditoFiscal=$compra->importe-($compra->importe*0.3)-0.00;
                    $totalCreditoFiscal+=($compra->importe-($compra->importe*0.3)-0.00)*0.13; 
                @endphp
                @endforeach
                <tr align="center" style="background: #FFFFFF;border: back 1px solid">
                    <td style="border: back 1px solid" colspan="2" width="80px">TOTAL</td>
                    <td style="border: back 1px solid" width="50px"></td>
                    <td style="border: back 1px solid" width="70px"></td>
                    <td style="border: back 1px solid" width='125px'></td>
                    <td style="border: back 1px solid" width="60px" ></td>
                    <td style="border: back 1px solid" width="50px" ></td>
                    <td style="border: back 1px solid"></td>
                    <td style="border: back 1px solid" width='105px'>{{getWhitTwooDecimals($totalImporteCompra)}}</td>
                    <td style="border: back 1px solid" width='72px'>{{getWhitTwooDecimals($totalImporteNoSujetoACreditoFiscal)}}</td>
                    <td style="border: back 1px solid" >{{getWhitTwooDecimals($totalSubTotal)}}</td>
                    <td style="border: back 1px solid" width='125px'>0,00</td>
                    <td style="border: back 1px solid" width='99px'>{{getWhitTwooDecimals($totalImporteBaseParaCreditoFiscal)}}</td>
                    <td style="border: back 1px solid" >{{getWhitTwooDecimals($totalCreditoFiscal)}}</td>
                    <td style="border: back 1px solid" width='65px'></td>
                    <td style="border: back 1px solid" width='40px'></td>
                </tr>
                </tbody>
            </table>
            <form action="{{route('compra.destroyAll',$mes->id)}}" method="POST" onSubmit="return confirm('Esta seguro de que quiere Eliminar todo el registro?');">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
                                
                <button type="submit" class="btn btn-danger btn-sm" ><i class="fas fa-trash "></i>ELIMINAR REGISTRO</button>
            </form>
        </div>
    </div>
    
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
                <button type="button" class="btn btn-secondary" @click="showForm=false">Cerrar</button>
                <button type="button" class="btn btn-primary" @click="enviar">Guardar Cambios</button>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
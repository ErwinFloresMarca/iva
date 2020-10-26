@extends('layouts.app')

@section('scripts')
<script>
const app=new Vue({
    el: '#app',
    data(){
        return {
            proveedor: {!! (Auth::user()->proveedor)? Auth::user()->proveedor : 'null' !!},
            user: {!! Auth::user() !!},
            nuevoProv: {},
            showFormProveedor: false,
            error: null,
        };
    },
    methods: {
        confirmar(){
            this.nuevoProv.userId = this.user.id,
            axios.post('/api/proveedor',this.nuevoProv).then((data)=>{
                console.log(data);
            }).catch((error)=>{
                this.error = error; 
            });
        },
    },
});  
</script>
@endsection

@section('content')
<style>
    .el-dialog__header {
        background-color: #409EFF;
        color: white;
    }
</style>
<div id="app">
    <el-dialog :visible.sync="showFormProveedor">
        <div slot="title" height="">
            Registrar Proveedor
        </div>
        
        <el-form label-width="120px">
            <el-form-item label="NIT">
                <el-input v-model="nuevoProv.NIT"></el-input>
            </el-form-item>
            <el-form-item label="Razon Social">
                <el-input v-model="nuevoProv.razon_social"></el-input>
            </el-form-item>
            <el-form-item label="Nro. Autorizacion">
                <el-input v-model="nuevoProv.nro_autorizacion"></el-input>
            </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="showFormProveedor = false">Cancelar</el-button>
            <el-button type="primary" @click="confirmar">Confirmar</el-button>
        </div>
    </el-dialog>
    <div v-if="!proveedor">
        <el-alert
            title="Alerta de Informacion"
            type="error"
            effect="dark"
            show-icon>
            No tiene informacion registrada!!! <br> Registre su informacion 
            <el-button type="primary" size="mini" @click="showFormProveedor = true" round>Registrar Informacion</el-button>
        </el-alert>
    </div>
    <div class="row justify-content-center"  style="font-family: Stencil">
        <h1>GESTION {{$mes->gestion->gestion}} / {{$mes->mes}}</h1>

    </div>
    
    <div class='row justify-content-center'>
            
        <div class="col-12">
            
            <div class="row">
                <div class="col-6">
                <a href="{{route('venta.create.mes',$mes)}}" class="btn btn-success">
                    <i class="fas fa-folder-open"></i> Nueva Venta
                </a>
                </div>
                <div class="col-5 ">
                <div class="row justify-content-end">
                   <a href="{{route('venta.excel',$mes->id)}}" class="btn btn-success"> GENERAR EXCEL</a> &nbsp; <a href="{{route('venta.pdf.carta',$mes->id)}}" class="btn btn-danger"> GENERAR PDF CARTA</a> &nbsp; <a href="{{route('venta.pdf.oficio',$mes->id)}}" class="btn btn-danger"> GENERAR PDF OFICIO</a> 
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
                <thead style="background: #C8A2C8">
                <tr align="center" style="vertical-align: middle;">
                <th width="5px"  rowspan="2" >ESPECI FICACION</th>
                <th rowspan="2">No.</th>
                <th rowspan="2">FECHA</th>
                <th rowspan="2">No. FACTURA</th>
                <th rowspan="2">No. DE AUTORIZACION</th>
                <th rowspan="2">ESTADO</th>
                <th rowspan="2">NIT/CI DEL CLIENTE</th>
                <th width='125px' rowspan="2">NOMBRE O RAZON SOCIAL</th>
                <th width='135px'>IMPORTE TOTAL DE LA VENTA</th>
                <th width='72px'>IMPORTE ICE/ IEHD/ TASAS</th>
                <th>EXPORTACIONES Y OPERACIONES EXENTAS</th>
                <th>VENTAS GRAVADAS A TASA CERO</th>
                <th>SUB TOTAL</th>
                <th width='125px'>DESCUENTOS BONIFICACIONES Y REBAJAS OTORGADAS</th>
                <th width='99px'>IMPORTE BASE PARA EL CREDITO FISCAL</th>
                <th>DEBITO FISCAL</th>
                <th width='97px' rowspan="2">CODIGO DE CONTROL</th>
                <th rowspan="2">Opciones</th>
                </tr>
                <tr  align="center">
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E=A-B-C-D</th>
                <th>F</th>
                <th>G=E-F</th>
                <th>G*13%</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $i=1;
                    $totalImporteVenta=0;
                    $totalSubTotal=0;
                    $totalImporteBaseParaCreditoFiscal=0;
                    $totalDebitoFiscal=0;
                @endphp
                @foreach ($mes->ventas->sortBy('fecha') as $venta)
                <tr align="center">
                    <td>{{$venta->especificacion}}</td>
                    <td>
                        {{$i++}}                     
                    </td>
                    <td>{{Utils::formatDate($venta->fecha)}}</td>
                    <td>{{$venta->nro_factura}}</td>
                    <td>
                        <!-- numero de autorizacion Datos Administrativos -->
                    </td>
                    <td>{{($venta->estado)?"V":"A"}}</td>
                    <td>{{$venta->cliente->nit_ci}}</td>
                    <td>{{$venta->cliente->nombre_rs}}</td>
                    <td>{{$venta->importe}}</td>
                    <td>{{'0,00'}}</td>
                    <td>{{'0,00'}}</td>
                    <td>{{'0,00'}}</td>
                    <td>{{$venta->importe}}</td>
                    <td>{{'0,00'}}</td>
                    <td>{{$venta->importe}}</td>
                    <td>{{getWhitTwooDecimals($venta->importe*0.13)}}</td>
                    <td></td>
                    <td>
                    
                                <a href="{{route('venta.edit',$venta)}}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> 
                                </a>
                            
                            <form action="{{route('venta.destroy',$venta->id)}}" method="POST" onSubmit="return confirm('Esta seguro de que quiere Eliminar la venta?');">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                                
                                <button type="submit" class="btn btn-danger btn-sm" ><i class="fas fa-trash "></i> </button>
                            </form>
                            
                    </td>
                </tr>
                @php
                //calculo totales
                    $totalImporteVenta+=$venta->importe;
                    $totalSubTotal+=$venta->importe;
                    $totalImporteBaseParaCreditoFiscal+=$venta->importe;
                    $totalDebitoFiscal+=($venta->importe*0.13); 
                @endphp
                @endforeach
                <tr align="center" style="background: #FFFFFF;border: back 1px solid">
                    <td style="border: back 1px solid" colspan="8" >TOTAL</td>
                    <td style="border: back 1px solid" >{{getWhitTwooDecimals($totalImporteVenta)}}</td>
                    <td style="border: back 1px solid" >-</td>
                    <td style="border: back 1px solid" >-</td>
                    <td style="border: back 1px solid" >-</td>
                    <td style="border: back 1px solid">{{getWhitTwooDecimals($totalSubTotal)}}</td>
                    <td style="border: back 1px solid" >-</td>
                    <td style="border: back 1px solid" >{{getWhitTwooDecimals($totalImporteBaseParaCreditoFiscal)}}</td>
                    <td style="border: back 1px solid">{{getWhitTwooDecimals($totalDebitoFiscal)}}</td>
                    <td style="border: back 1px solid"></td>
                    <td style="border: back 1px solid"></td>
                </tr>
                </tbody>
            </table>
            <form action="{{route('venta.destroyAll',$mes->id)}}" method="POST" onSubmit="return confirm('Esta seguro de que quiere Eliminar todo el registro?');">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
                                
                <button type="submit" class="btn btn-danger btn-sm" ><i class="fas fa-trash "></i>ELIMINAR REGISTRO</button>
            </form>
        </div>
    </div>
    
    
</div>

@endsection
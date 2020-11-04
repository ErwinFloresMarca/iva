<center>
@php 
                use App\UtilsVentas;
                $tamColum=UtilsVentas::getTamColumCarta();
                $ip=0;
           @endphp
            <div width="{{UtilsVentas::sumAllPx($tamColum)}}'px'">
            <h3>LIBRO DE VENTAS IVA MES DE {{$mes->mes}} DE {{$mes->gestion->gestion}}<br/>
                OFICINA DEPARTAMENTAL POTOSÍ</h3><br>
            </div>
                
            

<font size='06'>
           <style>
               .page_break { page-break-before: always; }   
           </style>
           
            <table width="{{UtilsVentas::sumAllPx($tamColum)}}'px'"
            style="border-collapse:collapse; border: black 1px solid">
                <thead style="border: black 1px solid;">
                <tr align="center" style="vertical-align: middle; background: #AAAAAA; border: back 1px solid">
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} height='80px' rowspan="2" >ESPECI FICACION</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">No.</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">FECHA</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">No. FACTURA</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">No. DE AUTORIZACION</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">ESTADO</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">NIT/CI DEL CLIENTE</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">NOMBRE O RAZON SOCIAL</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >IMPORTE TOTAL DE LA VENTA</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >IMPORTE ICE/ IEHD/ TASAS</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >EXPORTACIONES Y OPERACIONES EXENTAS</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >VENTAS GRAVADAS A TASA CERO</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >SUB TOTAL</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >DESCUENTOS BONIFICACIONES Y REBAJAS OTORGADAS</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >IMPORTE BASE PARA EL CREDITO FISCAL</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} >DEBITO FISCAL</th>
                <th {!!UtilsVentas::getStyle($tamColum[$ip++])!!} rowspan="2">CODIGO DE CONTROL</th>
                </tr>
                <tr  align="center" style="vertical-align: middle; background: #AAAAAA; border: back 1px solid">
                <th style="border: back 1px solid">A</th>
                <th style="border: back 1px solid">B</th>
                <th style="border: back 1px solid">C</th>
                <th style="border: back 1px solid">D</th>
                <th style="border: back 1px solid">E=A-B-C-D</th>
                <th style="border: back 1px solid">F</th>
                <th style="border: back 1px solid">G=E-F</th>
                <th style="border: back 1px solid">G*13%</th>
                </tr>
                </thead>

                <tbody style="border: back 1px solid">
                @php
                    $i=1;
                    $contSalt=1;
                    $primero=true;
                    $totalImporteVenta=0;
                    $totalSubTotal=0;
                    $totalImporteBaseParaCreditoFiscal=0;
                    $totalDebitoFiscal=0;
                    $ip=0;
                @endphp
                @foreach ($mes->ventas->sortBy('fecha') as $venta)
                @switch((ceil($contSalt)>=44&&ceil($contSalt)<=45)? (($primero)? 44 : 0) : ceil($contSalt) )
                @case(57)
                @case(58)
                @case(59)
                @case(45)
                @case(44) 
                @php
                $contSalt=0;
                $primero=false
                @endphp
                </tbody>
            </table>
                <div class="page_break"></div>
                
            <table width="{{UtilsVentas::sumAllPx($tamColum)}}.'px'"
            style="border-collapse:collapse; border: back 1px solid">
                <tbody style="border: back 1px solid">
                @endswitch
                <tr align="center" style="background: #FFFFFF;border: back 1px solid">
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{$venta->especificacion}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>
                        {{$i++}}                     
                    </td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{UtilsVentas::formatDate($venta->fecha)}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{$venta->nro_factura}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>
                        {{App\Autorizacion::obtenerNroAutorizacion(Auth::user()->proveedor->id,$mes->gestion->id)->nro_autorizacion}}
                        <!-- numero de autorizacion Datos Administrativos -->
                    </td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{($venta->estado)?"V":"A"}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{$venta->cliente->nit_ci}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{$venta->cliente->nombre_rs}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{$venta->importe}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{'0,00'}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{'0,00'}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{'0,00'}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{$venta->importe}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{'0,00'}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{$venta->importe}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{UtilsVentas::getWithTwooDecimals($venta->importe*0.13)}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}></td>
                </tr>
                @php
                //calculo totales
                    $totalImporteVenta+=$venta->importe;
                    $totalSubTotal+=$venta->importe;
                    $totalImporteBaseParaCreditoFiscal+=$venta->importe;
                    $totalDebitoFiscal+=($venta->importe*0.13);
                $contSalt++;
                $i++;
                $ip=0; 
                @endphp
                @endforeach
                <tr align="center" style="background: #FFFFFF;border: back 1px solid">
                    <td {!!UtilsVentas::getStyle(UtilsVentas::sumPx(array($ip++,$ip++,$ip++,$ip++,$ip++,$ip++,$ip++,$ip++))."px")!!} colspan="8" >TOTAL</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{UtilsVentas::getWithTwooDecimals($totalImporteVenta)}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>-</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>-</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>-</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{UtilsVentas::getWithTwooDecimals($totalSubTotal)}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>-</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{UtilsVentas::getWithTwooDecimals($totalImporteBaseParaCreditoFiscal)}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}>{{UtilsVentas::getWithTwooDecimals($totalDebitoFiscal)}}</td>
                    <td {!!UtilsVentas::getStyle($tamColum[$ip++])!!}></td>
                </tr>
                </tbody>
            </table>
            </font>
</center>
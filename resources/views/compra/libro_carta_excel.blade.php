<center>
            <?php 
                use App\Utils;
                $tamColum=Utils::getTamColumExcel();

                $ip=0;
            ?>
                
            

<font size='06'>
            <table width="{{Utils::sumAllPx($tamColum)}}"
            style="border-collapse:collapse; border: black 1 solid">
                <tr><td colspan="16">
                <h3>LIBRO DE COMPRAS IVA MES DE {{$mes->mes}} DE {{$mes->gestion->gestion}}<br/>
                OFICINA DEPARTAMENTAL POTOSÍ</h3>
                </td></tr>
                <thead style="border: black 1 solid;" >
                <tr align="center" style="vertical-align: middle; background-color: #AAAAAA; border: back 1 solid">
                <th height='80' {!!Utils::getStyle($tamColum[$ip++])!!}  rowspan="2" >ESPE<br/>CIFI<br/>CACI<br/>ON</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">No.</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">FECHA</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">NIT<br/>PROVEEDOR</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">RAZON SOCIAL PROVEEDOR</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">No. FACTURA</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">No. DE DUI</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">No. DE AUTORIZACION</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} >IMPORTE<br/>TOTAL DE LA<br/>COMPRA</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} >IMPORTE NO<br/>SUJETO A<br/>CREDITO<br/>FISCAL</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} >SUB TOTAL</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} >DESCUENTOS<br/>BONIFICACION<br/>ES Y REBAJAS<br/>OBTENIDAS</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} >IMPORTE BASE<br/>PARA EL<br/>CREDITO<br/>FISCAL</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} >CREDITO<br/>FISCAL</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">CODIGO DE<br/>CONTROL</th>
                <th {!!Utils::getStyle($tamColum[$ip++])!!} rowspan="2">TIPO DE<br/>COMPRA</th>
                
                </tr>
                <tr  align="center" style="background-color: #AAAAAA; border: back 1 solid">
                <th style="border: back 1 solid">A</th>
                <th style="border: back 1 solid">B</th>
                <th style="border: back 1 solid">C=A-B</th>
                <th style="border: back 1 solid">D</th>
                <th style="border: back 1 solid">E=C-D</th>
                <th style="border: back 1 solid">F=E*13%</th>
                </tr>
                </thead>
                <tbody style="border: back 1 solid">
                <?php
                    $i=1;
                    $ip=0;
                    $totalImporteCompra=0;
                    $totalImporteNoSujetoACreditoFiscal=0;
                    $totalSubTotal=0;
                    $totalDBRO=0;
                    $totalImporteBaseParaCreditoFiscal=0;
                    $totalCreditoFiscal=0;
                ?>
                @foreach ($mes->compras->sortBy('fecha') as $compra)
                <tr align="center" style="background-color: #FFFFFF;border: back 1 solid" >
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->especificacion}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$i}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{Utils::formatDate($compra->fecha)}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->proveedor->NIT}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->proveedor->razon_social}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->nro_factura}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{'   '}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{App\Autorizacion::obtenerNroAutorizacion($compra->proveedor->id,$mes->gestion->id)->nro_autorizacion}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->importe}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->importe*0.3}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->importe-($compra->importe*0.3)}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>0,00</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->importe-($compra->importe*0.3)-0.00}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{($compra->importe-($compra->importe*0.3)-0.00)*0.13}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->cod_control}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{$compra->especificacion}}</td>
                    
                </tr>
                <?php
                //calculo totales
                    $totalImporteCompra+=$compra->importe;
                    $totalImporteNoSujetoACreditoFiscal+=$compra->importe*0.3;
                    $totalSubTotal+=$compra->importe-($compra->importe*0.3);
                    
                    $totalImporteBaseParaCreditoFiscal=$compra->importe-($compra->importe*0.3)-0.00;
                    $totalCreditoFiscal+=($compra->importe-($compra->importe*0.3)-0.00)*0.13;
                $i++;
                $ip=0; 
                ?>
                @endforeach
                <tr align="center" style="background: #FFFFFF;border: back 1px solid">
                    <td {!!Utils::getStyle(Utils::sum(array($ip++,$ip++)))!!} colspan="2">TOTAL</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{Utils::getWhitTwooDecimals($totalImporteCompra)}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{Utils::getWhitTwooDecimals($totalImporteNoSujetoACreditoFiscal)}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{Utils::getWhitTwooDecimals($totalSubTotal)}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>0,00</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{Utils::getWhitTwooDecimals($totalImporteBaseParaCreditoFiscal)}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}>{{Utils::getWhitTwooDecimals($totalCreditoFiscal)}}</td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                    <td {!!Utils::getStyle($tamColum[$ip++])!!}></td>
                </tr>
                </tbody>
            </table>
            </font>
</center>
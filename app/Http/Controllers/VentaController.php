<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Venta;
use App\Exports\VentasExportView;
use App\Mes;
use App\Proveedor;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function lista_por_Mes(Mes $mes)
    {
        $mes->ventas;
        return view('venta.lista_por_mes')->with('mes',$mes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createVenta(Mes $mes)
    {
        return view('venta.create')->with('mes',$mes)->with('clientes',Cliente::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos=array();
        $mensages=[
            'cliente_id.required'=>'debe seleccionar un cliente',
            'nit_ci.required' => 'El nit_ci es requerido.',
            'nombre_rs.required' => 'El Nombre o Razon Social es requerido.',
            'fecha.required'=>'La fecha es requerida.',
            'estado.required'=>'El estado es requerida.',
            'nro_factura.required'=>'El campo Numero de factura debe tener algun valor.',
            'nro_factura.unique'=>'Este numero de factura ya existe',
            'importe.required'=>'El campo Importe es Requerido.'
        ];
        if($request->clienteSeleccionado=='true'){
            $campos['cliente_id']='required';
        }
        if($request->nuevoCliente=='true'){
            $campos['nombre_rs'] = 'required';
        }
        $campos['fecha']='required';
        $campos['nro_factura']='required|unique:ventas';
        $campos['importe']='required';
        $this->validate($request,$campos,$mensages);
        $cliente=null;
        if($request->nuevoCliente=='true'){
            $cliente=new Cliente();
            $cliente->nit_ci=($request->nit_ci)? $request->nit_ci: '';
            $cliente->nombre_rs=$request->nombre_rs;
            $cliente->save();
        }
        else{
            $cliente=Cliente::find($request->cliente_id);
        }
        
        $nuevaVenta= new Venta();
        $nuevaVenta->especificacion=$request->especificacion;
        $nuevaVenta->cliente_id = $cliente->id;
        $nuevaVenta->mes_id = $request->mes_id;
        $nuevaVenta->nro_factura = $request->nro_factura;
        $nuevaVenta->fecha = $request->fecha ;
        $nuevaVenta->estado = $request->estado ;
        $nuevaVenta->importe = $request->importe ;
        $nuevaVenta->cod_control = ($request->cod_control)? $request->cod_control: "" ;
        $nuevaVenta->save();
        Toastr::success('creado exitosamente', 'Creado', ["positionClass" => "toast-top-right"]);
        return redirect(route('venta.mes',$request->mes_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venta=Venta::find($id);
        return view('venta.edit')->with('venta',$venta)->with('mes',$venta->mes)->with('clientes',Cliente::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $venta=Venta::find($id);
        $campos=array();

        $mensages=array();

        if($venta->fecha!=$request->fecha){
            $campos['fecha']='required';
            $mensages['fecha.required']='El campo fecha no puede estar vacio.';
            $venta->fecha=$request->fecha;
        }
        if($venta->nro_factura!=$request->nro_factura){
            $campos['nro_factura']='required|unique:ventas';
            $mensages['nro_factura.required']='El numero de factura debe tener algun valor.';
            $mensages['nro_factura.unique']='El numero de factura ya se encuentra registrado.';
            $venta->nro_factura=$request->nro_factura;
        }
        if($venta->importe!=$request->importe){
            $campos['importe']='required';
            $mensages['importe.required']='El importe es requerido.';
            $venta->importe=$request->importe;
        }
        if($venta->cod_control!=$request->cod_control){
            $campos['cod_control']='required';
            $mensages['cod_control.required']='El Codigo de Controles requerido.';
            $venta->cod_control=$request->cod_control;
        }
        $venta->especificacion=$request->especificacion;

        $this->validate($request,$campos ,$mensages);
        $venta->cliente_id=$request->cliente_id;
        $venta->save();
        Toastr::success('registro con numero de factura '.$venta->nro_factura.'actualizado exitosamente!!!', 'Actualizacion Exitosa', ["positionClass" => "toast-top-right"]);
        return redirect(route('venta.mes',$venta->mes_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venta=Venta::find($id);
        $venta->delete();
        Toastr::success('Registro con nuemro de factura '.$venta->nro_factura.' eliminado!!!', 'Eliminado', ["positionClass" => "toast-top-right"]);
        return redirect(route('venta.mes',$venta->mes_id));
    }

    public function destroyAll(Mes $mes)
    {
        foreach($mes->ventas as $venta)
            $venta->delete();
        Toastr::success('Todos los registros fueron eliminados!!!', 'Eliminado', ["positionClass" => "toast-top-right"]);
        return redirect(route('venta.mes',$mes->id));
    }
    public function generarPDFcarta(Mes $mes){
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('letter', 'landscape');
        $pdf->loadView('venta.libro_carta',[
            'mes'=>$mes
        ]);
        return $pdf->stream();
    }
    public function generarPDFoficio(Mes $mes){
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('folio', 'landscape');
        $pdf->loadView('venta.libro_oficio',[
            'mes'=>$mes
        ]);
        return $pdf->stream();
    }

    public function generarExcel(Mes $mes)
    {   
        /*
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('letter', 'landscape');
        $pdf->loadView('compra.libro_carta',[
            'mes'=>$mes
        ]);
        //$pdf->render();
        $output = $pdf->output();
        
        $pdf_file = 'test.pdf';
        
        if (!is_readable($pdf_file)) {
                print("Error: file does not exist or is not readable: $pdf_file\n");
                return;
        }
        
        $c = curl_init();

        $cfile = $output;//curl_file_create($output, 'application/pdf');

        $apikey = 'lwfjdyujobqh'; // from https://pdftables.com/api
        curl_setopt($c, CURLOPT_URL, "https://pdftables.com/api?key=$apikey&format=xlsx-single");
        curl_setopt($c, CURLOPT_POSTFIELDS, array('file' => $cfile));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_FAILONERROR,true);
        curl_setopt($c, CURLOPT_ENCODING, "gzip,deflate");

        $result = curl_exec($c);

        if (curl_errno($c) > 0) {
            print('Error calling PDFTables: '.curl_error($c).PHP_EOL);
        } else {
            // save the CSV we got from PDFTables to a file
            file_put_contents ("ejemplo_excel.xlsx", $result);
        }

        curl_close($c);
        

        return response()->download("./ejemplo_excel.xlsx");
        //return Response::download($result, 'filename.xlsx', $headers);
        //return $result;*/
        return Excel::download(new VentasExportView($mes->id),'LIBRO_Ventas_IVA_'.$mes->mes.'_'.$mes->gestion->gestion.'_POTOSI.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Autorizacion;
use App\Compra;
use App\Exports\ComprasExportView;
use App\Gestion;
use App\Mes;
use App\Proveedor;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class CompraController extends Controller
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
        $mes->compras;
        return view('compra.lista_por_mes')->with('mes',$mes);
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
    public function createCompra(Mes $mes)
    {
        return view('compra.create')->with('mes',$mes)->with('proveedores',Proveedor::all());
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
            'prov.required'=>'Debe seleccionar o registrar un Proveedor.',
            'proveedor_id.required'=>'debe seleccionar un Proveedor',
            'NIT.required' => 'El NIT es requerido.',
            'NIT.unique' =>'El NIT ya se encuentra registrado.',
            'razon_social.required' => 'La Razon Social es requerido.',
            'razon_social.unique' =>'La Razon Social ya se encuentra registrado.',
            'nro_autorizacion.required' => 'El Numero de Autorizacion es requerido.',
            'nro_autorizacion.unique' =>'El Numero de Autorizacion ya se encuentra registrado.',
            'fecha.required'=>'La fecha es requerida.',
            'nro_factura.required'=>'El campo Numero de factura debe tener algun valor.',
            'nro_factura.unique'=>'Este numero de factura ya existe',
            'importe.required'=>'El campo Importe es Requerido.'
        ];
        if($request->prooveedorSeleccionado=='false'&&$request->nuevoProveedor=='false'){
            $campos['prov']='required';
        }

        if($request->prooveedorSeleccionado=='true'){
            $campos['proveedor_id']='required';
        }
        if($request->nuevoProveedor=='true'){
            $campos['NIT'] = 'required|unique:proveedores';
            $campos['razon_social'] = 'required|unique:proveedores';
            $campos['nro_autorizacion'] = 'required|unique:autorizaciones';
        }
        $campos['fecha']='required';
        $campos['nro_factura']='required|unique:compras';
        $campos['importe']='required';
        $this->validate($request,$campos,$mensages);
        $proveedor=null;
        if($request->nuevoProveedor=='true'){
            $proveedor=new Proveedor();
            $proveedor->NIT=$request->NIT;
            $proveedor->razon_social=$request->razon_social;
            $proveedor->save();
            $auth=new Autorizacion();
            if($request->nro_autorizacion != null){
                $auth->nro_autorizacion=$request->nro_autorizacion;
                $auth->proveedor_id=$proveedor->id;
                $auth->gestion_id=Gestion::ultimaGestion()->id;
                $auth->save();
            }
        }
        else{
            $proveedor=Proveedor::find($request->proveedor_id);
        }
        $nuevaCompra=new Compra();
        $nuevaCompra->especificacion=$request->especificacion;
        $nuevaCompra->mes_id=$request->mes_id;
        $nuevaCompra->proveedor_id=$proveedor->id;
        $nuevaCompra->fecha=$request->fecha;
        $nuevaCompra->nro_factura=$request->nro_factura;
        $nuevaCompra->importe=$request->importe;
        $nuevaCompra->cod_control=$request->cod_control;
        $nuevaCompra->save();
        
        Toastr::success('creado exitosamente', 'Creado', ["positionClass" => "toast-top-right"]);
        return redirect(route('compra.mes',$request->mes_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        return view('compra.edit')->with('compra',$compra)->with('mes',$compra->mes)->with('proveedores',Proveedor::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {

        $campos=array();

        $mensages=array();

        if($compra->fecha!=$request->fecha){
            $campos['fecha']='required';
            $mensages['fecha.required']='El campo fecha no puede estar vacio.';
            $compra->fecha=$request->fecha;
        }
        if($compra->nro_factura!=$request->nro_factura){
            $campos['nro_factura']='required|unique:compras';
            $mensages['nro_factura.required']='El numero de factura debe tener algun valor.';
            $mensages['nro_factura.unique']='El numero de factura ya se encuentra registrado.';
            $compra->nro_factura=$request->nro_factura;
        }
        if($compra->importe!=$request->importe){
            $campos['importe']='required';
            $mensages['importe.required']='El importe es requerido.';
            $compra->importe=$request->importe;
        }
        if($compra->cod_control!=$request->cod_control){
            $campos['cod_control']='required|unique:compras';
            $mensages['cod_control.required']='El Codigo de Controles requerido.';
            $mensages['cod_control.unique']='El codigo de control ya se encuentra registrado.';
            $compra->cod_control=$request->cod_control;
        }
        $compra->especificacion=$request->especificacion;

        $this->validate($request,$campos ,$mensages);
        $compra->proveedor_id=$request->proveedor_id;
        $compra->save();
        Toastr::success('registro con numero de factura '.$compra->nro_factura.' actualizado exitosamente!!!', 'Actualizacion Exitosa', ["positionClass" => "toast-top-right"]);
        return redirect(route('compra.mes',$compra->mes_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        $compra->delete();
        Toastr::success('Registro con nuemro de factura '.$compra->nro_factura.' eliminado!!!', 'Eliminado', ["positionClass" => "toast-top-right"]);
        return redirect(route('compra.mes',$compra->mes_id));
    }

    public function destroyAll(Mes $mes)
    {
        foreach($mes->compras as $compra)
            $compra->delete();
        Toastr::success('Todos los registros fueron eliminados!!!', 'Eliminado', ["positionClass" => "toast-top-right"]);
        return redirect(route('compra.mes',$mes->id));
    }

    public function generarPDFcarta(Mes $mes){
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('letter', 'landscape');
        $pdf->loadView('compra.libro_carta',[
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
        return Excel::download(new ComprasExportView($mes->id),'LIBRO_COMPRAS_IVA_'.$mes->mes.'_'.$mes->gestion->gestion.'_POTOSI.xlsx');
    }
}

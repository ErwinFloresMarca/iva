<?php

namespace App\Http\Controllers;

use App\Autorizacion;
use App\Gestion;
use App\Proveedor;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;


class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores=Proveedor::all();
        $provs=array();
        foreach($proveedores as $proveedor){
            if(!count($proveedor->user)>=1){
                $provs[]=$proveedor;
            }
        }
        return view('proveedor.index')->with('proveedores',$provs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accept = request()->header('accept');

        $this->validate($request, [
            'NIT' => 'required|unique:proveedores',
            'razon_social' => 'required|unique:proveedores',
        ],[
            'NIT.required' => 'El NIT es requerido.',
            'NIT.unique' =>'El NIT ya se encuentra registrado.',
            'razon_social.required' => 'La Razon Social es requerido.',
            'razon_social.unique' =>'La Razon Social ya se encuentra registrado.',
        ]);
        $nuevo=new Proveedor();
        $nuevo->NIT=$request->NIT;
        $nuevo->razon_social=$request->razon_social;
        $nuevo->save();
        if($request->nro_autorizacion != null){
            $auth=new Autorizacion();
            $auth->nro_autorizacion=$request->nro_autorizacion;
            $auth->proveedor_id=$nuevo->id;
            $auth->gestion_id=Gestion::ultimaGestion()->id;
            $auth->save();
        }

         // application/json
        if($request->userId){
            $user = User::find($request->userId);
            $user->proveedor_id = $nuevo->id;
            $user->save();
        }
        if( strpos($accept,'application/json')!= 1 )
        {
            return json_encode(['msn'=>'registro exitoso','proveedor'=>$nuevo]);
        }
        else{
            Toastr::success('Proveedor '.$nuevo->razon_social.' creado exitosamente', 'Proveedor Creado', ["positionClass" => "toast-top-right"]);
            return redirect('proveedor');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor)
    {
        return view('proveedor.edit')->with('proveedor',$proveedor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $campos=array();

        $mensages=array();
        if($proveedor->NIT!=$request->NIT){
            $campos['NIT']='required|unique:proveedores';
            $mensages['NIT.required']='El NIT es requerido.';
            $mensages['NIT.unique']='El NIT ya se encuentra registrado.';
            $proveedor->NIT=$request->NIT;
        }
        if($proveedor->razon_social!=$request->razon_social){
            $campos['razon_social']='required|unique:proveedores';
            $mensages['razon_social.required']='La Razon Social es requerido.';
            $mensages['razon_social.unique']='La Razon Social ya se encuentra registrado.';
            $proveedor->razon_social=$request->razon_social;
        }
        if($proveedor->nro_autorizacion!=$request->nro_autorizacion){
            $campos['nro_autorizacion']='required|unique:proveedores';
            $mensages['nro_autorizacion.required']='El Numero de Autorizacion es requerido.';
            $mensages['nro_autorizacion.unique']='El Numero de Autorizacion ya se encuentra registrado.';
            $proveedor->nro_autorizacion=$request->nro_autorizacion;
        } 


        $this->validate($request,$campos ,$mensages);

        $proveedor->save();
        Toastr::success('Proveedor '.$proveedor->razon_social.' actualizado exitosamente', 'Proveedor Actualizado', ["positionClass" => "toast-top-right"]);
        return redirect(route('proveedor.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return redirect(route('proveedor.index'));
    }
}

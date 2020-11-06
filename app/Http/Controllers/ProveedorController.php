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
        $rules = [
            'NIT' => 'required|unique:proveedores',
            'razon_social' => 'required|unique:proveedores',
            
        ];
        $msns = [
            'NIT.required' => 'El NIT es requerido.',
            'NIT.unique' =>'El NIT ya se encuentra registrado.',
            'razon_social.required' => 'La Razon Social es requerido.',
            'razon_social.unique' =>'La Razon Social ya se encuentra registrado.',
        ];
        if($request->nro_autorizacion){
            $rules['nro_autorizacion']= 'numeric';
            $msns['nro_autorizacion.numeric'] = 'El numero de autorizacion solo debe contener numeros';
        }
        $this->validate($request, $rules,$msns);
        $nuevo=new Proveedor();
        $nuevo->NIT=$request->NIT;
        $nuevo->razon_social=$request->razon_social;
        $nuevo->save();
        $auth=new Autorizacion();
        if($request->nro_autorizacion != null){
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
        
        $res = strpos($accept,'application/json');
        if( $res == 0)
        {
            $res = ['msn'=>'registro exitoso','proveedor'=>$nuevo];
            if($request->nro_autorizacion){
                $res['autorizacion']= $auth;
            }
            return json_encode($res);
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
        $accept = request()->header('accept');
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
        $this->validate($request,$campos ,$mensages);

        $proveedor->save();

        $res = strpos($accept,'application/json');
        
        if( $res == 0 ){
            return response()->json(['proveedor'=>$proveedor]);
        }else{
            Toastr::success('Proveedor '.$proveedor->razon_social.' actualizado exitosamente', 'Proveedor Actualizado', ["positionClass" => "toast-top-right"]);
            return redirect(route('proveedor.index')); 
        }

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
        Toastr::success('Proveedor '.$proveedor->razon_social.' eliminado', 'Proveedor Eliminado', ["positionClass" => "toast-top-right"]);
        return redirect(route('proveedor.index'));
    }
}

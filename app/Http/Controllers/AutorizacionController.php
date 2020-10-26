<?php

namespace App\Http\Controllers;

use App\Autorizacion;
use Illuminate\Http\Request;

class AutorizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(Autorizacion::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo=new Autorizacion();
        $nuevo->nro_autorizacion=$request->input('nro_autorizacion');
        $nuevo->proveedor_id=$request->input('proveedor_id');
        $nuevo->gestion_id=$request->input('gestion_id');
        $nuevo->save();
        return json_encode(['msn'=>'creado','autorizacion'=>$nuevo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function show(Autorizacion $autorizacion)
    {
        return json_encode($autorizacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $autorizacion=Autorizacion::find($id);
        $autorizacion->nro_autorizacion=$request->input('nro_autorizacion');
        $autorizacion->proveedor_id=$request->input('proveedor_id');
        $autorizacion->gestion_id=$request->input('gestion_id');
        $autorizacion->save();
        $autorizacion->gestion;
        return json_encode(['msn'=>'actualizado','autorizacion'=>$autorizacion]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Autorizacion  $autorizacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $autorizacion=Autorizacion::find($id);
        $autorizacion->delete();
        return json_encode(['msn'=>'eliminado']);
    }
}

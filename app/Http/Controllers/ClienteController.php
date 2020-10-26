<?php

namespace App\Http\Controllers;

use App\Cliente;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes=Cliente::all();
        return view('cliente.index')->with('clientes',$clientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre_rs' => 'required',
        ],[
            'nombre_rs.required' => 'El nombre o Razon Social es requerido.',
        ]);

        $nuevo=new Cliente();
        $nuevo->nombre_rs=$request->nombre_rs;

        $nuevo->nit_ci=($request->nit_ci)? $request->nit_ci:'';
        $nuevo->save();
        Toastr::success('Cliente '.$nuevo->nombre_rs.' creado exitosamente', 'Cliente Creado', ["positionClass" => "toast-top-right"]);
        return redirect('cliente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        return view('cliente.edit')->with('cliente',$cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $campos=array();

        $mensages=array();
        
        if($cliente->nombre_rs!=$request->nombre_rs){
            $campos['nombre_rs']='required';
            $mensages['nombre_rs.required']='El Nombre o Razon Social es requerido.';
            $cliente->nombre_rs=$request->nombre_rs;
        }
        $cliente->nit_ci=($request->nit_ci)? $request->nit_ci:'';
        $this->validate($request,$campos ,$mensages);

        $cliente->save();
        Toastr::success('Cliente '.$cliente->nombre_rs.' Actualizado exitosamente', 'Cliente Actualizado', ["positionClass" => "toast-top-right"]);
        
        return redirect(route('cliente.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        Toastr::success('Cliente '.$cliente->nombre_rs.' Eliminado exitosamente', 'Cliente Eliminado', ["positionClass" => "toast-top-right"]);
        return redirect('cliente');
    }
}

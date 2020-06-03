<?php

namespace App\Http\Controllers;

use App\Gestion;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gestiones=Gestion::all();
        return view('gestion.index')->with('gestiones',$gestiones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gestion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevaGestion=new Gestion();
        $this->validate($request,[
            'gestion'=>'required|unique:gestiones'
        ],[
            'gestion.required'=>'La gestion es requerida.',
            'gestion.unique'=>'La gestion ya se encuentra registrada.'
        ]);

        $nuevaGestion->gestion=$request->gestion;
        $nuevaGestion->save();
        return redirect(route('gestion.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function show(Gestion $gestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Gestion $gestion)
    {
        return view('gestion.edit')->with('gestion',$gestion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gestion $gestion)
    {
        $campos=array();

        $mensages=array();
        if($gestion->gestion!=$request->gestion){
            $campos['gestion']='required|unique:gestiones';
            $mensages['gestion.required']='La gestion es requerido.';
            $mensages['gestion.unique']='La Gestion ya se encuentra registrado.';
            $gestion->gestion=$request->gestion;
        }
        


        $this->validate($request,$campos ,$mensages);

        $gestion->save();
        return redirect(route('gestion.index')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gestion $gestion)
    {
        $gestion->delete();

        return redirect(route('gestion.index'));
    }
}

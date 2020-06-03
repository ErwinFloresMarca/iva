<?php

namespace App\Http\Controllers;

use App\Mes;
use App\Gestion;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class MesController extends Controller
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
     /**
     * Display the specified gestion.
     *
     * @param  \App\Gestion  $gestion
     * @return \Illuminate\Http\Response
     */
    public function index_por_gestion(Gestion $gestion)
    {
        $gestion->meses;
        return view('mes.index_por_gestion')->with('gestion',$gestion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMes(Gestion $gestion)
    {
        $gestion->meses;
        //dd($gestion);
        return view('mes.create')->with('gestion',$gestion);
    }
    public function create()
    {
       
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request);
        $nuevoMes=new Mes();
        $nuevoMes->gestion_id=$request->gestion_id;
        $nuevoMes->mes=$request->mes;
        $nuevoMes->save();
        return redirect(route('mes.gestion',$request->gestion_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function show(Mes $mes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function edit(Mes $mes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mes $mes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $mes=Mes::find($id);
        $gestion=$mes->gestion;
        $msn='Este mes contiene registros Desea Elimiar todo ?<br><br>
        <form action="'.route('mes.destroyForce',$mes->id).'" method="POST" >
        <input type="hidden" name="_token" value="'.csrf_token() .'"/>
        <input type="hidden" name="_method" value="DELETE">                 
        <button type="submit" class="btn btn-danger clear" ><i class="fas fa-trash"></i> SI</button>               
        </form>
        ';
        $msn=str_replace("\n","",$msn);
        if(sizeof($mes->compras)>0){
            Toastr::error($msn, 'Eliminado', ["positionClass" => "toast-top-right"]);
            return redirect(route('mes.gestion',$gestion->id));
        }
        $mes->delete();
        return redirect(route('mes.gestion',$gestion->id));
    }
    public function destroyForce(Mes $mes)
    {
        foreach($mes->compras as $compra)
            $compra->delete();
        //eliminar ventas
        $mes->delete();
        Toastr::success('Mes '.$mes->mes.' eliminado!!!', 'Eliminado', ["positionClass" => "toast-top-right"]);
        
        return redirect(route('mes.gestion',$mes->gestion->id));
    }
}

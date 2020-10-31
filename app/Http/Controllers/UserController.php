<?php

namespace App\Http\Controllers;

use App\Imagen;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.config');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        
        $campos=array();
        $accept = request()->header('accept');
        $mensages=array();
        if($user->name!=$request->name){
            $campos['name']='required|unique:users';
            $mensages['name.required']='El Nombre de usuario es requerido.';
            $mensages['name.unique']='El nombre de usuario ya se encuentra registrado.';
            $user->name=$request->name;
        }
        if($user->email!=$request->email){
            $campos['email']='required|unique:users';
            $mensages['email.required']='El email es requerido.';
            $mensages['email.unique']='El email ya se encuentra registrado.';
            $user->email=$request->email;
        }

        if($request->password){
            $campos['password']='required|min:6';
            $mensages['password.required']='La contraseña es requerido.';
            $mensages['password.min']='La contraseña es muy corta.';
            $user->password=Hash::make($request->password);
        }
        $this->validate($request,$campos ,$mensages);

        $user->save();

        $res = strpos($accept,'application/json');
        
        if( $res == 0 ){
            return response()->json(['user'=>$user]);
        }else{
            return redirect(route('user.index')); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
    }

    public function uploadAvatar(Request $request,User $user)
    {
        if($user->avatar)
            $user->avatar->deleteWhitImg();

        $path = $request->file('file')->store('public');
        $img = new Imagen();
        $img->url=explode('/',$path)[1];
        $img->user_id = $user->id;
        $img->save();

        return response()->json(['msn'=>'imagen suvido exitosamente']);
    }
}

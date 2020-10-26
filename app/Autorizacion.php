<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    protected $table = 'autorizaciones';
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function gestion(){
        return $this->belongsTo(Gestion::class);
    }
    public static function obtenerNroAutorizacion($proveedorId,$gestionId)
    {
        return  Autorizacion::where('proveedor_id',$proveedorId)->where('gestion_id',$gestionId)->get()->last();
    }
}

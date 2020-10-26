<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table='proveedores';
    //
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
    public function autorizaciones(){
        return $this->hasMany(Autorizacion::class);
    }
}

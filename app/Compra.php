<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }
    public function mes()
    {
        return $this->belongsTo(Mes::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function mes()
    {
        return $this->belongsTo(Mes::class);
    }
}

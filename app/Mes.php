<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mes extends Model
{
    protected $table = 'meses';
    public function gestion(){
        return $this->belongsTo(Gestion::class);
    }
    
    public function compras()
    {
        return $this->HasMany(Compra::class);
    }
    public function ventas()
    {
        return $this->HasMany(Venta::class);
    }
    public function estadoCompras()
    {
        return $this->belongsTo(Estado::class,'estado_compras');
    }
    public function estadoVentas()
    {
        return $this->belongsTo(Estado::class,'estado_ventas');
    }
}

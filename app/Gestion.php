<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table='gestiones';
    public function meses(){
        return $this->hasMany(Mes::class);
    }
}

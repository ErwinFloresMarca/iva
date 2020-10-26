<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table='gestiones';
    public function meses(){
        return $this->hasMany(Mes::class);
    }
    public static function ultimaGestion()
    {
        $gestion=Gestion::orderBy('gestion')->get()->last();
        if($gestion==null){
            $gestion=new Gestion();
            $gestion->gestion= Date('Y');
            $gestion->save();
        }
        return $gestion;
    }
    public function autorizaciones(){
        return $this->hasMany(Autorizacion::class);
    }
}

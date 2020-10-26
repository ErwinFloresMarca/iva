<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UtilsVentas extends Model
{
    public static function getTamColumCarta(){
        //       espe    no.  fecha  no_fac  Auth   estado  nit    nom    impT  TASAS   Exen   cero  subT   Desc    base   deb    cod
        return ["25px","20px","45px","35px","60px","35px","60px","140px","45px","40px","45px","45px","50px","40px","60px","45px","40px"];
    }
    public static function sumPx($arr){
        $sum=0;
        foreach($arr as $pos)
            $sum+=str_replace("px","",UtilsVentas::getTamColumCarta()[$pos]);
        return $sum;
    }
    public static function formatDate($date){
        $atrib=explode('-',$date);
        return $atrib[2]."/".$atrib[1]."/".$atrib[0];
    }
    public static function getWithTwooDecimals($number){

        $number=round($number, 2);

        $vals=explode('.',''.$number);

        if(isset($vals[1])){

            if(strlen($vals[1])==2)

                return ''.$number;

            else

                return ''.$number.'0';

        }

        else

            return ''.$number.'.00';

    }

    public static function getStyle($pix){

        return "style='border: back 1 solid' width='".$pix."'";

    }
    public static function sumAllPx($vecPx){
        $sum=0;
        foreach($vecPx as $px)
            $sum+=str_replace('px','',$px);
        return $sum;
    }
}

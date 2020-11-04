<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    public static function getTamColum()
    {
        //       esp    no    fecha   nit    razon   fac    dui    aut   itcom  fiscal   sub   desc   base  cred    cod    tipo
        return ["30px","30px","50px","60px","281px","65px","50px","80px","70px","60px","50px","75px","60px","50px","65px","40px"];
    }
    public static function getTamColumCarta()
    {
        //       esp    no    fecha   nit    razon   fac    dui    aut   itcom  fiscal   sub   desc   base  cred    cod    tipo
        return ["25px","20px","45px","55px","200px","55px","40px","70px","55px","50px","45px","65px","50px","40px","65px","40px"];
    }
    public static function getTamColumExcel(){
        return ["4","4","12","13","39","10","7","19","11","11","10","12","11","9","15","8"];
    }
    public static function sumPx($arr){
        $sum=0;
        foreach($arr as $pos)
            $sum+=str_replace("px","",Utils::getTamColumCarta()[$pos]);
        return $sum;
    }
    public static function sum($arr){
        $sum=0;
        foreach($arr as $pos)
            $sum+=Utils::getTamColumExcel()[$pos];
        return $sum;
    }
    public static function formatDate($date){
        $atrib=explode('-',$date);
        return $atrib[2]."/".$atrib[1]."/".$atrib[0];
    }
    public static function getWhitTwooDecimals($number){

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

        return "style=\"border: back 1 solid\" width=\"".$pix."\"";

    }
    public static function sumAllPx($vecPx){
        $sum=0;
        foreach($vecPx as $px)
            $sum+=str_replace('px','',$px);
        return $sum;
    }

}

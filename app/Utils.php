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

        return "style=\"border: back 1px solid\" width=\"".$pix."\"";

    }
    public static function sumAllPx($vecPx){
        $sum=0;
        foreach($vecPx as $px)
            $sum+=str_replace('px','',$px);
        return $sum;
    }

}

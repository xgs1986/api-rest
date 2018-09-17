<?php
namespace AppBundle\Utils;

/**
 * Classe generica que permite:
 * - Dados dos geopoints, obtener la distancia entre ellos
 * - Validador de email
 * @author XGS
 *
 */
class Utilities 
{
    const COORDINATES_TO_KM = 6371;
        
    public static function getDistanceBetweenTwoPoints($lat1, $long1, $lat2, $long2)
    {
        $lat1 = deg2rad($lat1);
        $long1 = deg2rad($long1);
        
        $lat2 = deg2rad($lat2);
        $long2 = deg2rad($long2);
        
        $dlong = $long2 - $long1;
        $dlat = $lat2 - $lat1;
        
        $sinlat = sin($dlat / 2);
        $sinlong = sin($dlong / 2);
        
        $a = ($sinlat * $sinlat) + cos($lat1) * cos($lat2) * ($sinlong * $sinlong);
        
        $c = 2 * asin(min(1, sqrt($a)));
        
        return self::COORDINATES_TO_KM * $c;
    }
    
    public static function emailValidation($email)
    {
       return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

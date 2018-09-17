<?php
namespace AppBundle\Utils;

/**
 * Classe que hay las constantes de las queries a la base de datos.
 * @author XGS
 *
 */
class DataBaseQueries 
{
    const CALENDAR_RESERVATION_OVERLAP = 'SELECT COUNT(cr.car_id) AS total FROM AppBundle:CarReservation cr WHERE cr.car_id = :id AND :starttime < cr.endtime AND :endtime > cr.starttime';
    
    public static function lastReservationTime()
    {
        return self::CALENDAR_RESERVATION_OVERLAP;
    }
}

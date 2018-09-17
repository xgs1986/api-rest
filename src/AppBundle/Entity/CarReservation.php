<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="car_reservation")
 */
class CarReservation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $car_id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $starttime;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $endtime;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCar_id()
    {
        return $this->car_id;
    }

    /**
     * @return mixed
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * @return mixed
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $car_id
     */
    public function setCar_id($car_id)
    {
        $this->car_id = $car_id;
    }

    /**
     * @param mixed $starttime
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    }

    /**
     * @param mixed $endtime
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }
}
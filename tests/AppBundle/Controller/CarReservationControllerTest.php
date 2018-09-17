<?php
namespace tests\AppBundle\Controller;

use Tests\AppBundle\Lib\FunctionalTestsHelper;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CarReservation;

class CarReservationControllerTest extends FunctionalTestsHelper
{    
    private $firstReservation = array("id" => 255, "starttime" => 1, "endtime" => 3);
    private $secondReservation = array("id" => 255, "starttime" => 5, "endtime" => 8);
    private $errorConflict = array("id" => 255, "starttime" => 2, "endtime" => 6);
    private $badId = array("id" => "a", "starttime" => 3, "endtime" => 4);
    private $badStartTime = array("id" => 255, "starttime" => "a", "endtime" => 4);
    private $badEndTime = array("id" => 255, "starttime" => 3, "endtime" => "a");
    private $startBiggerThanEnd = array("id" => 255, "starttime" => 3, "endtime" => 1);
    
    private $carIdNoExist = array("id" => 999999, "starttime" => 1, "endtime" => 2);
    
    
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * Intento de reserva sin token
     */
    public function testNoTokenSend()
    {
        $response = $this->getPostRequestRespose("car/reservation", $this->firstReservation);    
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode()); 
    }
    
    /**
     * Intento de reserva con token invalido
     */
    public function testErrorTokenSend()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer errorToken");
        $response = $this->getPostRequestRespose("car/reservation", $this->firstReservation, $headers);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    
    /**
     * Intento de reserva con un id de coche que no existe.
     * Cargo unos mocks de respuesta para simular la lista de localizaciones y coches
     */
    public function testCarIdNotExistBadRequest()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());

        $response = $this->getPostRequestRespose("car/reservation", $this->carIdNoExist, $headers);
        $content = $this->getContentResponse($response);
        $this->assertEquals(FunctionalTestsHelper::FAILURE_STATUS, $content->Status);
    }
    
    /**
     * - Reservo dos e intento reservar uno que crea colision.
     * - Cuento cuantas reservas hay. Solo una porqué causa colisión la segunda.
     * - Finalmente reservo para una fecha intermedia entre las dos primeras
     */
    public function testCarAddTwoReservationsAndTestConflicts()
    {        
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        
        $response = $this->getPostRequestRespose("car/reservation", $this->firstReservation, $headers);
        $response = $this->getPostRequestRespose("car/reservation", $this->errorConflict, $headers);
        
        $cars = $this->entityManager->getRepository(CarReservation::class)->findAll();
        $this->assertEquals(1, count($cars));
        
        $response = $this->getPostRequestRespose("car/reservation", $this->secondReservation, $headers);
        $cars = $this->entityManager->getRepository(CarReservation::class)->findAll();
        $this->assertEquals(2, count($cars));
    }
    
    /**
     * Enviar id no numerico causa error
     */
    public function testIdNotGoodFormed()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getPostRequestRespose("car/reservation", $this->badId, $headers);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    
    /**
     * Enviar startime no numerico causa error
     */
    public function testStartTimeNotGoodFormed()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getPostRequestRespose("car/reservation", $this->badStartTime, $headers);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    
    /**
     * Enviar endtime no numerico causa error
     */
    public function testEndTimeNotGoodFormed()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getPostRequestRespose("car/reservation", $this->badEndTime, $headers);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    
    /**
     * Enviar endtime menor que start time causa error
     */
    public function testStartTimeBiggerThanEndTime()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getPostRequestRespose("car/reservation", $this->startBiggerThanEnd, $headers);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    
    
    public function tearDown()
    {
        parent::tearDown();
    }
}

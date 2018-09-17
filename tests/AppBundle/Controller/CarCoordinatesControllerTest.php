<?php
namespace tests\AppBundle\Controller;

use Tests\AppBundle\Lib\FunctionalTestsHelper;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class CarCoordinatesControllerTest extends FunctionalTestsHelper
{
    private $goodRequest = array("km" => 1.5, "latitude" => 49.286651, "longitude" => -123.139235);
    private $badKm = array("km" => "a", "latitude" => 49.286651, "longitude" => -123.139235);
    private $badLatitude = array("km" => 2.5, "latitude" => "a", "longitude" => -123.139235);
    private $badLongitude = array("km" => 2.5, "latitude" => 49.286651, "longitude" => "a");
    
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * Intento de obtener coordenadas sin token
     */
    public function testGeoByLatitudeLongitudeKm()
    {        
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getGetRequestRespose("car/coordinates" , $this->goodRequest, $headers);
        $content = $this->getContentResponse($response);
        
        $this->assertEquals(FunctionalTestsHelper::SUCCESS_STATUS, $content->Status);
        $this->assertGreaterThan(0, $content->Response[1]->CarCount);
    }    
    
    /**
     * Intento de obtener coordenadas sin token
     */
    public function testNoTokenSend()
    {
        $response = $this->getGetRequestRespose("car/coordinates" , $this->goodRequest);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    
    /**
     * Intento obtener coordenadas con token invalido
     */
    public function testErrorTokenSend()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer errorToken");
        $response = $this->getGetRequestRespose("car/coordinates" , $this->goodRequest, $headers);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    
    /**
     * Intento obtener coordenadas con km string
     */
    public function testBadKmError()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getGetRequestRespose("car/coordinates" , $this->badKm, $headers);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    
    /**
     * Intento obtener coordenadas con latitud string
     */
    public function testBadLatitudeError()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getGetRequestRespose("car/coordinates" , $this->badLatitude, $headers);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    
    /**
     * Intento obtener coordenadas con longitud string
     */
    public function testBadLongitudeError()
    {
        $headers = array('HTTP_AUTHORIZATION' => "Bearer " . $this->getRootToken());
        $response = $this->getGetRequestRespose("car/coordinates" , $this->badLongitude, $headers);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    
    public function tearDown()
    {
        parent::tearDown();
    }
}
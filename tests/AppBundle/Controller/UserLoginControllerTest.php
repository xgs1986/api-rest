<?php
namespace tests\AppBundle\Controller;

use Tests\AppBundle\Lib\FunctionalTestsHelper;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserLoginControllerTest extends FunctionalTestsHelper
{
    const CORRECT = "root";
    const ERROR = "rrot";
    
    private $badUser = array("username" => self::ERROR, "password" => self::CORRECT);
    private $badPass = array("username" => self::CORRECT, "password" => self::ERROR);
    
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * Miramos si al loguearnos nos da el token
     * - Contamos usuarios iniciales
     * - Nos logueamos como root
     * - El token tiene valor
     */
    public function testCorrectLogin()
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        
        $response = $this->getPostRequestRespose("login", $this->correctUser);        
        $content = $this->getContentResponse($response);
        
        $this->assertEquals(1, count($users));
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(FunctionalTestsHelper::SUCCESS_STATUS, $content->Status);
        $this->assertTrue(strlen($content->Response->token) > 0);
    }
    
    /**
     * Error acceso no autorizado en caso de introducir mal el usuario
     */
    public function testBadUserLogin()
    {
        $response = $this->getPostRequestRespose("login", $this->badUser);
        $content = $this->getContentResponse($response);
        
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertEquals(FunctionalTestsHelper::FAILURE_STATUS, $content->Status);
    }
    
    /**
     * Error al introducir mal el password
     */
    public function testBadPasswordLogin()
    {
        $response = $this->getPostRequestRespose("login", $this->badPass);
        $content = $this->getContentResponse($response);
        
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertEquals(FunctionalTestsHelper::FAILURE_STATUS, $content->Status);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}

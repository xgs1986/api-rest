<?php
namespace tests\AppBundle\Controller;

use Tests\AppBundle\Lib\FunctionalTestsHelper;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends FunctionalTestsHelper
{
    const USER_REPLY = "root"; 
    const EMAIL_REPLY = "root@root.com";
    
    const NEW_USER_USER = "new";
    const NEW_USER_EMAIL = "new@root.com";
    const NEW_USER_PASS = "new";
    
    const NEW_USER_USER_ADD = "new_add";
    const NEW_USER_EMAIL_ADD = "new_add@root.com";
    const NEW_USER_PASS_ADD = "new_add";
    
    const BAD_EMAIL_FORMATER = "email@withoutformat";
    
    private $userDuplicated = array("email" => self::NEW_USER_EMAIL, "username" => self::USER_REPLY, "password" => self::NEW_USER_PASS);
    private $emailDuplicated = array("email" => self::EMAIL_REPLY, "username" => self::NEW_USER_USER, "password" => self::NEW_USER_PASS);
    private $emailMalFormatted = array("email" => self::BAD_EMAIL_FORMATER, "username" => self::NEW_USER_USER, "password" => self::NEW_USER_PASS);
    private $newUser = array("email" => self::NEW_USER_EMAIL_ADD, "username" => self::NEW_USER_USER_ADD, "password" => self::NEW_USER_PASS_ADD);
    
    public function setUp()
    {
        parent::setUp();
    }
    
    /**
     * Testeamos si se añade el usuario
     * - Miramos los usuarios iniciales
     * - Añadimos un usuario nuevo
     * - Miramos si el añadido tiene el email deseado
     * - Contamos si hay 2 usuarios
     */
    public function testRegisterNewUser()
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $this->assertEquals(1, count($users));
        
        $response = $this->getPostRequestRespose("register", $this->newUser);
        $contents = $this->getContentResponse($response);
        
        $this->assertEquals(FunctionalTestsHelper::SUCCESS_STATUS, $contents->Status);
        
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $this->assertEquals(2, count($users));
        
        $newUser = $this->entityManager->getRepository(User::class)->findBy(array("username" => self::NEW_USER_USER_ADD));
        $this->assertEquals($newUser[0]->getEmail(), self::NEW_USER_EMAIL_ADD);
    }
    
    
    /**
     * Error cuando intentamos añadir un usuario con username existente
     */
    public function testDuplicatedUserNameError()
    {
        $response = $this->getPostRequestRespose("register", $this->userDuplicated);
        $contents = $this->getContentResponse($response);
        
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(FunctionalTestsHelper::FAILURE_STATUS, $contents->Status);
    }
    
    /**
     * Error cuando intentamos añadir un usuario con email existente
     */
    public function testDuplicatedEmailError()
    {
        $response = $this->getPostRequestRespose("register", $this->emailDuplicated);
        $contents = $this->getContentResponse($response);
        
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(FunctionalTestsHelper::FAILURE_STATUS, $contents->Status);
    }
    
    /**
     * Error cuando intentamos añadir un usuario con email en mal formato
     */
    public function testDuplicatedMalformatterEmailError()
    {
        $response = $this->getPostRequestRespose("register", $this->emailMalFormatted);
        $contents = $this->getContentResponse($response);
        
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals(FunctionalTestsHelper::FAILURE_STATUS, $contents->Status);
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}

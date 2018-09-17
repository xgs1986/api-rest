<?php
namespace tests\AppBundle\Lib;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FunctionalTestsHelper extends WebTestCase
{
    const BASE_PATH = "http://localhost:8000/";
    const SUCCESS_STATUS = "Success";
    const FAILURE_STATUS = "Failure";
    const CORRECT = "root";
    
    protected $correctUser = array("username" => self::CORRECT, "password" => self::CORRECT);
   
    protected static $application;
    protected $client;
    protected $container;
    protected $entityManager;
    
    /**
     * Burning de los tests. 
     * - Eliminamos la base de datos de test en caso que exista
     * - Creamos la base de datos test_modo
     * - Creamos las tablas
     * - Insertamos SIEMPRE el usuario root DataFixtures\ORM\LoadUserData
     */
    public function setUp()
    {
        self::runCommand('doctrine:database:drop --force');
        self::runCommand('doctrine:database:create --env=test');
        self::runCommand('doctrine:schema:create');
        self::runCommand('doctrine:fixtures:load --append --no-interaction');
        
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
        
        parent::setUp();
    }
    
    public function getPostRequestRespose($url, $body, $headers = []) 
	{
	    $this->client->request('POST', self::BASE_PATH . $url, $body, [], $headers);
	  
	    return $this->client->getResponse();
	}
	
	public function getGetRequestRespose($url, $params, $headers = [])
	{
	    $queryString = "";
	    foreach ($params as $param => $value)
	    {
	        $queryString.= $param . "=" . $value . "&";  
	    }
	    
	    $this->client->request('GET', self::BASE_PATH . $url . "?" . $queryString, [], [], $headers);
	    
	    return $this->client->getResponse();
	}
	
	public function getContentResponse($response)
	{
	    return (json_decode($response->getContent()));
	}
	
	protected static function runCommand($command)
	{
	    $command = sprintf('%s --quiet', $command);
	    
	    return self::getApplication()->run(new StringInput($command));
	}
	
	protected static function getApplication()
	{
	    if (null === self::$application) {
	        $client = static::createClient();
	        
	        self::$application = new Application($client->getKernel());
	        self::$application->setAutoExit(false);
	    }
	    
	    return self::$application;
	}
	
	/**
	 * Eliminamos la base de datos de test_modo
	 * {@inheritDoc}
	 * @see \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase::tearDown()
	 */
	protected function tearDown()
	{
	    self::runCommand('doctrine:database:drop --force');
	    
	    parent::tearDown();
	    
	    $this->entityManager->close();
	    $this->entityManager = null; 
	}
	
	/**
	 * genero el token para usuario root
	 * @return token
	 */
	protected function getRootToken()
	{
	    $response = $this->getPostRequestRespose("login", $this->correctUser);
	    $content = $this->getContentResponse($response);
	    return $content->Response->token;
	}
}
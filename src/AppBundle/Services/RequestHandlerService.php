<?php
namespace AppBundle\Services;

use AppBundle\Services\ClientFactory;
use AppBundle\Entity\Common\HTTPResponseEntity;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Servicio que nos genera una response, dada una request usando un cliente guzzle
 * @author XGS
 *
 */
class RequestHandlerService 
{
	private $clientFactory;

	public function __construct()
	{
		$this->clientFactory = new ClientFactory();
	}
	
	public function getResponse($request) 
	{		
	    $response = $this->clientFactory->createResponse($request);
		try 
		{
		    return new HTTPResponseEntity($response);    
		}
		
		catch (\Exception $e) 
		{
			$statusCodeError = $e->getCode();
			throw new HttpException($statusCodeError, $e->getMessage());
		}
	}
}

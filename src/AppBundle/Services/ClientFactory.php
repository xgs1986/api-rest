<?php
namespace AppBundle\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

/**
 * Nos crea un servicio de guzzle para realizar request. 
 * Se ha creado un servicio para esto de tal forma que sea más sencillo si en un futuro se decide cambiar de cliente tenerlo todo centralizado aquí
 * @author XGS
 *
 */
class ClientFactory 
{
	public function __construct()
	{
		
	}

	public function createResponse($request)
	{
	    $handlerStack = HandlerStack::create();
	    $client = new Client(['handler' => $handlerStack]);
	    return $client->request($request['protocol'], $request['baseURL']);
	}
}
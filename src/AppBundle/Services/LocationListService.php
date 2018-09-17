<?php
namespace AppBundle\Services;

use AppBundle\Utils\ModoHandlerRequest;

/**
 * Nos permite obtener el listado de localizaciones de la api modo
 * @author XGS
 *
 */
class LocationListService implements ModoHandlerRequest {
    
    private $path;
    private $requestHandler;
    private $response;
    
    
    public function __construct($requestHandler, $path)
    {
        $this->requestHandler = $requestHandler;
        $this->path = $path;
    }
   
    public function getContents()
    {
        $request = array();
        $request['baseURL'] = $this->path;
        $request['protocol'] = "GET";
        $response = $this->requestHandler->getResponse($request);
        return $response->getDecodeContents()->Response->Locations;
    }
}

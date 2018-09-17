<?php
namespace AppBundle\Services;

use AppBundle\Utils\ModoHandlerRequest;
use AppBundle\Utils\ApiException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Servicio que nos permite obtener la respuesta de la api modo guardando los datos de los vehículos
 * @author XGS
 *
 */
class CarListService implements ModoHandlerRequest {
    
    private $path;
    private $requestHandler;
    private $response;
    
    const NO_CAR_FOUND = "NO_CAR_FOUND";
    
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
        return $response->getDecodeContents()->Response->Cars;
    }
 
    public function hasCarIdInList($carList, $id)
    {
        try
        {
            return $carList->$id;
        }
        
        catch (\Exception $e)
        {
            throw new ApiException("Car doesn't exist", Response::HTTP_BAD_REQUEST);
        }
    }
}

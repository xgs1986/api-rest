<?php
namespace AppBundle\Services;

use AppBundle\Entity\CarReservation;
use AppBundle\Utils\DataBaseQueries;
use AppBundle\Utils\Utilities;
use AppBundle\Utils\ApiException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Servicio que se engancha con el controller. Recibe la lista de vehículos, la lista de localizaciones, el servicio de doctrine y el servicio de vistas.
 * @author XGS
 *
 */
class CarService {

	private $dataBaseConnection;
	private $responseView;
	private $carListService;
	private $locationListService;

	public function __construct($carListService, $locationListService, $dataBaseConnection, $responseView)
	{	    
	    $this->carListService = $carListService;
	    $this->locationListService = $locationListService;
	    $this->dataBaseConnection = $dataBaseConnection;
	    $this->responseView = $responseView;
	}

	public function reservation($request) 
	{
	    $carList = $this->carListService->getContents();
	    $id = $request->get('id');
	    $startTime = $request->get('starttime');
	    $endTime = $request->get('endtime');
	    
	    if (!is_numeric($id) || !is_numeric($startTime) || !is_numeric($endTime))
	    {
	        throw new ApiException("All values must be integers.", Response::HTTP_BAD_REQUEST);
	    }
	    
	    $this->carListService->hasCarIdInList($carList, $id);
	
        return $this->newReservation($request);
	}
	
	public function getAllCarsInsideKmDistance($request)
	{
	    $requestLatitude = $request->get('latitude');
	    $requestLongitude = $request->get('longitude');
	    $requestKm = $request->get('km');
	    
	    if (!is_numeric($requestLatitude) || !is_numeric($requestLongitude) || !is_numeric($requestKm) )
	    {
	        throw new ApiException("Provide all numeric values.", Response::HTTP_BAD_REQUEST);
	    }
	    
	    $cars = array();
	    $carList = $this->carListService->getContents();
	    $locationList = $this->locationListService->getContents();

	    foreach ($carList as $car) 
	    {
	        $idLocation = $car->Location[0]->LocationID;
	        $carLatitude = $locationList->$idLocation->Latitude;
	        $carLongitude = $locationList->$idLocation->Longitude;
	        
	        $distance = Utilities::getDistanceBetweenTwoPoints($requestLatitude, $requestLongitude, $carLatitude, $carLongitude);
	        if ($distance <= $requestKm) 
	        {
	            array_push($cars, array ("ID" => $car->ID));
	        }
	    }

	    $carIds = array("Cars" => $cars);
	    $total = array("CarCount" => count(array_filter($cars)));
	    return $this->responseView->getSuccessView(array($carIds, $total));
	}
	
	private function newReservation($request) 
	{
	    $id = $request->get('id');
	    $starttime =  $request->get('starttime');
	    $endtime =  $request->get('endtime');
	    
	    if ($endtime <= $starttime) 
	    {
	        throw new ApiException("End time must be greater than Start time. Please, provide another one.", Response::HTTP_BAD_REQUEST);
	    }
	    
	    $filter = array ("id" => array($id), "starttime" => array($starttime), "endtime" => array($endtime));
	    $overlapReservation = $this->dataBaseConnection->doQuery(DataBaseQueries::lastReservationTime(), $filter)[0]['total'];
	    if ($overlapReservation > 0) 
	    {
	        throw new ApiException("There is a overlap with another reservation. Please, provide another one.", Response::HTTP_BAD_REQUEST);
	    }

	    $carReservation = new CarReservation();
	    $carReservation->setCar_id($id);
	    $carReservation->setStarttime($starttime);
	    $carReservation->setEndtime($endtime);
	    $this->dataBaseConnection->persist($carReservation);    
	    
	    return $this->responseView->getSuccessView("Car has been reserved");
	}
}
<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controllador que permite obtener las coordenadas de los vehículos
 * @author XGS
 *
 */
class RestCarCoordinatesController extends FOSRestController 
{
    /**
     * @SWG\Get(
     *     tags={"cars"},
     *     summary="Get the list of cars given a latitude and longitude that are at a maximum distance of given km",
     *     @SWG\Parameter(
     *         name="km",
     *         in="query",
     *         description="maximum distance in km",
     *         required=true,
     *         type="number",
     *         default= "2.5"
     *     ),
     *     @SWG\Parameter(
     *         name="latitude",
     *         in="query",
     *         description="car latitude",
     *         required=true,
     *         type="number",
     *         default= "49.286651"
     *     ),
     *      @SWG\Parameter(
     *         name="longitude",
     *         in="query",
     *         description="car longitude",
     *         required=true,
     *         type="number",
     *         default= "-123.139235"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Get all cars by latitude/longitude given"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Bad credentials"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Bad request"
     *     )
     * )
     * 
     * @Route("/car/coordinates", methods={"GET"})
     *
     * @param Request $request
     */

    public function getCarCoordinatesAction (Request $request)
    {
        $context = $this->get('car_service');
        $view = $context->getAllCarsInsideKmDistance($request);
        return $this->handleView($view);
    }  
}
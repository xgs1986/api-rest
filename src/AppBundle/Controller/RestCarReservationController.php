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
 * Controllador que permite crear una reserva de un coche
 * @author XGS
 *
 */
class RestCarReservationController extends FOSRestController
{
    /**
     * @Operation(
     *     tags={"cars"},
     *     consumes={"multipart/form-data"},
     *     summary="This endpoint makes a car reservation given from/until dates",
     *     @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         description="car id",
     *         required=true,
     *         type="integer",
     *         default="947"
     *     ),
     *     @SWG\Parameter(
     *         name="starttime",
     *         in="formData",
     *         description="From date reservation",
     *         required=true,
     *         type="integer",
     *         default="1536858000"
     *     ),
     *     @SWG\Parameter(
     *         name="endtime",
     *         in="formData",
     *         description="Until date reservation",
     *         required=true,
     *         type="integer",
     *         default="1537286400"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Create new car reservation"
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
     * @Route("/car/reservation", methods={"POST"})
     *
     * @param Request $request
     */

    public function postCarReservationAction (Request $request)
    {
        $context = $this->get('car_service');
        $view = $context->reservation($request);   
        return $this->handleView($view);
    }  
}
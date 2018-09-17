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
 * Nos permite registrarnos en la base de datos
 * @author XGS
 *
 */
class RestUserRegisterController extends FOSRestController 
{
    /**
     * @Operation(
     *     tags={"users"},
     *     consumes={"multipart/form-data"},
     *     summary="This endpoint makes the register possible",
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="Email",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="username",
     *         in="formData",
     *         description="User Name",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Password",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when the register process is successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Bad request"
     *     )
     * )
     * 
     * @Route("register", methods={"POST"})
     * 
     */

    public function postRegisterAction (Request $request)
    {         
         $context = $this->get('user_service'); 
         $view = $context->register($request);  
         return $this->handleView($view);
    }  
}
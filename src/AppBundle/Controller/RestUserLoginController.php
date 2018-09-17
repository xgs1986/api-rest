<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;

/**
 * Permite loguearnos en la API
 * @author XGS
 *
 */
class RestUserLoginController extends FOSRestController implements ClassResourceInterface
{
    /**
      * @Operation(
     *     tags={"users"},
     *     consumes={"multipart/form-data"},
     *     summary="This endpoint makes the authentication possible",
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
     *         response="200",
     *         description="Returned when the login process is successful"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Returned when the user has not provided his credentials correctly"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Bad request"
     *     )
     * )
     * 
     * @Route("login", methods={"POST"})
     * 
     */
    public function postAction()
    {
        throw new \DomainException('JWTAuthentication');
    }
}
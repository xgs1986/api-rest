<?php

namespace AppBundle\Controller;

use AppBundle\Utils\ApiException;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Controllador de captura de excepciones
 * @author XGS
 */
class ExceptionController extends FOSRestController 
{
    public function showErrorAction($exception)
    {
        if (!$exception instanceof ApiException && !$exception instanceof HttpException) 
        {
            $exception = new HttpException($this->getStatusCode($exception), $this->getStatusText($exception));
        }
        
        if ($exception instanceof HttpException) 
        {
            $exception = new ApiException($this->getStatusText($exception), $this->getStatusCode($exception));
        }
        
        $error = $exception->getErrorDetails();
                
        $responseService = $this->get('response_view_service');
    
        return $responseService->getFailureView(array(['error' => $error]));
    }
    
    protected function getStatusCode(\Exception $exception)
    {
        if ($statusCode = $this->get('fos_rest.exception.codes_map')->resolveException($exception)) 
        {
            return $statusCode;
        }
        
        if ($exception instanceof HttpExceptionInterface) 
        {
            return $exception->getStatusCode();
        }
        
        return 500;
    }
    
    protected function getStatusText(\Exception $exception, $default = 'Internal Server Error')
    {
        $code = $this->getStatusCode($exception);
        
        return array_key_exists($code, Response::$statusTexts) ? Response::$statusTexts[$code] : $default;
    }
}
<?php
namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\Response;

/**
 * Classe estructura de los ApiException
 * @author XGS
 *
 */
class ApiException extends \Exception
{
    const DEFAULT_MESSAGE = "API Exception";
    
    protected $message; 
    protected $statusCode;
    
    public function __construct($message, $statusCode)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
    }
    
    public function getErrorDetails()
    {
        
        return [
            'code' => $this->statusCode ?: Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $this->message ? : self::DEFAULT_MESSAGE
        ];
    }
}
<?php
namespace AppBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;

use AppBundle\Utils\ApiException;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationExpiredException;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;

/**
 * Clase que captura los eventos de autentificación y nos da una respuesta para cada uno de ellos.
 */
class AuthenticationListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $result = array(
            'Status' => "Success",
            'Response' => $event->getData()
        );
        
        $event->setData($result);
    }
    
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        throw new ApiException("Bad credentials", 401);
    }
    
    public function onAuthenticationNotFoundResponse(JWTNotFoundEvent $event)
    {
        throw new ApiException("Token must be setter.", 401);
    }
    
    public function onAuthenticationExpiredResponse(JWTExpiredEvent $event)
    {
        throw new ApiException("Token has been expired.", 401);
    }
    
    public function onAuthenticationJwtInvalidResponse(JWTInvalidEvent $event)
    {
        throw new ApiException("Invalid JWT Token", 401);
    }
}
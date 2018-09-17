<?php
namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Utils\Utilities;
use AppBundle\Utils\ApiException;
use Symfony\Component\HttpFoundation\Response;

use JMS\Serializer\SerializationContext;

/**
 * Clase de enganche con los controladores de usuarios. Permite registrarse y loguearse
 * @author XGS
 *
 */
class UserService 
{
	private $userManager;
	private $responseView;

	public function __construct($userManager, $responseView)
	{
	    $this->userManager = $userManager;
	    $this->responseView = $responseView;
	}

	public function register($request)
	{
	    $email = $request->get('email');
	    $isValidEmail = Utilities::emailValidation($email);
	    if (!$isValidEmail)
	    {
	        throw new ApiException("Email format isn't valid.", Response::HTTP_BAD_REQUEST);
	    }
	        
	    $username = $request->get('username');
	    $password = $request->get('password');
	    
	    $emailExist = $this->userManager->findUserByEmail($email);
	    $userExist = $this->userManager->findUserByUsername($username);
	    
	    if($userExist || $emailExist)
	    {
	        throw new ApiException("User or email exist.", Response::HTTP_BAD_REQUEST);
	    }
	    
	    $this->createUser($email, $username, $password);
	   
	    return $this->responseView->getSuccessView("User has been created");
	}

	private function createUser($email, $username, $password) 
	{
	    $user = $this->userManager->createUser();
	    $user->setUsername($username);
	    $user->setEmail($email);
	    $user->setEmailCanonical($email);
	    $user->setEnabled(1);
	    $user->setPlainPassword($password);
	    $this->userManager->updateUser($user);
	}
}

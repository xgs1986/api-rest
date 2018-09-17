<?php
namespace AppBundle\Services;

use FOS\RestBundle\View\View;

/**
 * Servicio que nos genera las vistas que recogeran los controladores en caso de error y success. De tal forma que si queremos cambiar las respuestas, ya lo tenemos aquí centralizado
 * @author XGS
 *
 */
class ResponseViewService 
{
	private $format = "json";

	public function __construct()
	{
	    
	}

	public function getSuccessView($data)
	{
	    $result = array(
	        'Status' => "Success",
	        'Response' => $data
	    );
	    
	    return $this->getView($result);
	}
	
	public function getFailureView($data)
	{
	    $result = array(
	        'Status' => "Failure",
	        'Response' => $data
	    );
	    
	    $headers = array(
	        "code" => $data[0]['error']['code'],
	        "message" => $data[0]['error']['message']
	    );
	   	    
	    return $this->getView($result, $headers);
	}
	
	private function getView($data, $headers = null)
	{
	    $view = View::create()
	            ->setFormat($this->format)
	            ->setData($data);
	    
	    if ($headers !== null) 
	    {
	        $view->setHeaders($headers)->setStatusCode($headers['code']);
	    }
	     
	    return $view;
	}
}

<?php
namespace AppBundle\Entity\Common;

/**
 * Entidad que nos guarda la respuesta en un objeto más "amigable"
 * @author XGS
 *
 */
class HTTPResponseEntity
{
    private $response;
    private $body;
    private $contents;
    private $headers;

    public function __construct($response)
    {
        $this->response = $response;
  		$this->body = $response->getBody();
        
        if (is_string($this->body)) 
        {
            $this->contents = $this->body;
        } 
        
        else
        {
   	        $this->contents = $this->body->getContents();
		}
		
        $this->headers = $response->getHeaders();
    }

    public function getContents()
    {
   	    return $this->contents;
    }
    
    public function getDecodeContents()
    {
        return json_decode($this->contents);
    }
}

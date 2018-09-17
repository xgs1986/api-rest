<?php
namespace AppBundle\Services;

/**
 * Servicio que nos permite operar con la base de datos con el framework doctrine. 
 * Se ha hecho un servicio para no ligar el acceso a la base de datos, al doctrine y tener que modificar todas las referencias en todo el proyecto
 * @author XGS
 *
 */
class DatabaseConnectionService 
{
    private $doctrine;
    
	public function __construct($doctrine)
	{
	    $this->doctrine = $doctrine;
	}

	public function getRepository ($className)
	{
	    return $this->doctrine->getRepository($className);
	}
	
	public function doQuery($sqlQuery, $filterParameters = null)
	{
	    $query = $this->doctrine->createQuery($sqlQuery);
	    
 	    foreach ($filterParameters as $field => $value)
 	    {
 	        $query->setParameter($field, $value);    
 	    }

	    return $query->getResult();
	}
	
	public function persist ($element)
	{
	    $this->doctrine->persist($element);
	    $this->doctrine->flush();
	}
}
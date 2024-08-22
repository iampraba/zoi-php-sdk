<?php 
namespace com\zoho\officeintegrator\dc\apiserver;

use com\zoho\api\authenticator\Location;
use com\zoho\officeintegrator\dc\Environment;

class Production extends Environment
{

	private  $serverDomain;

	/**
	 * Creates an instance of Production with the given parameters
	 * @param string $serverDomain A string
	 */
	public function __construct(string $serverDomain)
	{
		$this->serverDomain=$serverDomain; 

	}

	/**
	 * The method to get Url
	 * @return string | null A string representing the Url
	 */
	public  function getUrl()
	{
		return '' . $this->serverDomain . ''; 

	}

	/**
	 * The method to get dc
	 * @return string | null A string representing the dc
	 */
	public  function getDc()
	{
		return 'alldc'; 

	}

	/**
	 * The method to get location
	 * @return Location | null An instance of Location
	 */
	public  function getLocation()
	{
		return null; 

	}

	/**
	 * The method to get name
	 * @return string | null A string representing the name
	 */
	public  function getName()
	{
		return ""; 

	}

	/**
	 * The method to get value
	 * @return string | null A string representing the value
	 */
	public  function getValue()
	{
		return ""; 

	}
} 

<?php 
namespace com\zoho\officeintegrator\dc;

use com\zoho\api\authenticator\Location;
use com\zoho\officeintegrator\dc\apiserver\Production;

class APIServer
{

	/**
	 * The method to get the production
	 * @param string $serverDomain A string
	 * @return Production | null An instance of Production
	 */
	public  function getProduction(string $serverDomain)
	{
		return new Production($serverDomain); 

	}
} 

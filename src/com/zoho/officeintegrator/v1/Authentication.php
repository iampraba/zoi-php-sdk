<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\api\authenticator\AuthenticationSchema;
use com\zoho\api\authenticator\AuthenticationType;

class Authentication
{

	/**
	 * The method to get the tokenFlow
	 * @return TokenFlow | null An instance of TokenFlow
	 */
	public  function getTokenFlow()
	{
		return new TokenFlow(); 

	}
} 

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\api\authenticator\AuthenticationSchema;
use com\zoho\api\authenticator\AuthenticationType;

class TokenFlow extends AuthenticationSchema
{

	/**
	 * The method to get Token Url
	 * @return string | null A string representing the TokenUrl
	 */
	public  function getTokenUrl()
	{
		return '/zest/v1/__internal/ticket'; 

	}

	/**
	 * The method to get Authentication Url
	 * @return string | null A string representing the AuthenticationUrl
	 */
	public  function getAuthenticationUrl()
	{
		return ""; 

	}

	/**
	 * The method to get Refresh Url
	 * @return string | null A string representing the RefreshUrl
	 */
	public  function getRefreshUrl()
	{
		return ''; 

	}

	/**
	 * The method to get Schema
	 * @return string | null A string representing the Schema
	 */
	public  function getSchema()
	{
		return 'TokenFlow'; 

	}

	/**
	 * The method to get Authentication Type
	 * @return AuthenticationType | null An instance of AuthenticationType
	 */
	public  function getAuthenticationType()
	{
		return AuthenticationType::TOKEN(); 

	}
} 

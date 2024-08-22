<?php
namespace com\zoho\api\authenticator;

use com\zoho\officeintegrator\util\APIHTTPConnector;

/**
 * This interface verifies and sets token to APIHTTPConnector instance.
 */
interface Token
{
    /**
	 * This method to set authentication token to APIHTTPConnector instance.
	 * 
	 * @param APIHTTPConnector $urlConnection A APIHTTPConnector class instance.
	 */
    public function authenticate(APIHTTPConnector $urlConnection, $config);

	public function remove();

	public function generateToken();

	public function getId();

	public function getAuthenticationSchema();
}

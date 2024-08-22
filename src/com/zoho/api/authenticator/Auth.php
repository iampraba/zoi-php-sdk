<?php
namespace com\zoho\api\authenticator;

use com\zoho\officeintegrator\util\APIHTTPConnector;

class Auth implements Token
{
    private $authenticationSchema;
    private $parameterMap = array();
    private $headerMap = array();

    private function __construct($parameterMap, $headerMap, $authenticationSchema)
    {
        $this->parameterMap = $parameterMap;
        $this->headerMap = $headerMap;
        $this->authenticationSchema = $authenticationSchema;
    }

    public function getAuthenticationSchema()
    {
        return $this->authenticationSchema;
    }

    public function setAuthenticationSchema(AuthenticationSchema $authenticationSchema)
    {
        $this->authenticationSchema = $authenticationSchema;
    }

    public function authenticate(APIHTTPConnector $urlConnection, $config)
    {
        if($this->headerMap != null)
        {
            foreach ($this->headerMap as $key => $value)
            {
                $urlConnection->addHeader($key, $value);
            }
        }
        if($this->parameterMap != null)
        {
            foreach ($this->parameterMap as $key => $value)
            {
                $urlConnection->addParam($key, $value);
            }
        }
    }

    public function remove()
    {
    }

    public function generateToken()
    {
    }

    public function getId()
    {
        return null;
    }
}

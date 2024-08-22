<?php
namespace com\zoho\api\authenticator;

class AuthBuilder
{
    private $authenticationSchema;
    private $parameterMap = array();
    private $headerMap = array();

    public function addParam($paramName, $paramValue)
    {
        if(array_key_exists($paramName, $this->parameterMap) && $this->parameterMap[$paramName] != null)
        {
            $existingParamValue = $this->parameterMap[$paramName];
            $existingParamValue = $existingParamValue . "," . $paramValue;
            $this->parameterMap[$paramName] = $existingParamValue;
        }
        else
        {
            $this->parameterMap[$paramName] = $paramValue;
        }
        return $this;
    }

    public function addHeader($headerName, $headerValue)
    {
        if(array_key_exists($headerName, $this->headerMap) && $this->headerMap[$headerName] != null)
        {
            $existingParamValue = $this->headerMap[$headerName];
            $existingParamValue = $existingParamValue . "," . $headerValue;
            $this->headerMap[$headerName] = $existingParamValue;
        }
        else
        {
            $this->headerMap[$headerName] = $headerValue;
        }
        return $this;
    }

    public function parameterMap($parameterMap)
    {
        $this->parameterMap = $parameterMap;
        return $this;
    }

    public function headerMap($headerMap)
    {
        $this->headerMap = $headerMap;
        return $this;
    }

    public function authenticationSchema($authenticationSchema)
    {
        $this->authenticationSchema = $authenticationSchema;
        return $this;
    }

    public function build()
    {
        $class = new \ReflectionClass(Auth::class);
        $constructor = $class->getConstructor();
        $constructor->setAccessible(true);
        $object = $class->newInstanceWithoutConstructor();
        $constructor->invoke($object, $this->parameterMap, $this->headerMap, $this->authenticationSchema);
        return $object;
    }
}
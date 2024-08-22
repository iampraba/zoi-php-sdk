<?php
namespace com\zoho\officeintegrator\util;

class TextConverter extends Converter
{
    public function __construct($commonAPIHandler)
    {
        parent::__construct($commonAPIHandler);
    }

    public function getWrappedRequest($response, $pack)
	{
		return null;
	}

    public function formRequest($requestObject, $pack, $instanceNumber, $classMemberDetail = NULL, $groupType = NULL)
    {
        return null;
    }

    public function appendToRequest(&$requestBase, $requestObject)
    {
        return null;
    }

    public function getWrappedResponse($response, $contents)
    {
        list ($headers, $content) = explode("\r\n\r\n", strval($response), 2);
        $responseObject = json_decode($content, true);
        if ($responseObject == NULL && $content != null)
        {
            list ($headers, $content) = explode("\r\n\r\n", $content, 2);
            $responseObject = json_decode($content, true);
        }
        if ($responseObject != null)
        {
            return [$this->getResponse($responseObject,  null, null), null];
        }
        return null;
    }

    public function getResponse($response, $pack, $groupType)
    {
        return null; 
    }
}

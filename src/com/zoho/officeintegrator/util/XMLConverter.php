<?php
namespace com\zoho\officeintegrator\util;

/**
 * This class processes the API response object to the POJO object and POJO object to an XML object.
 */
class XMLConverter extends Converter
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

    public function getWrappedResponse($responseObject, $contents)
    {
        return [$this->getResponse($responseObject, null, null), null];
    }

    public function getResponse($response, $pack, $groupType)
    {
        return null; 
    }
}
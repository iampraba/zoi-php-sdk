<?php
namespace com\zoho\officeintegrator\util;

use com\zoho\officeintegrator\Initializer;
use com\zoho\officeintegrator\util\Constants;

/**
 * This class is to process the download file and stream response.
 */
class Downloader extends Converter
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
        if(count($contents) >= 1)
        {
            $pack = $contents[0];
            list ($headers, $content) = explode("\r\n\r\n", strval($response), 2);
            $headerArray = (explode("\r\n", $headers, 50));
            $headerMap = array();
            $responseBody = array();
            foreach ($headerArray as $key)
            {
                if (strpos($key, ":") != false)
                {
                    $splitArray = explode(":", $key);
                    $headerMap[$splitArray[0]] = $splitArray[1];
                }
            }
            $responseBody[Constants::HEADERS] = $headerMap;
            $responseBody[Constants::CONTENT] = $content;
            if (array_key_exists(Constants::INTERFACE_KEY, $pack) && $pack[Constants::INTERFACE_KEY] == true) // if interface
            {
                return [$this->getResponse($responseBody, $pack[Constants::CLASSES][0], $pack[Constants::GROUP_TYPE])];
            }
            else
            {
                $classes = $pack[Constants::CLASSES];
                $className = $classes[0];
                if(strpos($className, Constants::FILEBODYWRAPPER))
                {
                    return [$this->getResponse($responseBody, $className, null)];
                }
                return [$this->getStreamInstance($responseBody, $className)];
            }
        }
        return null;
    }

    public function getStreamInstance($response, $type)
    {
        $responseHeaders = $response[Constants::HEADERS];
        $responseContent = $response[Constants::CONTENT];
        $contentDisposition = "";
        if(array_key_exists(Constants::CONTENT_DISPOSITION, $responseHeaders))
        {
            $contentDisposition = $responseHeaders[Constants::CONTENT_DISPOSITION];
            if ($contentDisposition == null)
            {
                $contentDisposition = $responseHeaders[Constants::CONTENT_DISPOSITION1];
            }
        }
        $fileName = substr($contentDisposition, strrpos($contentDisposition, "'") + 1, strlen($contentDisposition));
        if (strpos($fileName, "=") !== false)
        {
            $fileName = substr($fileName, strrpos($fileName, "=") + 1, strlen($fileName));
            $fileName = str_replace(array(
                '\'',
                '"'
            ), '', $fileName);
        }
        $fileContent = $responseContent;
        $fileInstance = new $type($fileName, $fileContent, null);
        return $fileInstance;
    }

    public function getResponse($response, $pack, $groupType)
    {
        $recordJsonDetails = Initializer::$jsonDetails[$pack];
        $instance = null;
        if (array_key_exists(Constants::INTERFACE_KEY, $recordJsonDetails) && $recordJsonDetails[Constants::INTERFACE_KEY] == true) // if interface
        {
            if (array_key_exists($groupType, $recordJsonDetails))
            {
                $groupType1 = $recordJsonDetails[$groupType];
                if($groupType1 != null)
                {
                    $classes = $groupType1[Constants::CLASSES];
                    foreach($classes as $className)
                    {
                        if(strpos($className, Constants::FILEBODYWRAPPER))
                        {
                            return $this->getResponse($response, $className, null);
                        }
                    }
                }
            }
			return $instance;
        }
        else
        {
            $instance = new $pack();
            foreach ($recordJsonDetails as $memberName => $memberJsonDetails)
            {
                $reflector = new \ReflectionClass($instance);
                $field = $reflector->getProperty($memberName);
                $field->setAccessible(true);
                $type = $memberJsonDetails[Constants::TYPE];
                $instanceValue = null;
                if (strtolower($type) == strtolower(Constants::STREAM_WRAPPER_CLASS_PATH))
                {
                    $responseHeaders = $response[Constants::HEADERS];
                    $responseContent = $response[Constants::CONTENT];
                    $contentDisposition = "";
                    if(array_key_exists(Constants::CONTENT_DISPOSITION, $responseHeaders))
                    {
                        $contentDisposition = $responseHeaders[Constants::CONTENT_DISPOSITION];
                    }
                    else if(array_key_exists(Constants::CONTENT_DISPOSITION1, $responseHeaders))
                    {
                        $contentDisposition = $responseHeaders[Constants::CONTENT_DISPOSITION1];
                    }
                    else if(array_key_exists(Constants::CONTENT_DISPOSITION2, $responseHeaders))
                    {
                        $contentDisposition = $responseHeaders[Constants::CONTENT_DISPOSITION2];
                    }
                    $fileName = substr($contentDisposition, strrpos($contentDisposition, "'") + 1, strlen($contentDisposition));
                    if (strpos($fileName, "=") !== false)
                    {
                        $fileName = substr($fileName, strrpos($fileName, "=") + 1, strlen($fileName));
                        $fileName = str_replace(array(
                            '\'',
                            '"'
                        ), '', $fileName);
                    }
                    $fileContent = $responseContent;
                    $fileInstance = new $type($fileName, $fileContent, null);
                    $instanceValue = $fileInstance;
                    $field->setValue($instance, $instanceValue);
                }
            }
        }
        return $instance;
    }
}
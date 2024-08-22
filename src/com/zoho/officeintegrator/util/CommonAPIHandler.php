<?php
namespace com\zoho\officeintegrator\util;

use com\zoho\officeintegrator\HeaderMap;
use com\zoho\officeintegrator\Initializer;
use com\zoho\officeintegrator\ParameterMap;
use com\zoho\officeintegrator\logger\SDKLogger;
use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\util\APIHTTPConnector;
use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\util\JSONConverter;
use com\zoho\officeintegrator\util\Downloader;
use com\zoho\officeintegrator\util\FormDataConverter;
use com\zoho\officeintegrator\util\XMLConverter;
use com\zoho\officeintegrator\util\APIResponse;
use com\zoho\api\authenticator\Location;
use Exception;
/**
 * This class is to process the API request and its response.
 * Construct the objects that are to be sent as parameters or in the request body with the API.
 * The Request parameter, header and body objects are constructed here.
 * Process the response JSON and converts it to relevant objects in the library.
 */
class CommonAPIHandler
{
    private $apiPath;
    private $param;
    private $header;
    private $request;
    private $httpMethod;
    private $moduleAPIName;
    private $contentType;
    private $categoryMethod;
	private $methodName;
    private $operationClassName;

    public function __construct()
    {
        $this->header = new HeaderMap();
        $this->param = new ParameterMap();
    }

    /**
     * This is a setter method to set an API request content type.
     * @param string $contentType A string containing the API request content type.
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * This is a setter method to set the API request URL.
     * @param string $apiPath A string containing the API request URL.
     */
    public function setAPIPath($apiPath)
    {
        $this->apiPath = $apiPath;
    }

    /**
     * This method is to add an API request parameter.
     * @param string $param A Param containing the API request parameter .
     * @param object $paramValue A object containing the API request parameter value.
     */
    public function addParam($paramInstane, $paramValue)
    {
        if ($paramValue === null)
        {
            return;
        }
        if ($this->param === null)
        {
            $this->param = new ParameterMap();
        }
        $this->param->add($paramInstane, $paramValue);
    }

    /**
     * This method to add an API request header.
     * @param string $header A Header containing the API request header .
     * @param object $headerValue A object containing the API request header value.
     */
    public function addHeader($headerInstane, $headerValue)
    {
        if ($headerValue === null)
        {
            return;
        }
        if ($this->header === null)
        {
            $this->header = new HeaderMap();
        }
        $this->header->add($headerInstane, $headerValue);
    }

    /**
     * This is a setter method to set the API request parameter map.
     * @param ParameterMap $param A ParameterMap class instance containing the API request parameter.
     */
    public function setParam($param)
    {
        if ($param === null)
        {
            return;
        }
        if($this->param->getParameterMap() !== null && count($this->param->getParameterMap()) > 0)
        {
            $this->param->setParameterMap(array_merge($this->param->getParameterMap(), $param->getParameterMap()));
        }
        else
        {
            $this->param = $param;
        }
    }

    /**
     * This is a getter method to get the Zoho module API name.
     * @return string A String representing the Zoho module API name.
     */
    public function getModuleAPIName()
    {
        return $this->moduleAPIName;
    }

    /**
     * This is a setter method to set the Zoho module API name.
     * @param string $moduleAPIName A string containing the Zoho module API name.
     */
    public function setModuleAPIName($moduleAPIName)
    {
        $this->moduleAPIName = $moduleAPIName;
    }

    /**
     * This is a setter method to set the API request header map.
     * @param HeaderMap $header A HeaderMap class instance containing the API request header.
     */
    public function setHeader($header)
    {
        if ($header === null)
        {
            return;
        }
        if($this->header->getHeaderMap() !== null && count($this->header->getHeaderMap()) > 0)
        {
            $this->header->setHeaderMap(array_merge($this->header->getHeaderMap(), $header->getHeaderMap()));
        }
        else
        {
            $this->header = $header;
        }
    }

    /**
     * This is a setter method to set the API request body object.
     * @param object $request A object containing the API request body object.
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * This is a setter method to set the HTTP API request method.
     * @param string $httpMethod A string containing the HTTP API request method.
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * This method is used in constructing API request and response details. To make the Zoho API calls.
     *
     * @return \com\zoho\officeintegrator\util\APIResponse A APIResponse representing the Zoho API response instance or null.
     */
    public function apiCall()
    {
        if(Initializer::getInitializer() === null)
        {
            throw new SDKException(Constants::SDK_UNINITIALIZATION_ERROR,Constants::SDK_UNINITIALIZATION_MESSAGE);
        }
        $connector = new APIHTTPConnector();
        try
        {
            $this->setAPIUrl($connector);
        }
        catch(SDKException $e)
        {
            SDKLogger::severeError(Constants::SET_API_URL_EXCEPTION, $e);
            throw $e;
        }
        catch (Exception $e)
        {
            $exception = new SDKException(null, null, null, $e);
            SDKLogger::severeError(Constants::SET_API_URL_EXCEPTION, $exception);
            throw $exception;
        }
        $connector->setRequestMethod($this->httpMethod);
        $environment = Initializer::getInitializer()->getEnvironment();
        if ($this->header != null && count($this->header->getHeaderMap()) > 0)
        {
            $connector->setHeaders($this->header->getHeaderMap());
            if($environment->getLocation() != null && $environment->getLocation()->getName() == Location::HEADER()->getName())
			{
				$connector->addHeader($environment->getName(), $environment->getValue());
			}
        }
        if ($this->param != null && count($this->param->getParameterMap()) > 0)
        {
            $connector->setParams($this->param->getParameterMap());
            if($environment->getLocation() != null && $environment->getLocation()->getName() == Location::PARAM()->getName())
			{
				$connector->addParam($environment->getName(), $environment->getValue());
			}
        }
        try
        {
            if(Initializer::getInitializer()->getTokens() != null && count(Initializer::getInitializer()->getTokens()) > 0)
            {
                $tokenConfig = $this->getToken();
                $tokenConfig[0]->authenticate($connector, $tokenConfig[1]);
            }
        }
        catch (SDKException $e)
		{
		    SDKLogger::severeError(Constants::AUTHENTICATION_EXCEPTION, $e);
		    throw $e;
        }
        catch (Exception $e)
        {
            $exception = new SDKException(null, null, null, $e);
            SDKLogger::severeError(Constants::AUTHENTICATION_EXCEPTION, $exception);
            throw $exception;
        }
        $convertInstance = null;
        if (in_array(strtoupper($this->httpMethod), Constants::IS_GENERATE_REQUEST_BODY) &&  $this->request != null)
        {
            $requestObject = null;
            try
            {
                $pack = $this->getClassName(false, null, null);
                if($pack != null)
                {
                    $convertInstance = $this->getConverterClassInstance(strtolower($this->contentType));
                    $connector->setContentType($this->contentType);
                    $requestObject = $convertInstance->getWrappedRequest($this->request, $pack);
                    $connector->setRequestBody($requestObject);
                }
            }
            catch (SDKException $e)
			{
			    SDKLogger::severeError(Constants::FORM_REQUEST_EXCEPTION, $e);
				throw $e;
            }
            catch (Exception $e)
            {
                $exception = new SDKException(null, null, null, $e);
                SDKLogger::severeError(Constants::FORM_REQUEST_EXCEPTION, $exception);
                throw $exception;
            }
        }
        try
        {
            $response = $connector->fireRequest($convertInstance);
            $statusCode = $response[Constants::HTTP_CODE];
            $headerMap = $response[Constants::HEADERS];
            $returnObject  = null;
            $responseJSON = null;
            if(array_key_exists(Constants::CONTENT_TYPE, $headerMap) && !array_key_exists(Constants::ERROR, $response))
            {
                $responseContentType = $headerMap[Constants::CONTENT_TYPE];
                if (strpos($responseContentType, ';') != false)
                {
                    $splitArray = explode(';', $responseContentType);
                    $responseContentType = $splitArray[0];
                }
                $pack = $this->getClassName(true, $statusCode, $responseContentType);
                $converterInstance = $this->getConverterClassInstance(strtolower($responseContentType));
                if($pack != null)
                {
                    $responseObject = $converterInstance->getWrappedResponse($response[Constants::RESPONSE], $pack);
                    if ($responseObject !== null)
                    {
                        $returnObject = $responseObject[0];
                        if (count($responseObject) == 2)
                        {
                            $responseJSON = $responseObject[1];
                        }
                    }
                }
            }
            else
            {
                if(array_key_exists(Constants::ERROR, $response))
                {
                    SDKLogger::severeError(Constants::API_ERROR_RESPONSE . $response[Constants::ERROR], null);
                }
                else
                {
                    SDKLogger::severeError(Constants::API_ERROR_RESPONSE . json_encode($response, JSON_UNESCAPED_UNICODE), null);
                }
            }
            return new APIResponse($headerMap, $statusCode, $returnObject, $responseJSON);
        }
        catch (SDKException $e)
		{
            SDKLogger::severeError(Constants::API_CALL_EXCEPTION , $e);
		    throw $e;
        }
        catch (Exception $e)
        {
            $exception = new SDKException(null, null, null, $e);
            SDKLogger::severeError(Constants::API_CALL_EXCEPTION, $exception);
            throw $exception;
        }
    }

    /**
     * This method is used to get a Converter class instance.
     * @param string $encodeType A string containing the API response content type.
     * @return NULL|\com\zoho\officeintegrator\util\Converter A Converter class instance.
     */
    public function getConverterClassInstance($encodeType)
    {
        switch ($encodeType)
        {	case "text/plain":
                return new TextConverter($this);
            case "application/json":
            case "application/ld+json":
                return new JSONConverter($this);
            case "application/xml":
            case "text/xml":
                return new XMLConverter($this);
            case "multipart/form-data":
                return new FormDataConverter($this);
            case "image/png":
            case "image/jpeg":
            case "image/gif":
            case "image/tiff":
            case "image/svg+xml":
            case "image/bmp":
            case "image/webp":
            case "text/csv":
            case "text/html":
            case "text/css":
            case "text/javascript":
            case "text/calendar":
            case "application/x-download":
            case "application/zip":
            case "application/pdf":
            case "application/java-archive":
            case "application/javascript":
            case "application/octet-stream":
            case "application/xhtml+xml":
            case "application/x-bzip":
            case "application/msword":
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
            case "application/gzip":
            case "application/x-httpd-php":
            case "application/vnd.ms-powerpoint":
            case "application/vnd.rar":
            case "application/x-sh":
            case "application/x-tar":
            case "application/vnd.ms-excel":
            case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
            case "application/x-7z-compressed":
            case "audio/mpeg":
            case "audio/x-ms-wma":
            case "audio/vnd.rn-realaudio":
            case "audio/x-wav":
            case "audio/3gpp":
            case "audio/3gpp2":
            case "video/mpeg":
            case "video/mp4":
            case "video/webm":
            case "video/3gpp":
            case "video/3gpp2":
            case "font/ttf":
                return new Downloader($this);
            default:
                return null;
        }
    }

    private function setAPIUrl(APIHTTPConnector $connector)
    {
        $APIPath = "";
        if(strpos($this->apiPath, Constants::HTTP) !== false)
        {
            if(substr($this->apiPath, 0, 1) == "/")
            {
                $this->apiPath = substr($this->apiPath, 1);
            }
        }
        else
        {
            $APIPath = $APIPath . (Initializer::getInitializer()->getEnvironment()->getUrl());
        }
        $APIPath = $APIPath . ($this->apiPath);
        $connector->setURL($APIPath);
    }

	private function getRequestClassName($requests)
	{
		$name = get_class($this->request);
		if (is_array($this->request))
		{
			$name = get_class($this->request[0]);
		}
        foreach ($requests as $type => $value)
		{
			$contents = $value;
			foreach ($contents as $content1)
			{
				$content = $content1;
				if (array_key_exists(Constants::INTERFACE_KEY, $content) && $content[Constants::INTERFACE_KEY])
				{
					$interfaceName = $content[Constants::CLASSES][0];
					if (strtolower($interfaceName) == strtolower($name))
					{
						$this->contentType = $type;
						return $content;
					}
					$classDetail = Initializer::$jsonDetails[$interfaceName];
                    foreach ($classDetail as $groupType => $classDetailValue)
					{
						$groupTypeContent = $classDetailValue;
						$classes = $groupTypeContent[Constants::CLASSES];
                        foreach ($classes as $className)
						{
							if(strtolower($className) == strtolower($name))
							{
								$this->contentType = $type;
								return $content;
							}
						}
					}
				}
				else
				{
					$classes = $content[Constants::CLASSES];
                    foreach ($classes as $className)
					{
						if(strtolower($className) == strtolower($name))
						{
							$this->contentType = $type;
							return $content;
						}
					}
				}
			}
		}
		return null;
	}

	private function getClassName($isResponse, $statusCode, $mimeType)
	{
		$jsonDetails = Initializer::$jsonDetails;
		if(array_key_exists(strtolower($this->operationClassName), $jsonDetails))
		{
			$methods = $jsonDetails[strtolower($this->operationClassName)];
			$methodName = $this->getMethodName();
			if(array_key_exists($methodName, $methods))
			{
				$methodDetails = $methods[$methodName];
				if($isResponse)
				{
					if(array_key_exists(Constants::RESPONSE, $methodDetails))
					{
						$response = $methodDetails[Constants::RESPONSE];
						if(array_key_exists(strval($statusCode), $response))
						{
							$contentResponse = $response[strval($statusCode)];
							foreach ($contentResponse as $content)
							{
								$contentJSON = $content;
								if(array_key_exists($mimeType, $contentJSON))
								{
									return $contentJSON[$mimeType];
								}
							}
							SDKLogger::severeError(Constants::API_CALL_EXCEPTION);
						}
						else
						{
							SDKLogger::severeError(Constants::API_CALL_EXCEPTION);
						}
					}
				}
				else
				{
					if (array_key_exists(Constants::REQUEST, $methodDetails))
					{
						return $this->getRequestClassName($methodDetails[Constants::REQUEST]);
					}
				}
			}
			else
			{
				SDKLogger::severeError(Constants::API_CALL_EXCEPTION);
			}
		}
		else
		{
			SDKLogger::severeError(Constants::API_CALL_EXCEPTION);
		}
		return null;
	}

	public function getHttpMethod()
	{
		return $this->httpMethod;
	}

	public function getCategoryMethod()
	{
		return $this->categoryMethod;
	}

	public function setCategoryMethod($category)
	{
		$this->categoryMethod = $category;
    }

    public function getAPIPath()
	{
		return $this->apiPath;
	}

    public function getMethodName()
	{
		return $this->buildName(explode("_", $this->methodName), false);
	}

	public function setMethodName($methodName)
	{
		$this->methodName = $methodName;
	}

	public function getOperationClassName()
	{
		return $this->operationClassName;
	}

	public function setOperationClassName($operationClassName)
	{
		$this->operationClassName = str_replace(".", "\\", $operationClassName);
	}

    private function getToken()
	{
		$authenticationTypes = $this->getRequestMethodDetails($this->operationClassName);
		if($authenticationTypes != null)
		{
			foreach (Initializer::getInitializer()->getTokens() as $token)
			{
				foreach ($authenticationTypes as $authenticationType)
				{
					$authentication = $authenticationType;
					$schemaName = $authentication[Constants::SCHEMA_NAME];
					if(strtolower($schemaName) == strtolower($token->getAuthenticationSchema()->getSchema()))
					{
						return [$token, $authentication];
					}
				}
			}
		}
		return [Initializer::getInitializer()->getTokens()[0], null];
	}

	private function getRequestMethodDetails($operationsClassName)
	{
		try
		{
			if(array_key_exists(strtolower($operationsClassName), Initializer::$jsonDetails))
			{
				$classDetails = Initializer::$jsonDetails[strtolower($operationsClassName)];
				$methodName = $this->getMethodName();
				if(array_key_exists($methodName, $classDetails))
				{
					$methodDetails = $classDetails[$methodName];
					if (array_key_exists(Constants::AUTHENTICATION, $methodDetails))
					{
						return $methodDetails[Constants::AUTHENTICATION];
					}
					else if (array_key_exists(Constants::AUTHENTICATION, $classDetails))
					{
						return $classDetails[Constants::AUTHENTICATION];
					}
					return null;
				}
				else
				{
					throw new Exception(Constants::SDK_OPERATIONS_METHOD_DETAILS_NOT_FOUND_IN_JSON_DETAILS_FILE);
				}
			}
			else
			{
				throw new Exception(Constants::SDK_OPERATIONS_CLASS_DETAILS_NOT_FOUND_IN_JSON_DETAILS_FILE);
			}
		}
		catch(Exception $ex)
		{
			$exception = new SDKException(null, null, null, $ex);
			SDKLogger::severeError(Constants::API_CALL_EXCEPTION, $exception);
			throw $exception;
		}
	}

    public function buildName($name, $isType)
	{
		$sdkName = "";
		$index = null;
		if ($isType)
		{
			$index = 0;
		}
		else
		{
			if ($name != null && count($name) > 0)
			{
				$sdkName = $name[0];
                if(strpos($sdkName, "$") !== false)
                {
                    $sdkName = str_replace("$", "", $sdkName);
                }
			}
			$index = 1;
		}
		for ($nameIndex = $index; $nameIndex < sizeof($name); $nameIndex++)
		{
			$fullName = $name[$nameIndex];
			if ($fullName != null && !empty($fullName))
			{
				$firstLetterUppercase = $this->getFieldName($fullName);
				if ("api" == strtolower($firstLetterUppercase))
				{
					$sdkName = $sdkName . strtoupper($firstLetterUppercase);
				}
				else
				{
					$sdkName = $sdkName . $firstLetterUppercase;
				}
			}
		}
		$sdkName = str_replace("(\\(|\\)|'|[|]|\\{|})", "", $sdkName);
		return $sdkName;
	}

	private function getFieldName($fullName)
	{
		$varName = $fullName;
        if(strpos($fullName, "$") !== false)
		{
			$varName = str_replace("$", "", $fullName);
		}
        else if(strpos($fullName, "_") !== false)
		{
			$varName = str_replace("_", "", $fullName);
		}
		return strtoupper(substr($varName, 0, 1)) . substr($varName, 1);
	}
}
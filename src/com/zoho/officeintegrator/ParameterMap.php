<?php
namespace com\zoho\officeintegrator;

use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\util\HeaderParamValidator;
use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\util\DataTypeConverter;
use com\zoho\officeintegrator\logger\SDKLogger;

/**
 * This class representing the HTTP parameter name and value.
 */
class ParameterMap
{
    private $parameterMap = array();

    /**
     * This is a getter method to get parameter map.
     * @return array An array representing the API request parameters.
     */
    public function getParameterMap()
    {
        return $this->parameterMap;
    }

    /**
     * This is a setter method to set parameter map.
     * @param array An array representing the API request parameters.
     */
    public function setParameterMap(array $parameterMap)
    {
        $this->parameterMap = $parameterMap;
    }

    /**
     * This method to add parameter name and value.
     * @param Param $param A Param class instance.
     * @param object $value A object containing the parameter value.
     */
    public function add(Param $param, $value)
    {
        if($param === null)
        {
            throw new SDKException(Constants::PARAMETER_NULL_ERROR, Constants::PARAM_INSTANCE_NULL_ERROR);
        }
        $paramName = $param->getName();
        if($paramName === null)
        {
            throw new SDKException(Constants::PARAM_NAME_NULL_ERROR, Constants::PARAM_NAME_NULL_ERROR_MESSAGE);
        }
        if($value === null)
        {
            throw new SDKException(Constants::PARAMETER_NULL_ERROR, $paramName.Constants::NULL_VALUE_ERROR_MESSAGE);
        }
        try
        {
            $paramClassName = $param->getClassName();
            $parsedParamValue = null;
            if($paramClassName != null)
            {
                $headerParamValidator = new HeaderParamValidator();
                $parsedParamValue = $headerParamValidator->validate($paramName, $paramClassName, $value);
            }
            else
            {
                try
                {
                    $type = gettype($value);
                    if(strtolower($type) == strtolower(Constants::OBJECT))
                    {
                        $type = get_class($value);
                    }
                    $parsedParamValue = DataTypeConverter::postConvert($value, $type);
                }
                catch(\Exception $ex)
                {
                    $parsedParamValue = $value;
                }
            }
            if($parsedParamValue === true || $parsedParamValue === false)
            {
                $parsedParamValue = json_encode($parsedParamValue, JSON_UNESCAPED_UNICODE);
            }
            if (array_key_exists($paramName, $this->parameterMap) && isset($this->parameterMap[$paramName]))
            {
                $paramValue = $this->parameterMap[$paramName];
                $paramValue = $paramValue . "," . $parsedParamValue;
                $this->parameterMap[$paramName] = $paramValue;
            }
            else
            {
                $this->parameterMap[$paramName] = $parsedParamValue;
            }
        }
        catch(SDKException $e)
        {
            SDKLogger::severeError(Constants::PARAM_EXCEPTION, $e);
            throw $e;
        }
        catch (\Exception $e)
        {
            $exception = new SDKException(null, null, null, $e);
            SDKLogger::severeError(Constants::PARAM_EXCEPTION, $exception);
            throw $exception;
        }
    }
}
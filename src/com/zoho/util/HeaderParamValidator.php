<?php
namespace com\zoho\util;

use com\zoho\exception\SDKException;

use com\zoho\Initializer;
use com\zoho\Param;
use com\zoho\util\Constants;

use com\zoho\util\DataTypeConverter;

/**
 * This class is to validate API headers and parameters.
 */
class HeaderParamValidator
{
    public function validate($headerparam, $value)
    {
        $name = $headerparam->getName();

        $className = $headerparam->getClassName();

        $json_Details = $this->getJSONDetails();

        $className = $this->getClassName($className);

        $typeDetail = array();

        if(array_key_exists($className, $json_Details))
        {
            $typeDetail = $this->getKeyJSONDetails($name, $json_Details[$className]);
        }

        if(count($typeDetail) > 0)
        {
            if(!$this->checkDataType($typeDetail, $value))
            {
                $detailsJO = [];

                $detailsJO[Constants::HEADER_OR_PARAM_NAME] = $name;

                $detailsJO[Constants::CLASS_KEY] =  $className;

                $detailsJO[Constants::EXPECTED_TYPE] = $typeDetail[Constants::TYPE];

                throw new SDKException(Constants::TYPE_ERROR, null, $detailsJO, null);
            }
            if($headerparam instanceof Param)
            {
                if(array_key_exists(Constants::STRUCTURE_NAME, $typeDetail))
                {
                    $converter = new JSONConverter(null);
                    return $converter->formRequest($value, $typeDetail[Constants::STRUCTURE_NAME], null, null);
                }
                return $this->parseData($value, $typeDetail[Constants::TYPE]);
            }
        }
        return DataTypeConverter::postConvert($value, get_class($value));
    }

    public function parseData($value, $type)
    {
        if (strtolower($type) == strtolower(Constants::MAP_NAMESPACE))
        {
            $jsonObject = array();
            if (is_countable($value) && count($value) > 0)
            {
                foreach ($value as $key => $requestObject)
                {
                    if (is_countable($requestObject) && count($requestObject) > 0)
                    {
                        $jsonObject[$key] = $this->parseData($requestObject, Constants::MAP_NAMESPACE);
                    }
                    else
                    {
                        $jsonObject[$key] = $this->parseData($requestObject, gettype($requestObject));
                    }
                } 
            }
            return $jsonObject;
        }
        else if (strtolower($type) == strtolower(Constants::ARRAY_KEY))
        {
            $jsonArray = array();
            if (sizeof($value) > 0)
            {   
                foreach ($value as $requestObject)
                {
                    if (is_countable($requestObject) && count($requestObject) > 0)
                    {
                        array_push($jsonArray, $this->parseData($requestObject, Constants::MAP_NAMESPACE));
                    }
                    else
                    {
                        array_push($jsonArray, $this->parseData($requestObject, gettype($requestObject)));
                    }
                }
            }
            return $jsonArray;
        }
        else
        {
            if(strtolower($type) == strtolower(Constants::OBJECT))
            {
                $type = get_class($value);
            }
            return DataTypeConverter::postConvert($value, $type);
        }
    }

    public function getJSONDetails()
    {
        $json_Details = Initializer::$jsonDetails;

        if(is_null($json_Details))
        {
            $json_Details = json_decode(file_get_contents(explode("src/com", realpath(__DIR__))[0] . Constants::JSON_DETAILS_FILE_PATH), true);

            Initializer::$jsonDetails = $json_Details;
        }

        return $json_Details;
    }

    public function getClassName($className)
    {
        $classNameSpace = explode('.', $className);

        $count = count($classNameSpace);

        $className = "";

        for($i = 0; $i < $count - 1; $i++)
        {
            $className = $className . strtolower($classNameSpace[$i]) . "\\";
        }

        return $className . $classNameSpace[$count - 1];
    }

    public function getKeyJSONDetails($name, $json_Details)
    {
        foreach($json_Details as $json_Detail)
        {
            if(array_key_exists(Constants::NAME, $json_Detail) && strtolower($name) == strtolower($json_Detail[Constants::NAME]))
            {
                return $json_Detail;
            }
        }
    }

    public function checkDataType($keyDetail, $value)
    {
		$type  = $keyDetail[Constants::TYPE];

		$varType = gettype($value);

		$test = function ($varType, $type) { if(strtolower($varType) == strtolower($type)){return true; } return false;};

		$check = $test($varType, $type);

		if(array_key_exists($type, Constants::DATA_TYPE))
		{
			$type = Constants::DATA_TYPE[$type];

			$check = $test($varType, $type);
        }

        if(strtolower($varType) == strtolower(Constants::OBJECT) || strtolower($type) == strtolower(Constants::OBJECT))
		{
			if(strtolower($type) == strtolower(Constants::OBJECT))
			{
				$check = true;
			}
			else
			{
				$className = get_class($value);

				$check = $test($className, $type);
			}
		}

        return $check;
    }
}
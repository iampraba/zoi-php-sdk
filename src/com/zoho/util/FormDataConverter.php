<?php
namespace com\zoho\util;

use com\zoho\exception\SDKException;
use com\zoho\Initializer;
use com\zoho\util\Constants;

/**
 * This class is to process the upload file and stream.
 */
class FormDataConverter extends Converter
{
    private $_uniqueValuesMap = array();

    public function __construct($commonAPIHandler)
    {
        parent::__construct($commonAPIHandler);
    }

    public function formRequest($requestInstance, $pack, $instanceNumber, $classMemberDetail = null)
    {
        $classDetail = Initializer::$jsonDetails[$pack];

        $reflector = new \ReflectionClass($requestInstance);

        $request = array();

        foreach ($classDetail as $memberName => $memberDetail)
        {
            $modification = null;

            if (((array_key_exists(Constants::WRITE_ONLY, $memberDetail) && !($memberDetail[Constants::WRITE_ONLY])) && (array_key_exists(Constants::UPDATE_ONLY, $memberDetail) && !($memberDetail[Constants::UPDATE_ONLY])) && (array_key_exists(Constants::READ_ONLY, $memberDetail) && ($memberDetail[Constants::READ_ONLY]))) || ! array_key_exists(Constants::NAME, $memberDetail))
            {
                continue;
            }

            try
            {
                $modification = $reflector->getMethod(Constants::IS_KEY_MODIFIED)->invoke($requestInstance, $memberDetail[Constants::NAME]);
            }
            catch (\Exception $ex)
            {
                throw new SDKException(Constants::EXCEPTION_IS_KEY_MODIFIED, null, null, $ex);
            }

            // check required
            if ($modification == null && $modification == 0 && array_key_exists(Constants::REQUIRED, $memberDetail) && (bool) $memberDetail[Constants::REQUIRED])
            {
                throw new SDKException(Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR . $memberName);
            }

            $field = $reflector->getProperty($memberName);

            $field->setAccessible(true);

            $fieldValue = $field->getValue($requestInstance);

            if ($modification != null && $modification != 0 && $fieldValue != null && $this->valueChecker(get_class($requestInstance), $memberName, $memberDetail, $fieldValue, $this->_uniqueValuesMap, $instanceNumber))
            {
                $keyName = $memberDetail[Constants::NAME];

                $type = $memberDetail[Constants::TYPE];

                if ($type == Constants::LIST_NAMESPACE)
                {
                    $request[$keyName] = $this->setJSONArray($fieldValue, $memberDetail);
                }
                else if ($type == Constants::MAP_NAMESPACE)
                {
                    $request[$keyName] = $this->setJSONObject($fieldValue, $memberDetail);
                }
                else if (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
                {
                    $request[$keyName] = $this->formRequest($fieldValue, $memberDetail[Constants::STRUCTURE_NAME], 1, $memberDetail);
                }
                else
                {
                    $request[$keyName] = $fieldValue;
                }
            }
        }

        return $request;
    }

    public function appendToRequest(&$requestBase, $requestObject)
    {
        echo "In";
        if(is_array($requestObject))
        {
            $data = "";

            foreach ($requestObject as $key => $value)
            {
                $lineEnd = "\r\n";

                $hypen = "--";

                $date = new \DateTime();

                $current_time_long = $date->getTimestamp();

                $boundaryStart = utf8_encode($hypen . (string)$current_time_long . $lineEnd);

                if(is_array($value) && sizeof($value) > 0)
                {
                    
                    $keysDetail = $value;

                    if(array_keys($value))
                    {
                        $data = $data . $boundaryStart;
    
                        $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";" . $lineEnd . $lineEnd;

                        $data = $data . utf8_encode($contentDisp);

                        $data = $data . json_encode($value, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE) . utf8_encode($lineEnd);
                    }
                    else
                    {
                        for ($i = 0; $i < sizeof($keysDetail); $i++)
                        {
                            $fileObject = $keysDetail[$i];
    
                            if($fileObject instanceof StreamWrapper)
                            {
                                $fileName = $fileObject->getName();
    
                                $fileData = $fileObject->getStream();
    
                                $data = $data . $boundaryStart;
    
                                $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";filename=\"" . $fileName . "\"" . $lineEnd . $lineEnd;
    
                                $data = $data . utf8_encode($contentDisp);
    
                                $data = $data . $fileData.utf8_encode($lineEnd);
                            }
                            else
                            {
                                $data = $data . $boundaryStart;
    
                                $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";" . $lineEnd . $lineEnd;
    
                                $data = $data . utf8_encode($contentDisp);

                                $fileObject = $fileObject . utf8_encode($lineEnd);

                                if(is_array($fileObject))
                                {
                                    $fileObject = json_encode($fileObject, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE) . utf8_encode($lineEnd);
                                }

                                $data = $data . $fileObject;
                            }
                        }
                    }
                }
                else if($value instanceof StreamWrapper)
                {
                    $fileName = $value->getName();

                    $fileData = $value->getStream();

                    $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";filename=\"" . $fileName . "\"" . $lineEnd . $lineEnd;

                    $data = $data . utf8_encode($lineEnd);

                    $boundaryStart = utf8_encode($hypen . (string)$current_time_long . $lineEnd);

                    $data = $data . $boundaryStart;

                    $data = $data.utf8_encode($contentDisp);

                    $data = $data . $fileData.utf8_encode($lineEnd);
                }
                else
                {
                    $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";" . $lineEnd . $lineEnd;

                    $boundaryStart = utf8_encode($hypen . (string)$current_time_long . $lineEnd);

                    $data = $data . $boundaryStart;
    
                    $data = $data . utf8_encode($contentDisp);

                    $value = $value . utf8_encode($lineEnd);

                    if(is_array($value))
                    {
                        $value = json_encode($value, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE) . utf8_encode($lineEnd);
                    }

                    $data = $data . $value;
                }
            }

            $boundaryend = $hypen . (string)$current_time_long. $hypen;

            $header = ['ENCTYPE:multipart/form-data', 'Content-Type:multipart/form-data; boundary=' . (string)$current_time_long];

            $requestBase[CURLOPT_HTTPHEADER] = $header;
           
            $data = $data . utf8_encode($boundaryend);

            $requestBase[CURLOPT_POSTFIELDS]= $data;
        }
    }

    public function setData($memberDetail, $fieldValue)
    {
        if ($fieldValue !== null)
        {
            $type = $memberDetail[Constants::TYPE];

            if ($type == Constants::LIST_NAMESPACE)
            {
                return $this->setJSONArray($fieldValue, $memberDetail);
            }
            else if ($type == Constants::MAP_NAMESPACE)
            {
                return $this->setJSONObject($fieldValue, $memberDetail);
            }
            else if ($type == Constants::CHOICE_NAMESPACE || (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail) && $memberDetail[Constants::STRUCTURE_NAME] == Constants::CHOICE_NAMESPACE))
            {
                return $fieldValue->getValue();
            }
            else if (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
            {
                return $this->formRequest($fieldValue, $memberDetail[Constants::STRUCTURE_NAME], null, $memberDetail);
            }
            else
            {
                return DataTypeConverter::postConvert($fieldValue, $type);
            }
        }

        return null;
    }

    public function setJSONObject($requestObject, $memberDetail)
    {
        $jsonObject = array();

        if (sizeof($requestObject) > 0)
        {
            if ($memberDetail == null || ($memberDetail != null && ! array_key_exists(Constants::KEYS, $memberDetail)))
            {
                foreach ($requestObject as $key => $value)
                {
                    $jsonObject[$key] = $this->redirectorForObjectToJSON($value);
                }
            }
            else
            {
                if (array_key_exists(Constants::KEYS, $memberDetail))
                {
                    $keysDetail = $memberDetail[Constants::KEYS];

                    foreach ($keysDetail as $keyDetail)
                    {
                        $keyName = $keyDetail[Constants::NAME];

                        $keyValue = null;

                        if (array_key_exists($keyName, $requestObject) && $requestObject[$keyName] != null)
                        {
                            $keyValue = $this->setData($keyDetail, $requestObject[$keyName]);

                            $jsonObject[$keyName] = $keyValue;
                        }
                    }
                }
            }
        }

        return $jsonObject;
    }

    public function setJSONArray($requestObjects, $memberDetail)
    {
        $jsonArray = array();

        if ($memberDetail == null)
        {
            foreach ($requestObjects as $request)
            {
                $jsonArray[] = $this->redirectorForObjectToJSON($request);
            }
        }
        else
        {
            if (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
            {
                $instanceCount = 0;

                $pack = $memberDetail[Constants::STRUCTURE_NAME];

                foreach ($requestObjects as $request)
                {
                    $jsonArray[] = $this->formRequest($request, $pack, ++ $instanceCount, $memberDetail);
                }
            }
            else
            {
                foreach ($requestObjects as $request)
                {
                    $jsonArray[] = $this->redirectorForObjectToJSON($request);
                }
            }
        }

        return $jsonArray;
    }

    public function redirectorForObjectToJSON($request)
    {
        $type = gettype($request);

        if ($type == Constants::ARRAY_KEY)
        {
            foreach (array_keys($request) as $key)
            {
                if (gettype($key) == strtolower(Constants::STRING_NAMESPACE))
                {
                    $type = strtolower(Constants::MAP_NAMESPACE);
                }

                break;
            }

            if ($type == strtolower(Constants::MAP_NAMESPACE))
            {
                return $this->setJSONObject($request, null);
            }
            else
            {
                return $this->setJSONArray($request, null);
            }
        }
        else
        {
            return $request;
        }
    }

    public function getWrappedResponse($responseObject, $pack)
    {
        return $this->getResponse($responseObject, $pack);
    }

    public function getResponse($responseJson, $pack)
    {
        return null;
    }
}
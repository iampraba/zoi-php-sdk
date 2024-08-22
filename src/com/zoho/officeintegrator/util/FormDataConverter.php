<?php
namespace com\zoho\officeintegrator\util;

use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\Initializer;
use com\zoho\officeintegrator\util\Constants;

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

    public function appendToRequest(&$requestBase, $requestObject)
    {
        if(is_array($requestObject))
        {
            $data = "";
            foreach ($requestObject as $key => $value)
            {
                $lineEnd = "\r\n";
                $hypen = "--";
                $date = new \DateTime();
                $current_time_long = $date->getTimestamp();
                $boundaryStart = mb_convert_encoding($hypen . (string)$current_time_long . $lineEnd, "UTF-8");
                if(is_array($value) && sizeof($value) > 0)
                {
                    $keysDetail = $value;
                    if(array_keys($value))
                    {
                        $data = $data . $boundaryStart;
                        $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";" . $lineEnd . $lineEnd;
                        $data = $data . mb_convert_encoding($contentDisp, "UTF-8");
                        $data = $data . json_encode($value, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE) . mb_convert_encoding($lineEnd, "UTF-8");
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
                                $data = $data . mb_convert_encoding($contentDisp, "UTF-8");
                                $data = $data . $fileData . mb_convert_encoding($lineEnd, "UTF-8");
                            }
                            else
                            {
                                $data = $data . $boundaryStart;
                                $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";" . $lineEnd . $lineEnd;
                                $data = $data . mb_convert_encoding($contentDisp, "UTF-8");
                                $fileObject = $fileObject . mb_convert_encoding($lineEnd, "UTF-8");
                                if(is_array($fileObject))
                                {
                                    $fileObject = json_encode($fileObject, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE) . mb_convert_encoding($lineEnd, "UTF-8");
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
                    $data = $data . mb_convert_encoding($lineEnd, "UTF-8");
                    $boundaryStart = mb_convert_encoding($hypen . (string)$current_time_long . $lineEnd, "UTF-8");
                    $data = $data . $boundaryStart;
                    $data = $data . mb_convert_encoding($contentDisp, "UTF-8");
                    $data = $data . $fileData . mb_convert_encoding($lineEnd, "UTF-8");
                }
                else
                {
                    $contentDisp = "Content-Disposition: form-data; name=\"" . $key . "\";" . $lineEnd . $lineEnd;
                    $boundaryStart = mb_convert_encoding($hypen . (string)$current_time_long . $lineEnd, "UTF-8");
                    $data = $data . $boundaryStart;
                    $data = $data . mb_convert_encoding($contentDisp, "UTF-8");
                    $value = $value . mb_convert_encoding($lineEnd, "UTF-8");
                    if(is_array($value))
                    {
                        $value = json_encode($value, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE) . mb_convert_encoding($lineEnd, "UTF-8");
                    }
                    $data = $data . $value;
                }
            }
            $boundaryend = $hypen . (string)$current_time_long. $hypen;
            $header = ['ENCTYPE:multipart/form-data', 'Content-Type:multipart/form-data; boundary=' . (string)$current_time_long];
            $requestBase[CURLOPT_HTTPHEADER] = $header;
            $data = $data . mb_convert_encoding($boundaryend, "UTF-8");
            $requestBase[CURLOPT_POSTFIELDS]= $data;
        }
    }

    public function getWrappedRequest($requestInstance, $pack)
    {
        $groupType = $pack[Constants::GROUP_TYPE];
        return $this->formRequest($requestInstance, get_class($requestInstance), null, null, $groupType);
    }

    public function formRequest($requestInstance, $pack, $instanceNumber, $classMemberDetail = null, $groupType = null)
    {
        $request = array();
        if(!array_key_exists($pack, Initializer::$jsonDetails))
		{
			return $request;
		}
        $classDetail = Initializer::$jsonDetails[$pack];
        $reflector = new \ReflectionClass($requestInstance);
        foreach ($classDetail as $memberName => $memberDetail)
        {
            $modification = null;
            $found = false;
            if (array_key_exists(Constants::REQUEST_SUPPORTED, $memberDetail) || !array_key_exists(Constants::NAME, $memberDetail))
            {
                $requestSupported = $memberDetail[Constants::REQUEST_SUPPORTED];
				foreach ($requestSupported as $requestMethod)
				{
					if (strtolower($requestMethod) == strtolower($this->commonAPIHandler->getCategoryMethod()))
					{
						$found = true;
						break;
					}
				}
            }
            if (!$found)
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
            if (($modification == null || $modification == 0) && (array_key_exists(Constants::REQUIRED_FOR, $memberDetail) && ($memberDetail[Constants::REQUIRED_FOR] == strtolower(Constants::ALL) || $memberDetail[Constants::REQUIRED_FOR] == strtolower(Constants::REQUEST))))
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
                $memberGroupType = array_key_exists(Constants::GROUP_TYPE, $memberDetail) ? $memberDetail[Constants::GROUP_TYPE] : null;
                if ($type == Constants::LIST_NAMESPACE)
                {
                    $request[$keyName] = $this->setJSONArray($fieldValue, $memberDetail, $memberGroupType);
                }
                else if ($type == Constants::MAP_NAMESPACE)
                {
                    $request[$keyName] = $this->setJSONObject($fieldValue, $memberDetail);
                }
                else if (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
                {
                    $request[$keyName] = $this->formRequest($fieldValue, $memberDetail[Constants::STRUCTURE_NAME], 1, $memberDetail, $memberGroupType);
                }
                else
                {
                    $request[$keyName] = $fieldValue;
                }
            }
        }
        return $request;
    }

	private function isNotRecordRequest($requestInstance, $classDetail, $instanceNumber, $classMemberDetail)
	{
		$lookUp = false;
		$skipMandatory = false;
        $classMemberName = null;
		if ($classMemberDetail != null)
		{
			if (array_key_exists(Constants::LOOKUP, $classMemberDetail))
            {
                $lookUp = $classMemberDetail[Constants::LOOKUP];
            }
			$classMemberName = $this->buildName($classMemberDetail[Constants::NAME]);
		}
		$requestJSON = [];
		$requiredKeys = [];
        $reflector = new \ReflectionClass($requestInstance);
		foreach ($classDetail as $memberName)
		{
			$modification = null;
			$memberDetail = $classDetail[$memberName];
			$found = false;
            if (array_key_exists(Constants::REQUEST_SUPPORTED, $memberDetail) && !array_key_exists(Constants::NAME, $memberDetail))
            {
                $requestSupported = $memberDetail[Constants::REQUEST_SUPPORTED];
				foreach ($requestSupported as $requestMethod)
				{
					if (strtolower($requestMethod) == strtolower($this->commonAPIHandler->getCategoryMethod()))
					{
						$found = true;
						break;
					}
				}
            }
            if (!$found)
            {
                continue;
            }
			$keyName = $memberDetail[Constants::NAME];
            try
            {
                $modification = $reflector->getMethod(Constants::IS_KEY_MODIFIED)->invoke($requestInstance, $keyName);
            }
            catch (\Exception $ex)
            {
                throw new SDKException(Constants::EXCEPTION_IS_KEY_MODIFIED, null, null, $ex);
            }
			if (array_key_exists(Constants::REQUIRED_FOR, $memberDetail) && ($memberDetail[Constants::REQUIRED_FOR] == Constants::ALL || $memberDetail[Constants::REQUIRED_FOR] == Constants::REQUEST))
			{
				$requiredKeys[$keyName] =  1;
			}
			$fieldValue = null;
			if ($modification != null && $modification != 0)
			{
                $field = $reflector->getProperty($memberName);
                $field->setAccessible(true);
                $fieldValue = $field->getValue($requestInstance);
				if ($fieldValue != null)
				{
					if ($this->valueChecker(get_class($requestInstance), $memberName, $memberDetail, $fieldValue, $this->_uniqueValuesMap, $instanceNumber))
					{
						if (array_key_exists($keyName, $requiredKeys))
                        {
                            unset($requiredKeys[$keyName]);
                        }
					}
					$requestJSON[$keyName] = $this->setData($memberDetail, $fieldValue);
				}
			}
		}
		if (!$skipMandatory)
		{
			$this->checkException($classMemberName, $requestInstance, $instanceNumber, $requiredKeys);
		}
		return $requestJSON;
	}

	private function checkException($memberName, $requestInstance, $instanceNumber, $requiredKeys)
	{
		if ($this->commonAPIHandler->getCategoryMethod() == Constants::REQUEST_CATEGORY_CREATE)
		{
			if ($requiredKeys || empty($requiredKeys))
			{
				$error = array();
                $error[Constants::FIELD] = $memberName;
                $error[Constants::TYPE] = get_class($requestInstance);
                $error[Constants::KEYS] = array_keys($requiredKeys);
                if(!is_null($instanceNumber))
                {
                    $error[Constants::INSTANCE_NUMBER] = $instanceNumber;
                }
				throw new SDKException(Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR, $error, null);
			}
		}
	}

    public function setData($memberDetail, $fieldValue)
    {
        if ($fieldValue !== null)
        {
            $groupType = array_key_exists(Constants::GROUP_TYPE, $memberDetail) ? $memberDetail[Constants::GROUP_TYPE] : null;
            $type = $memberDetail[Constants::TYPE];
            if ($type == Constants::LIST_NAMESPACE)
            {
                return $this->setJSONArray($fieldValue, $memberDetail, $groupType);
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
                return $this->isNotRecordRequest($fieldValue, Initializer::$jsonDetails[Constants::STRUCTURE_NAME], null, $memberDetail);
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
            if ($memberDetail == null)
            {
                foreach ($requestObject as $key => $value)
                {
                    $jsonObject[$key] = $this->redirectorForObjectToJSON($value);
                }
            }
            else
            {
                if (array_key_exists(Constants::EXTRA_DETAILS, $memberDetail))
                {
                    $extraDetails = $memberDetail[Constants::EXTRA_DETAILS];
                    if($extraDetails != null && sizeof($extraDetails) > 0)
                    {
                        $members = $this->getValidStructure($extraDetails, array_keys($requestObject));
						return $this->isNotRecordRequest($requestObject, $members, null, null);
                    }
                }
                else
                {
                    foreach ($requestObject as $key => $value)
                    {
                        $jsonObject[$key] = $this->redirectorForObjectToJSON($value);
                    }
                }
            }
        }
        return $jsonObject;
    }

    private function getValidStructure($extraDetails, $keys)
	{
		foreach ($extraDetails as $extraDetail)
		{
			if(!array_key_exists(Constants::MEMBERS, $extraDetail))
			{
				$members = Initializer::$jsonDetails[$extraDetail[Constants::TYPE]];
				$difference = array_diff($keys, $members);
                if (empty($difference)) 
                {
                    return $members;
                }
			}
			else
			{
				if(array_key_exists(Constants::MEMBERS, $extraDetail))
				{
					$members = $extraDetail[Constants::MEMBERS];
                    $difference = array_diff($keys, $members);
                    if (empty($difference)) 
                    {
                        return $members;
                    }
				}
			}
		}
		return null;
	}

    public function setJSONArray($requestObjects, $memberDetail, $groupType)
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
                    $jsonArray[] = $this->isNotRecordRequest($request,  Initializer::$jsonDetails[$pack], ++ $instanceCount, $memberDetail);
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
                return $this->setJSONArray($request, null, null);
            }
        }
        else
        {
            return $request;
        }
    }

    public function getWrappedResponse($response, $contents)
    {
        $pack = null;
        if(sizeof($contents) == 1)
        {
            $pack = $contents[0];
			if(array_key_exists(Constants::GROUP_TYPE, $pack))
			{
				$data = $this->findMatchAndParseResponseClass($contents, $response);
				if ($data != null)
				{
					$pack = $data[0];
					$responseData = $data[1];
					return [$this->getResponseJSON($responseData, $pack, null)];
				}
			}
			else
			{
				return [$this->getStreamInstance($response, $pack[Constants::CLASSES][0])];
			}
        }
        return null;
    }

    public function getResponseJSON($responseJson, $packageName, $groupType)
    {
        $classDetail = Initializer::$jsonDetails[$packageName];
		$instance = null;
		if (array_key_exists(Constants::INTERFACE_KEY, $classDetail) && array_key_exists(Constants::INTERFACE_KEY, $classDetail))
		{
			$classDetail1 = Initializer::$jsonDetails[$packageName];
			$groupType1 = $classDetail1[$groupType];
			if ($groupType1 != null)
			{
				$classes = $groupType1[Constants::CLASSES];
				$className = $this->findMatchClass($classes, $responseJson);
				$instance = $this->getClassInstance($className);
				$this->getMapResponse($instance, $responseJson, $classDetail);
			}
		}
		else
		{
			$instance = $this->getClassInstance($packageName);
			$this->getMapResponse($instance, $responseJson, $classDetail);
		}
		return $instance;
    }

    private function getMapResponse($instance, $response, $classDetail)
	{
		foreach ($classDetail as $memberName => $memberValue)
		{
			$keyDetail = $classDetail[$memberName];
			$keyName = $keyDetail[Constants::NAME] ? $keyDetail[Constants::NAME] : null;
			if ($keyName != null && array_key_exists($keyName, $response) && $response[$keyName] != null)
			{
				$keyData = $response[$keyName];
                $reflector = new \ReflectionClass($instance);
                $member = $reflector->getProperty($memberName);
                $member->setAccessible(true);
                $memberValue = $this->getData($keyData, $keyDetail);
                $member->setValue($instance, $memberValue);
			}
		}
	}

    public function getResponse($response, $packageName, $groupType)
	{
		$classDetail = Initializer::$jsonDetails[$packageName];
		$responseJson = $this->getJSONResponse($response);
		$instance = null;
		if($responseJson != null)
		{
			if (array_key_exists(Constants::INTERFACE_KEY, $classDetail) && $classDetail[Constants::INTERFACE_KEY])// if interface
			{
				$classDetail1 = Initializer::$jsonDetails[$packageName];
				$groupType1 = $classDetail1[$groupType];
				if($groupType1 != null)
				{
					$classes = $groupType1[Constants::CLASSES];
					$instance = $this->findMatch($classes, $responseJson, $groupType);// find match returns instance(calls getResponse() recursively)
				}
			}
			else
			{
				$instance = $this->getClassInstance($packageName);
				$this->notRecordResponse($instance, $responseJson, $classDetail);// based on json details data will be assigned
			}
		}
		return $instance;
	}

    private function notRecordResponse($instance, $responseJson, $classDetail)
	{
		foreach ($classDetail as $memberName)
		{
			$keyDetail = $classDetail[$memberName];
			$keyName = $keyDetail[Constants::NAME] ? $keyDetail[Constants::NAME] : null;
			if ($keyName != null && $responseJson[$keyName] && $responseJson[$keyName] != null)
			{
				$keyData = $responseJson[$keyName];
                $reflector = new \ReflectionClass($instance);
                $member = $reflector->getProperty($memberName);
                $member->setAccessible(true);
                $memberValue = $this->getData($keyData, $keyDetail);
                $member->setValue($instance, $memberValue);
			}
		}
	}

    private function getData($keyData, $memberDetail)
	{
		$memberValue = null;
		if (!is_null($keyData))
		{
			$groupType = array_key_exists(Constants::GROUP_TYPE, $memberDetail) ? $memberDetail[Constants::GROUP_TYPE] : null;
			$type = $memberDetail[Constants::TYPE];
			if(is_resource($keyData))
			{
				return $this->getStreamInstance($keyData, $type);
			}
			else if ($type == Constants::LIST_NAMESPACE)
			{
				$memberValue = $this->getCollectionsData($keyData, $memberDetail, $groupType);
			}
			else if ($type == Constants::MAP_NAMESPACE)
			{
				$memberValue = $this->getMapData($keyData, $memberDetail);
			}
			else if ($type == Constants::CHOICE_NAMESPACE || (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail) && $memberDetail[Constants::STRUCTURE_NAME] == Constants::CHOICE_NAMESPACE))
			{
				$memberValue = new Choice($keyData);
			}
			else if (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
			{
				$memberValue = $this->getResponse($keyData, $memberDetail[Constants::STRUCTURE_NAME], $groupType);
			}
			else
			{
				$memberValue = DataTypeConverter::preConvert($keyData, $type);
			}
		}
		return $memberValue;
	}

    private function getCollectionsData($responses, $memberDetail, $groupType)
    {
		$values = array();
		if (sizeof($responses) > 0)
		{
			if ($memberDetail == null)
			{
				foreach ($responses as $response)
				{
					$values[] = $this->redirectorForJSONToObject($response);
				}
			}
			else
			{
				$specType = $memberDetail[Constants::SPEC_TYPE];
				if($groupType != null)
				{
					if($specType == Constants::TARRAY_TYPE)
					{
						return $this->getTArrayResponse($memberDetail, $groupType, $responses);
					}
					else
					{
						$orderedStructures = null;
						if(array_key_exists(Constants::ORDERED_STRUCTURES, $memberDetail))
						{
							$orderedStructures = $memberDetail[Constants::ORDERED_STRUCTURES];
							if (sizeof($orderedStructures) > sizeof($responses))
							{
								return $values;
							}
							for ($i = 0; $i < sizeof($orderedStructures) - 1; $i++)
							{
                                $orderedStructure = $orderedStructures[$i];
								if(!array_key_exists(Constants::MEMBERS, $orderedStructure))
								{
									$values[] = $this->getResponse($responses[$i], $orderedStructure[Constants::STRUCTURE_NAME], $groupType);
								}
								else
								{
									if(array_key_exists(Constants::MEMBERS, $orderedStructure))
									{
										$values[] = $this->getMapData($responses[$i], $orderedStructure[Constants::MEMBERS]);
									}
								}
							}
						}
						if($groupType == Constants::ARRAY_OF && array_key_exists(Constants::INTERFACE_KEY, $memberDetail) && $memberDetail[Constants::INTERFACE_KEY])
						{
							$interfaceName = $memberDetail[Constants::STRUCTURE_NAME];
							$classDetail = Initializer::$jsonDetails[$interfaceName];
							$groupType1 = $classDetail[Constants::ARRAY_OF];
							if($groupType1 != null)
							{
								$classes = $groupType1[Constants::CLASSES];
								if($orderedStructures != null)
								{
									$classes = $this->validateInterfaceClass($orderedStructures, $groupType1[Constants::CLASSES]);
								}
								$values[] = $this->getArrayOfResponse($responses, $classes, $groupType)[0];
							}
						}
						else if($groupType == Constants::ARRAY_OF && $memberDetail[Constants::EXTRA_DETAILS])
						{
							$extraDetails = $memberDetail[Constants::EXTRA_DETAILS];
							if($orderedStructures != null)
							{
								$extraDetails = $this->validateStructure($orderedStructures, $extraDetails);
							}
							$i = 0;
							foreach ($responses as $responseObject)
							{
								if($i == sizeof($extraDetails))
								{
									$i = 0;
								}
								$extraDetail = $extraDetails[$i];
								if (!array_key_exists(Constants::MEMBERS, $extraDetails[$i]))
								{
									$values[] = $this->getResponse($responseObject, $extraDetail[Constants::STRUCTURE_NAME], $groupType);
								}
								else
								{
									if(array_key_exists(Constants::MEMBERS, $extraDetail))
									{
										$values[] = $this->getMapData($responseObject, $extraDetail[Constants::MEMBERS]);
									}
								}
								$i++;
							}
						}
						else
						{
							if(array_key_exists(Constants::INTERFACE_KEY, $memberDetail) && $memberDetail[Constants::INTERFACE_KEY])
							{
								if($orderedStructures != null)
								{
									$interfaceName = $memberDetail[Constants::STRUCTURE_NAME];
									$classDetail = Initializer::$jsonDetails[$interfaceName];
									$groupType1 = $classDetail[Constants::ARRAY_OF];
									if($groupType1 != null)
									{
										$classes = $this->validateInterfaceClass($orderedStructures, $groupType1[Constants::CLASSES]);
										foreach ($responses as $response)
										{
											$packName = $this->findMatchClass($classes, $response);
											$values[] = $this->getResponse($response, $packName, $groupType);
										}
									}
								}
								else
								{
									foreach ($responses as $response)
									{
										$values[] = $this->getResponse($response, $memberDetail[Constants::STRUCTURE_NAME], $groupType);
									}
								}
							}
							else
							{
								if(array_key_exists(Constants::EXTRA_DETAILS, $memberDetail))
								{
									$extraDetails = $memberDetail[Constants::EXTRA_DETAILS];
									if($orderedStructures != null)
									{
										$extraDetails = $this->validateStructure($orderedStructures, $extraDetails);
									}
									foreach ($responses as $responseObject)
									{
										$extraDetail = $this->findMatchExtraDetail($extraDetails, $responseObject);
										if(!array_key_exists(Constants::MEMBERS, $extraDetail))
										{
											$values[] = $this->getResponse($responseObject, $extraDetail[Constants::STRUCTURE_NAME], $groupType);
										}
										else
										{
											if(array_key_exists(Constants::MEMBERS, $extraDetail))
											{
												$values[] = $this->getMapData($responseObject, $extraDetail[Constants::MEMBERS]);
											}
										}
									}
								}
								else
								{
									$pack = $memberDetail[Constants::STRUCTURE_NAME];
									foreach ($responses as $response)
									{
										$values[] = $this->getResponse($response, $pack, $groupType);
									}
								}
							}
						}
					}
				}
				else// need to have structure Name in memberDetail
				{
					$pack = $memberDetail[Constants::STRUCTURE_NAME];
					if (strtolower($pack) == strtolower(Constants::CHOICE_NAMESPACE))
					{
                        foreach ($responses as $response)
						{
							$values[] = new Choice($response);
						}
					}
					else
					{
						foreach ($responses as $response)
						{
							$values[] = $this->getResponse($response, $pack, null);
						}
					}
				}
			}
		}
		return $values;
	}

    private function getTArrayResponse($memberDetail, $groupType, $responses)
	{
		$values = array();
		if (array_key_exists(Constants::INTERFACE_KEY, $memberDetail) && $memberDetail[Constants::INTERFACE_KEY] && array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))// if interface
		{
			$classDetail1 = Initializer::$jsonDetails[$memberDetail[Constants::STRUCTURE_NAME]];
			$groupType1 = $classDetail1[$groupType];
			if($groupType1 != null)
			{
				$className = $this->findMatchClass($groupType1[Constants::CLASSES], $responses[0]);
				foreach ($responses as $response)
				{
					$values[] = $this->getResponse($response, $className, null);
				}
			}
		}
		else
		{
			if (array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
			{
				foreach ($responses as $response)
				{
					$values[] = $this->getResponse($response, $memberDetail[Constants::STRUCTURE_NAME], null);
				}
			}
			else
			{
				if (array_key_exists(Constants::EXTRA_DETAILS, $memberDetail))
				{
					$extraDetails = $memberDetail[Constants::EXTRA_DETAILS];
					if($extraDetails != null && sizeof($extraDetails) > 0)
					{
						foreach ($responses as $response)
						{
							$extraDetail = $this->findMatchExtraDetail($extraDetails, $response);
							if(!array_key_exists(Constants::MEMBERS, $extraDetail))
							{
								$values[] = $this->getResponse($response, $extraDetail[Constants::STRUCTURE_NAME], null);
							}
							else
							{
								if(array_key_exists(Constants::MEMBERS,$extraDetail))
								{
									$values[] = $this->getMapData($response, $extraDetail[Constants::MEMBERS]);
								}
							}
						}
					}
				}
			}
		}
		return $values;
	}

	private function getMapData($response, $memberDetail)
	{
		$mapInstance = [];
		if (sizeof($response) > 0)
		{
			if ($memberDetail == null)
			{
				foreach ($response as $key => $value)
				{
					$mapInstance[$key] = $this->redirectorForJSONToObject($value);
				}
			}
			else
			{
				$responseKeys = array_keys($response);
				if(array_key_exists(Constants::EXTRA_DETAILS, $memberDetail))// if structure name is null the property add in extra_details.
				{
					$extraDetails = $memberDetail[Constants::EXTRA_DETAILS];
					$extraDetail = $this->findMatchExtraDetail($extraDetails, $response);
					if(array_key_exists(Constants::MEMBERS, $extraDetail))
					{
						$memberDetails = $extraDetail[Constants::MEMBERS];
						foreach($responseKeys as $key)
						{
							if(array_key_exists($key, $memberDetails))
							{
								$memberDetail1 = $memberDetails[$key];
								$mapInstance[$memberDetail1[Constants::NAME]] = $this->getData($response[$key], $memberDetail1);
							}
						}
					}
				}
			}
		}
		return $mapInstance;
	}

	private function redirectorForJSONToObject($keyData)// only if structure doesn't exist
	{
        $type = gettype($keyData);
        if ($type == Constants::ARRAY_KEY)
        {
            foreach (array_keys($keyData) as $key)
            {
                if (gettype($key) == strtolower(Constants::STRING_NAMESPACE))
                {
                    $type = Constants::MAP_NAMESPACE;
                }
                break;
            }
            if ($type == Constants::MAP_NAMESPACE)
            {
                return $this->getMapData($keyData, null);
            }
            else
            {
                return $this->getCollectionsData($keyData, null, null);
            }
        }
        else
        {
            return $keyData;
        }
	}

	private function getStreamInstance($response, $type)
	{
		list ($headers, $content) = explode("\r\n\r\n", strval($response), 2);
		$responseHeaders = (explode("\r\n", $headers, 50));
        $responseContent = $content;
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

    function parseMultipartPart($part)
    {
        $partData = [];
        preg_match('/name="(.*?)"/', $part, $matches);
        $partData['name'] = $matches[1];
        if (preg_match('/filename="(.*?)"/', $part, $matches)) 
		{
            $partData['filename'] = $matches[1];
            $partData['data'] = substr($part, strpos($part, "\r\n\r\n") + 4);
        } else 
		{
            $partData['value'] = substr($part, strpos($part, "\r\n\r\n") + 4);
        }
        return $partData;
    }

	private function parseMultipartResponse($responseStream)
	{
        $response = [];
		list ($headers, $content) = explode("\r\n\r\n", strval($responseStream), 2);
		$header = (explode("\r\n", $headers, 50));
        $body = $content;
        preg_match('/boundary(.*)$/', $content, $matches);
        $boundary = trim($matches[1], '"');
        $parts = explode('--' . $boundary, $body);
        foreach ($parts as $part) 
        {
			if($part != null)
			{
				$data = $this->parseMultipartPart($part);
				$response[$data["name"]] = $data["value"];
			}
        }
		return $response;
	}

	public function findMatchAndParseResponseClass($contents, $responseStream)
	{
		$response = $this->parseMultipartResponse($responseStream);
		if(!empty($response))
		{
			$ratio = 0;
			$structure = 0;
			$classes = null;
			for($i = 0; $i < sizeof($contents); $i++)
			{
				$content = $contents[$i];
				$ratio1 = 0;
				if (array_key_exists(Constants::INTERFACE_KEY, $content) && $content[Constants::INTERFACE_KEY])
				{
					$interfaceName = $content[Constants::CLASSES][0];
					$classDetail = Initializer::$jsonDetails[$interfaceName];
					$groupType1 = $classDetail[$content[Constants::GROUP_TYPE]];
					if($groupType1 == null)
					{
						return null;
					}
					$classes = $groupType1[Constants::CLASSES];
				}
				else
				{
					$classes = $content[Constants::CLASSES];
				}
				if($classes == null || empty($classes))
				{
					return null;
				}
				foreach ($classes as $className)
				{
					$matchRatio = $this->findRatioClassName($className, $response);
					if ($matchRatio == 1.0)
					{
						return [$contents[$i], $response];
					}
					else if ($matchRatio > $ratio1)
					{
						$ratio1 = $matchRatio;
					}
				}
				if($ratio < $ratio1)
				{
					$structure = $i;
				}
			}
			return [$classes[$structure], $response];
		}
		return null;
	}

	private function findMatch($classes, $responseJson, $groupType)
	{
		if(sizeof($classes) == 1)
		{
			return $this->getResponse($responseJson, $classes[0], $groupType);
		}
		$pack = "";
		$ratio = 0;
		foreach ($classes as $className)
		{
			$matchRatio = $this->findRatio($className, $responseJson);
			if ($matchRatio == 1.0)
			{
				$pack = $className;
				break;
			}
			else if ($matchRatio > $ratio)
			{
				$pack = $className;
				$ratio = $matchRatio;
			}
		}
		return $this->getResponse($responseJson, $pack, $groupType);
	}

	public function getArrayOfResponse($responseObject, $classes, $groupType)
	{
	    $responseArray = $this->getJSONArrayResponse($responseObject);
		if ($responseArray == null)
		{
			return null;
		}
		$i = 0;
		$responseClass = [];
		foreach($responseArray as $responseArray1)
		{
			if($i == sizeof($classes))
			{
				$i = 0;
			}
			$responseClass[] = $this->getResponse($responseArray1, $classes[$i], $groupType);
			$i++;
		}
		return [$responseClass, $responseArray];
	}
}
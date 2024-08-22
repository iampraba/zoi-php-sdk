<?php
namespace com\zoho\officeintegrator\util;

use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\Initializer;
use com\zoho\officeintegrator\util\DataTypeConverter;
use com\zoho\officeintegrator\util\Constants;

/**
 * This class processes the API response object to the POJO object and POJO object to a JSON object.
 */
class JSONConverter extends Converter
{
    private $_uniqueValuesMap = array();

    public function __construct($commonAPIHandler)
    {
        parent::__construct($commonAPIHandler);
    }

    public function appendToRequest(&$requestBase, $requestObject)
    {
        $requestBase[CURLOPT_POSTFIELDS] = json_encode($requestObject, JSON_UNESCAPED_UNICODE);
    }

    public function getWrappedRequest($requestInstance, $pack)
	{
		$groupType = $pack[Constants::GROUP_TYPE];
		if($groupType == Constants::ARRAY_OF)
		{
			if (array_key_exists(Constants::INTERFACE_KEY, $pack) && $pack[Constants::INTERFACE_KEY])
			{
                $type = gettype($requestInstance);
                if ($type == Constants::ARRAY_KEY)
				{
                    foreach (array_keys($requestInstance) as $key)
                    {
                        if (gettype($key) == strtolower(Constants::STRING_NAMESPACE))
                        {
                            $type = strtolower(Constants::MAP_NAMESPACE);
                        }
                        break;
                    }
                    if ($type == strtolower(Constants::MAP_NAMESPACE))
                    {
                        return $this->formRequest($requestInstance, get_class($requestInstance), null, null, $groupType);
                    }
                    else
                    {
                        if (!empty($requestInstance))
                        {
                            $jsonArray = array();
                            $instanceCount = 0;
                            foreach ($requestInstance as $request)
                            {
                                $jsonArray[] = $this->formRequest($request, get_class($request), $instanceCount, null, $groupType);
                                $instanceCount++;
                            }
                            return $jsonArray;
                        }
                    }
				}
				else
				{
					return $this->formRequest($requestInstance, get_class($requestInstance), null, null, $groupType);
				}
			}
			else
			{
				return $this->formRequest($requestInstance, get_class($requestInstance), null, null, $groupType);
			}
		}
		else
		{
			return $this->formRequest($requestInstance, get_class($requestInstance), null, null, $groupType);
		}
		return null;
	}

    public function formRequest($requestInstance, $pack, $instanceNumber, $memberDetail=null, $groupType=null)
    {
        $classDetail = Initializer::$jsonDetails[$pack];
        if (array_key_exists(Constants::INTERFACE_KEY, $classDetail) && $classDetail[Constants::INTERFACE_KEY] == true)
        {
            $groupType1 = $classDetail[$groupType];
            if($groupType1 != null)
            {
                $classes = $groupType1[Constants::CLASSES];
                $requestObjectClassName = get_class($requestInstance);
                foreach ($classes as $className)
                {
                    if (strtolower($className) == strtolower($requestObjectClassName))
                    {
                        $classDetail = Initializer::$jsonDetails[$requestObjectClassName];
                        break;
                    }
                }
            }  
        }
        return $this->isNotRecordRequest($requestInstance, $classDetail, $instanceNumber, $memberDetail);        
    }

    private function isNotRecordRequest($requestInstance, $classDetail, $instanceNumber, $classMemberDetail = null)
    {
        $lookUp = false;
        $skipMandatory = false;
        $classMemberName = null;
        if ($classMemberDetail !== null)
        {
            if (array_key_exists(Constants::LOOKUP, $classMemberDetail))
            {
                $lookUp = $classMemberDetail[Constants::LOOKUP];
            }
            $classMemberName = $this->buildName($classMemberDetail[Constants::NAME]);
        }
        $reflector = new \ReflectionClass($requestInstance);
        $requestJSON = array();
		$requiredKeys = array();
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
                $requiredKeys[$keyName] = 1;
            }
            $fieldValue = null;
            if ($modification != null && $modification != 0 )
            {
                $field = $reflector->getProperty($memberName);
                $field->setAccessible(true);
                $fieldValue = $field->getValue($requestInstance);
                if($fieldValue != null)
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
            $type = $memberDetail[Constants::TYPE];
            return $this->setDataValue($type, $memberDetail, $fieldValue);
        }
        return null;
    }
    
    private function setDataValue($type, $memberDetail, $fieldValue)
    {
        $groupType = array_key_exists(Constants::GROUP_TYPE, $memberDetail) ? $memberDetail[Constants::GROUP_TYPE] : null;
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
            return $this->formRequest($fieldValue, $memberDetail[Constants::STRUCTURE_NAME], null, $memberDetail, $groupType);
        }
        else
        {
            return DataTypeConverter::postConvert($fieldValue, $type);
        }
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
        if (sizeof($requestObjects) > 0)
        {
            if ($memberDetail == null || ($memberDetail != null && !array_key_exists(Constants::STRUCTURE_NAME, $memberDetail)))
            {
                if($memberDetail != null && array_key_exists(Constants::SUB_TYPE, $memberDetail))
				{
					$subType = $memberDetail[Constants::SUB_TYPE];
					$type = $subType[Constants::TYPE];
					if (strtolower($type) == strtolower(Constants::CHOICE_NAMESPACE))
					{
						foreach ($requestObjects as $request)
						{
							$jsonArray[] = $request->getValue();
						}
					}
					else
					{
						foreach ($requestObjects as $request)
						{
							$jsonArray[] = $this->setDataValue($type, $memberDetail, $request);
						}
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
            else
            {
                if(array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
                {
                    $pack = $memberDetail[Constants::STRUCTURE_NAME];
                    if (strtolower($pack) == strtolower(Constants::CHOICE_NAMESPACE))
                    {
                        foreach ($requestObjects as $request)
                        {
                            $jsonArray[] = $request->getValue();
                        }
                    }
                    else
                    {
                        $instanceCount = 0;
                        foreach ($requestObjects as $request)
                        {
                            $jsonArray[] = $this->formRequest($request, $pack, $instanceCount, $memberDetail, $groupType);
                            $instanceCount++;
                        }
                    }
                }
                else
				{
					$instanceCount = 0;
					foreach ($requestObjects as $request)
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
                        }
						if ($type == strtolower(Constants::MAP_NAMESPACE))
						{
							$extraDetails = $memberDetail[Constants::EXTRA_DETAILS];
							if ($extraDetails != null && sizeof($extraDetails) > 0)
							{
								$members = $this->getValidStructure($extraDetails, array_keys($request));
								$jsonArray[] = $this->isNotRecordRequest($request, $members, null, null);
							}
							else
							{
								$jsonArray[] = $this->redirectorForObjectToJSON($request);
							}
						}
						else
						{
							$jsonArray[] = $this->formRequest($request, get_class($request), $instanceCount, $memberDetail, $groupType);
						}
						$instanceCount++;
					}
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
                    $type = Constants::MAP_NAMESPACE;
                }

                break;
            }
            if ($type == Constants::MAP_NAMESPACE)
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
        list ($headers, $content) = explode("\r\n\r\n", strval($response), 2);
        $responseObject = json_decode($content, true);
        if ($responseObject == NULL && $content != null)
        {
            list ($headers, $content) = explode("\r\n\r\n", $content, 2);
            $responseObject = json_decode($content, true);
        }
        if ($responseObject != null)
        {
            $pack = null;
			if(sizeof($contents) == 1)
			{
				$pack = $contents[0];
			}
			else
			{
				$pack = $this->findMatchResponseClass($contents, $responseObject);
			}
			if($pack != null)
			{
				$groupType = $pack[Constants::GROUP_TYPE];
				if($groupType == Constants::ARRAY_OF)
				{
					if (array_key_exists(Constants::INTERFACE_KEY, $pack) && $pack[Constants::INTERFACE_KEY])
					{
						$interfaceName = $pack[Constants::CLASSES][0];
						$classDetail = Initializer::$jsonDetails[$interfaceName];
						$groupType1 = $classDetail[Constants::ARRAY_OF];
						if($groupType1 != null)
						{
							return $this->getArrayOfResponse($responseObject, $groupType1[Constants::CLASSES], $groupType);
						}
					}
					else
					{
						return $this->getArrayOfResponse($responseObject, $pack[Constants::CLASSES], $groupType);
					}
				}
				else
				{
					$responseJSON = $this->getJSONResponse($responseObject);
					if (array_key_exists(Constants::INTERFACE_KEY, $pack) && $pack[Constants::INTERFACE_KEY])// if interface
					{
						$interfaceName = $pack[Constants::CLASSES][0];
						return [$this->getResponse($responseObject, $interfaceName, $groupType), $responseJSON];
					}
					else
					{
						$packName = $this->findMatchClass($pack[Constants::CLASSES], $responseJSON);
						return [$this->getResponse($responseObject, $packName, $groupType), $responseJSON];
					}
				}
			}
		}
		return null;
	}

    public function getResponse($response, $packageName, $groupType)
    {
        $classDetail = Initializer::$jsonDetails[$packageName];
		$responseJson = $this->getJSONResponse($response);
        $instance = null;
        if (!empty($responseJson) && $responseJson != null)
        {
            if (array_key_exists(Constants::INTERFACE_KEY, $classDetail) && $classDetail[Constants::INTERFACE_KEY]) // if interface
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
                $instance = $this->notRecordResponse($instance, $responseJson, $classDetail);// based on json details data will be assigned
            }
        }
        return $instance;
    }

    public function notRecordResponse($instance, $responseJSON, $classDetail)
    {
        foreach ($classDetail as $memberName => $keyDetail)
        {
            $keyName = array_key_exists(Constants::NAME, $keyDetail) ? $keyDetail[Constants::NAME] : null;// api-name of the member
            if ($keyName != null && array_key_exists($keyName, $responseJSON) && $responseJSON[$keyName] !== null)
            {
                $keyData = $responseJSON[$keyName];
                $reflector = new \ReflectionClass($instance);
                $member = $reflector->getProperty($memberName);
                $member->setAccessible(true);
                $memberValue = $this->getData($keyData, $keyDetail);
                $member->setValue($instance, $memberValue);
            }
        }
        return $instance;
    }

    public function getData($keyData, $memberDetail)
    {
        $memberValue = null;
        if(!is_null($keyData))
        {
            $type = $memberDetail[Constants::TYPE];
            $memberValue = $this->getDataValue($type, $keyData, $memberDetail);
		}
		return $memberValue;
	}

    private function getDataValue($type, $keyData, $memberDetail)
    {
        $groupType = array_key_exists(Constants::GROUP_TYPE, $memberDetail) ? $memberDetail[Constants::GROUP_TYPE] : null;
		$memberValue = null;
        if ($type == Constants::LIST_NAMESPACE)
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
        return $memberValue;
    }

    public function getCollectionsData($responses, $memberDetail, $groupType)
    {
        $values = array();
        if(sizeof($responses) > 0)
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
							if(sizeof($orderedStructures) > sizeof($responses))
							{
								return $values;
							}
							foreach (array_keys($orderedStructures) as $index)
							{
								$orderedStructure = $orderedStructures[$index];
								if(!array_key_exists(Constants::MEMBERS, $orderedStructure))
								{
									$values[] = $this->getResponse($responses[$index], $orderedStructure[Constants::STRUCTURE_NAME], $groupType);
								}
								else
								{
									if(array_key_exists(Constants::MEMBERS, $orderedStructure))
									{
										$values[] = $this->getMapData($responses[$index], $orderedStructure[Constants::MEMBERS]);
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
						else if($groupType == Constants::ARRAY_OF && array_key_exists(Constants::EXTRA_DETAILS, $memberDetail))
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
								if(!array_key_exists(Constants::MEMBERS, $extraDetails[$i]))
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
									$pack = null;
									if(array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
									{
										$pack = $memberDetail[Constants::STRUCTURE_NAME];
									}
									else if(array_key_exists(Constants::SUB_TYPE, $memberDetail))
									{
										$pack = $memberDetail[Constants::SUB_TYPE][Constants::TYPE];
									}
									if($pack != null)
									{
                                        foreach ($responses as $response)
										{
											$values[] = $this->getResponse($response, $pack, $groupType);
										}
									}
								}
							}
						}
					}
				}
                else // need to have structure Name in memberDetail
                {
                    $pack = null;
                    if(array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
                    {
                        $pack = $memberDetail[Constants::STRUCTURE_NAME];
                    }
                    else if(array_key_exists(Constants::SUB_TYPE, $memberDetail))
                    {
                        $pack = $memberDetail[Constants::SUB_TYPE][Constants::TYPE];
                    }
                    if ($pack == Constants::CHOICE_NAMESPACE)
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

    public function getMapData($response, $memberDetail)
    {
        $mapInstance = array();
        if(sizeof($response) > 0)
        {
            if ($memberDetail == null)
            {
                foreach ($response as $key => $response)
                {
                    $mapInstance[$key] = $this->redirectorForJSONToObject($response);
                }
            }
            else// member must have keys
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

    public function redirectorForJSONToObject($keyData)
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

    public function findMatch($classes, $responseJson, $groupType)
    {
        if(sizeof($classes) == 1)
		{
			return $this->getResponse($responseJson, $classes[0], $groupType);
		}
        $pack = "";
        $ratio = 0;
        foreach ($classes as $className)
        {
            $matchRatio = $this->findRatioClassName($className, $responseJson);
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

    private function getTArrayResponse($memberDetail, $groupType, $responses)
	{
		$values = array();
		if (array_key_exists(Constants::INTERFACE_KEY, $memberDetail) && $memberDetail.[Constants::INTERFACE_KEY] && $memberDetail[Constants::STRUCTURE_NAME])// if interface
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
                                if(array_key_exists(Constants::MEMBERS, $extraDetail))
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

	public function getArrayOfResponse($responseObject, $classes, $groupType)
	{
		$responseArray = $this->getJSONArrayResponse($responseObject);
		if ($responseArray == null)
		{
			return null;
		}
		$i = 0;
		$responseClass = array();
		foreach ($responseArray as $responseArray1)
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

    public function buildName($memberName)
    {
        $name = explode("_", \strtolower($memberName));
        $sdkName = lcfirst($name[0]);
        for ($nameIndex = 1; $nameIndex < count($name); $nameIndex ++)
        {
            $firstLetterUppercase = "";
            if(strlen(($name[$nameIndex])) > 0)
            {
                $firstLetterUppercase = ucfirst($name[$nameIndex]);
            }
            $sdkName = $sdkName . $firstLetterUppercase;
        }
        return $sdkName;
    }

    // public function findRatio($className, $responseJson)
    // {
    //     $classDetail = array();

    //     $classDetail = Initializer::$jsonDetails[$className];

    //     $totalPoints = sizeof(array_keys($classDetail));

    //     $matches = 0;

    //     if ($totalPoints == 0)
    //     {
    //         return 0;
    //     }
    //     else
    //     {
    //         foreach ($classDetail as $memberName => $memberDetail)
    //         {
    //             $memberDetail = $classDetail[$memberName];

    //             $keyName = null;

    //             if(array_key_exists(Constants::NAME, $memberDetail))
    //             {
    //                 $keyName = $memberDetail[Constants::NAME];
    //             }

    //             if ($keyName != null && array_key_exists($keyName, $responseJson) && (is_array($responseJson[$keyName]) || $responseJson[$keyName] !== null))
    //             {
    //                 $keyData = $responseJson[$keyName];

    //                 $type = gettype($keyData);

    //                 $structureName = null;

    //                 if(array_key_exists(Constants::STRUCTURE_NAME, $memberDetail))
    //                 {
    //                     $structureName = $memberDetail[Constants::STRUCTURE_NAME];
    //                 }

    //                 if ($type == Constants::ARRAY_KEY)
    //                 {
    //                     if(sizeof($keyData) > 0)
    //                     {
    //                         foreach ($keyData as $key => $value)
    //                         {
    //                             if (gettype($key) == strtolower(Constants::STRING_NAMESPACE))
    //                             {
    //                                 $type = Constants::MAP_NAMESPACE;
    //                             }
    //                             else
    //                             {
    //                                 $type = Constants::LIST_NAMESPACE;
    //                             }

    //                             break;
    //                         }
    //                     }
    //                     else
    //                     {
    //                         $type = Constants::LIST_NAMESPACE;
    //                     }
    //                 }
                    
    //                 if (strtolower($type) == strtolower($memberDetail[Constants::TYPE]))
    //                 {
    //                     $matches++;
    //                 }
    //                 else if(strtolower($keyName) == Constants::COUNT && strtolower($type) == strtolower(Constants::INTEGER_NAMESPACE))
	// 				{
	// 					$matches++;
	// 				}
    //                 else if (strtolower($memberDetail[Constants::TYPE]) == strtolower(Constants::CHOICE_NAMESPACE))
    //                 {
    //                     foreach ($memberDetail[Constants::VALUES] as $value)
    //                     {
    //                         if ($value == $keyData)
    //                         {
    //                             $matches ++;

    //                             break;
    //                         }
    //                     }
    //                 }

    //                 if($structureName != null && $structureName == $memberDetail[Constants::TYPE])
    //                 {
    //                     if(array_key_exists(Constants::VALUES, $memberDetail))
    //                     {
    //                         foreach($memberDetail[Constants::VALUES] as $value)
    //                         {
    //                             if($value == $keyData)
    //                             {
    //                                 $matches ++;

    //                                 break;
    //                             }
    //                         }
    //                     }
    //                     else
    //                     {
    //                         $matches ++;
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return $matches / $totalPoints;
    // }
}
<?php
namespace com\zoho\officeintegrator\util;

use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\Initializer;
use com\zoho\officeintegrator\util\Constants;

/**
 * This abstract class is to construct API request and response.
 */
abstract class Converter
{
    protected $commonAPIHandler;

    /**
     * Creates a Converter class instance with the CommonAPIHandler class instance.
     * @param CommonAPIHandler $commonAPIHandler A CommonAPIHandler class instance.
     */
    public function __construct($commonAPIHandler)
    {
       $this->commonAPIHandler = $commonAPIHandler;
    }

    public abstract function getResponse($response, $pack, $groupType);

	public abstract function getWrappedRequest($response, $pack);

    public abstract function formRequest($responseObject, $pack, $instanceNumber, $memberDetail=null, $groupType=null);

    public abstract function appendToRequest(&$requestBase, $requestObject);

    public abstract function getWrappedResponse($response, $pack);

    public function valueChecker($className, $memberName, $keyDetails, $value, &$uniqueValuesMap, $instanceNumber)
	{
		$detailsJO = array();
		$name = $keyDetails[Constants::NAME];
		$type  = $keyDetails[Constants::TYPE];
		$varType = gettype($value);
		$test = function ($varType, $type) { if(strtolower($varType) == strtolower($type)){return true; } return false;};
		$check = $test($varType, $type);
		if(array_key_exists($type, Constants::DATA_TYPE))
		{
			$type = Constants::DATA_TYPE[$type];
			if(is_array($value) &&  count($value) > 0 && array_key_exists(Constants::STRUCTURE_NAME, $keyDetails))
			{
				$structureName = $keyDetails[Constants::STRUCTURE_NAME];
				$index = 0;
				foreach($value as $data)
				{
					$className = get_class($data);
					$check = $test($className, $structureName);
					if(!$check)
					{
						$result = $data instanceof $structureName;
						if ($result)
						{
							$check = true;
						}
					}
					if(!$check)
					{
						$instanceNumber = $index;
						$type = Constants::ARRAY_KEY . "(" . $structureName . ")";
						$varType = Constants::ARRAY_KEY . "(" . $className . ")";
						break;
					}
					$index ++;
				}
			}
			else if(is_array($value) &&  count($value) > 0 &&  array_key_exists(Constants::SUB_TYPE, $keyDetails))
			{
				$index = 0;
				foreach($value as $data)
				{
					$subType = $keyDetails[Constants::SUB_TYPE];
					$sub_type = $subType[Constants::TYPE];
					$className = gettype($data);
					if(strtolower($sub_type) == strtolower(Constants::OBJECT))
					{
						$check = true;
					}
					else
					{
						if(array_key_exists($sub_type, Constants::DATA_TYPE))
						{
							$sub_type = Constants::DATA_TYPE[$sub_type];
							if(strtolower($className) == strtolower(Constants::OBJECT))
							{
								$className = get_class($data);
							}
						}
						$check = $test($className, $sub_type);
						if(!$check)
						{
							$result = $data instanceof $sub_type;
							if ($result)
							{
								$check = true;
							}
						}
						$varType = $className;
					}
					if(!$check)
					{
						$instanceNumber = $index;
						$type = Constants::ARRAY_KEY . "(" . $sub_type . ")";
						$varType = Constants::ARRAY_KEY . "(" . $className . ")";
						break;
					}
					$index ++;
				}
			}
			else
			{
				$check = $test($varType, $type);
				if(!$check)
				{
					$result = $value instanceof $type;
					if ($result)
					{
						$check = true;
					}
				}
			}
		}
		if(strtolower($varType) == strtolower(Constants::OBJECT) || strtolower($type) == strtolower(Constants::OBJECT))
		{
			if(strtolower($type) == strtolower(Constants::OBJECT))
			{
				$check = true;
			}
			else
			{
				$className1 = get_class($value);
				$check = $test($className1, $type);
				if(!$check)
				{
					$result = $value instanceof $type;
					if ($result)
					{
						$check = true;
					}
				}
				$varType = $className1;
			}
		}
		if (!$check && $value != null)
        {
            $detailsJO[Constants::FIELD] = $memberName;
            $detailsJO[Constants::CLASS_KEY] =  $className;
            $detailsJO[Constants::INDEX] = $instanceNumber;
			$detailsJO[Constants::EXPECTED_TYPE] = $type;
			$detailsJO[Constants::GIVEN_TYPE] = $varType;
			throw new SDKException(Constants::TYPE_ERROR, null, $detailsJO, null);
        }
		if(array_key_exists(Constants::VALUES, $keyDetails) && (!array_key_exists(Constants::PICKLIST, $keyDetails) || ($keyDetails[Constants::PICKLIST] && Initializer::getInitializer()->getSDKConfig()->getPickListValidation())))
		{
			$valuesJA = $keyDetails[Constants::VALUES];
            if (is_array($value))
            {
                $value_1 = $value;
                foreach ($value_1 as $value_2)
                {
                    if ($value_2 instanceof Choice)
                    {
                        $choice = $value_2;
                        $value_2 = $choice->getValue();
                    }
                    if (!in_array($value_2, $valuesJA))
                    {
                        $detailsJO[Constants::FIELD] =  $memberName;
                        $detailsJO[Constants::CLASS_KEY] = $className;
                        $detailsJO[Constants::INDEX] = $instanceNumber;
                        $detailsJO[Constants::GIVEN_VALUE] = $value;
                        $detailsJO[Constants::ACCEPTED_VALUES] =  $valuesJA;
                        throw new SDKException(Constants::UNACCEPTED_VALUES_ERROR, "", $detailsJO, null);
                    }
                }
            }
            else
            {
                if ($value instanceof Choice)
                {
                    $choice = $value;
                    $value = $choice->getValue();
                }
                if(!in_array($value, $valuesJA)) 
				{
                    $detailsJO[Constants::FIELD] = $memberName;
                    $detailsJO[Constants::CLASS_KEY] = $className;
                    $detailsJO[Constants::INDEX] = $instanceNumber;
                    $detailsJO[Constants::GIVEN_VALUE] = $value;
                    $detailsJO[Constants::ACCEPTED_VALUES] = $valuesJA;
                    throw new SDKException(Constants::UNACCEPTED_VALUES_ERROR, "", $detailsJO, null);
                }
            }
		}
		if(array_key_exists(Constants::UNIQUE, $keyDetails))
		{
			$valuesArray = null;
			if(array_key_exists($name, $uniqueValuesMap))
			{
				$valuesArray = $uniqueValuesMap[$name];
				if($valuesArray != null && in_array($value, $valuesArray))
				{
					$detailsJO[Constants::FIELD] =  $memberName;
					$detailsJO[Constants::CLASS_KEY] =  $className;
					$detailsJO[Constants::FIRST_INDEX] = array_search($value, $valuesArray);
					$detailsJO[Constants::NEXT_INDEX] =  $instanceNumber;
					throw new SDKException(Constants::UNIQUE_KEY_ERROR, null , $detailsJO, null);
				}
			}
			else
			{
				if($valuesArray == null)
				{
					$valuesArray = array();
				}
				$valuesArray[] = $value;
				$uniqueValuesMap[$name] = $valuesArray;
			}
		}
		if(array_key_exists(Constants::MIN_LENGTH, $keyDetails) || array_key_exists(Constants::MAX_LENGTH, $keyDetails))
		{
			$count = 0;
			if(is_array($value))
			{
				$count = count($value);
			}
			else
			{
				$count = strlen($value);
			}
		    if(array_key_exists(Constants::MAX_LENGTH, $keyDetails) && $count > $keyDetails[Constants::MAX_LENGTH])
			{
			    $detailsJO[Constants::FIELD] =  $memberName;
			    $detailsJO[Constants::CLASS_KEY] =  $className;
			    $detailsJO[Constants::GIVEN_LENGTH] =  $count;
			    $detailsJO[Constants::MAXIMUM_LENGTH] =  $keyDetails[Constants::MAX_LENGTH];
			    throw new SDKException(Constants::MAXIMUM_LENGTH_ERROR, null, $detailsJO, null);
			}
			if(array_key_exists(Constants::MIN_LENGTH, $keyDetails) && $count < $keyDetails[Constants::MIN_LENGTH])
			{
			    $detailsJO[Constants::FIELD] =  $memberName;
			    $detailsJO[Constants::CLASS_KEY] =  $className;
			    $detailsJO[Constants::GIVEN_LENGTH] =  $count;
			    $detailsJO[Constants::MINIMUM_LENGTH] = $keyDetails[Constants::MIN_LENGTH];
				throw new SDKException(Constants::MINIMUM_LENGTH_ERROR, null, $detailsJO, null);
			}
		}
        return true;
	}

	public function getClassInstance($packageName)
	{
		$class = new \ReflectionClass($packageName);
        return $class->newInstanceWithoutConstructor();
	}

	public function getJSONArrayResponse($responseJson)
	{
		if (empty($responseJson) || $responseJson == null || $responseJson == "{}" || $responseJson == "[]")
		{
			return null;
		}
		return $responseJson;
	}

	public function getJSONResponse($responseJson)
	{
		if (empty($responseJson) || $responseJson == null || $responseJson == "{}")
		{
			return null;
		}
		return $responseJson;
	}

	public function validateInterfaceClass($orderedStructures, $classes)
	{
		$validClasses = [];
		foreach ($classes as $className)
		{
			$isValid = false;
			foreach ($orderedStructures as $key => $value)
			{
				$orderedStructure = $value;
				if(!array_key_exists(Constants::MEMBERS, $orderedStructure))
				{
					if($className == $orderedStructure[Constants::STRUCTURE_NAME])
					{
						$isValid = true;
						break;
					}
				}
			}
			if(!$isValid)
			{
				$validClasses[] = $className;
			}
		}
		return $validClasses;
	}

	public function validateStructure($orderedStructures, $extraDetails)
	{
		$validStructure = [];
		foreach ($extraDetails as $extraDetail)
		{
			$extraDetail1 = $extraDetail;
			if(!array_key_exists(Constants::MEMBERS, $extraDetail1))
			{
				$isValid = false;
				foreach ($orderedStructures as $key => $value)
				{
					$orderedStructure = $value;
					if(!array_key_exists(Constants::MEMBERS, $orderedStructure))
					{
						$extraDetailStructureName = $extraDetail1[Constants::STRUCTURE_NAME];
						if($extraDetailStructureName == $orderedStructure[Constants::STRUCTURE_NAME])
						{
							$isValid = true;
							break;
						}
					}
				}
				if(!$isValid)
				{
					$validStructure[] = $extraDetail1;
				}
			}
			else
			{
				if(array_key_exists(Constants::MEMBERS, $extraDetail1))
				{
					$isValid = true;
					foreach ($orderedStructures as $key => $value)
					{
						$orderedStructure = $value;
						if(array_key_exists(Constants::MEMBERS, $orderedStructure))
						{
							$extraDetailStructureMembers = $extraDetail1[Constants::MEMBERS];
							$orderedStructureMembers = $orderedStructure[Constants::MEMBERS];
							if(count($extraDetailStructureMembers) == count($orderedStructureMembers))
							{
								foreach ($extraDetailStructureMembers as $name => $memberValue)
								{
									$extraDetailStructureMember = $memberValue;
									if(array_key_exists($name, $orderedStructureMembers))
									{
										$orderedStructureMember = $orderedStructureMembers[$name];
										if(array_key_exists(Constants::TYPE, $extraDetailStructureMember) && array_key_exists(Constants::TYPE, $orderedStructureMember) && !($extraDetailStructureMember[Constants::TYPE] == $orderedStructureMember[Constants::TYPE]))
										{
											$isValid = false;
											break;
										}
									}
									break;
								}
							}
						}
					}
					if(!$isValid)
					{
						$validStructure[] = $extraDetail1;
					}
				}
			}
		}
		return $validStructure;
	}

	public function findRatioClassName($className, $response)
	{
		$classDetail = Initializer::$jsonDetails[$className];
		return $this->findRatio($classDetail, $response);
	}

	public function findRatio($classDetail, $response)
	{
		$totalPoints = sizeof(array_keys($classDetail));
		$matches = 0;
		if ($totalPoints == 0)
		{
			return 0;
		}
		else
		{
			foreach ($classDetail as $memberName => $memberDetail)
			{
				$keyName = array_key_exists(Constants::NAME, $memberDetail) ? $memberDetail[Constants::NAME] : null;
				if ($keyName != null && array_key_exists($keyName, $response) && $response[$keyName] !== null)
				{
					$keyData = $response[$keyName];
					$type = gettype($keyData);
					$structureName = array_key_exists(Constants::STRUCTURE_NAME, $memberDetail) ? $memberDetail[Constants::STRUCTURE_NAME] : null;
					if ($type == Constants::ARRAY_KEY)
                    {
                        if(sizeof($keyData) > 0)
                        {
                            foreach ($keyData as $key => $value)
                            {
                                if (gettype($key) == strtolower(Constants::STRING_NAMESPACE))
                                {
                                    $type = Constants::MAP_NAMESPACE;
                                }
                                else
                                {
                                    $type = Constants::LIST_NAMESPACE;
                                }
                                break;
                            }
                        }
                        else
                        {
                            $type = Constants::LIST_NAMESPACE;
                        }
                    }
                    if (strtolower($type) == strtolower($memberDetail[Constants::TYPE]))
                    {
                        $matches++;
                    }
                    else if (strtolower($memberDetail[Constants::TYPE]) == strtolower(Constants::CHOICE_NAMESPACE))
                    {
                        foreach ($memberDetail[Constants::VALUES] as $value)
                        {
                            if ($value == $keyData)
                            {
                                $matches ++;
                                break;
                            }
                        }
                    }
					if($structureName != null && $structureName == $memberDetail[Constants::TYPE])
                    {
                        if(array_key_exists(Constants::VALUES, $memberDetail))
                        {
                            foreach($memberDetail[Constants::VALUES] as $value)
                            {
                                if($value == $keyData)
                                {
                                    $matches ++;
                                    break;
                                }
                            }
                        }
                        else
                        {
                            $matches ++;
                        }
                    }
					if (is_resource($keyData) && $memberDetail[Constants::SPEC_TYPE] == Constants::TFILE_TYPE)
					{
						$matches++;
					}
				}
			}
		}
		return $matches / $totalPoints;
	}

	public function findMatchExtraDetail($extraDetails, $responseObject)
	{
		$ratio = 0;
		$index = 0;
		for ($i = 0; $i < sizeof($extraDetails); $i++)
		{
			$classJSON = $extraDetails[$i];
			if(!array_key_exists(Constants::MEMBERS, $classJSON))
			{
				$matchRatio = $this->findRatioClassName($classJSON[Constants::STRUCTURE_NAME], $responseObject);
				if ($matchRatio == 1.0)
				{
					$index = $i;
					break;
				}
				else if ($matchRatio > $ratio)
				{
					$index = $i;
					$ratio = $matchRatio;
				}
			}
			else
			{
				if(array_key_exists(Constants::MEMBERS, $classJSON))
				{
					$matchRatio = $this->findRatio($classJSON[Constants::MEMBERS], $responseObject);
					if ($matchRatio == 1.0)
					{
						$index = $i;
						break;
					}
					else if ($matchRatio > $ratio)
					{
						$index = $i;
						$ratio = $matchRatio;
					}
				}

			}
		}
		return $extraDetails[$index];
	}

	public function findMatchClass($classes, $response)
	{
		$pack = "";
		$ratio = 0;
		foreach ($classes as $className)
		{
			$matchRatio = $this->findRatioClassName($className, $response);
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
		return $pack;
	}

	public function buildName($keyName)
	{
		$name = explode("_", $keyName);
		$sdkName = strtolower(substr($name[0], 0, 1)) . substr($name[0], 1);
		$index = 1;
		for ($nameIndex = $index; $nameIndex < sizeof($name); $nameIndex++)
		{
			$firstLetterUppercase = "";
			if(!empty($name[$nameIndex]))
			{
				$firstLetterUppercase = strtoupper(substr($name[$nameIndex], 0, 1)) . substr($name[$nameIndex], 1);
			}
			$sdkName = $sdkName . $firstLetterUppercase;
		}
		return $sdkName;
	}

	public function findMatchResponseClass($contents, $responseObject)
	{
		$response = null;
		if(is_array($responseObject))
		{
			if(sizeof($responseObject) > 0)
			{
				foreach ($responseObject as $key => $value)
				{
					if (gettype($key) == strtolower(Constants::STRING_NAMESPACE))
					{
						$response = $this->getJSONResponse($responseObject);
					}
					else
					{
						$response = $this->getJSONArrayResponse($responseObject)[0];
					}
					break;
				}
			}
		}
		if ($response != null)
		{
			$ratio = 0;
			$structure = 0;
			for ($i = 0; $i < sizeof($contents) ; $i++)
			{
				$content = $contents[$i];
				$ratio1 = 0;
				$classes = null;
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
				if($classes == null || sizeof($classes) == 0)
				{
					return null;
				}
				foreach ($classes as $className)
				{
					$matchRatio = $this->findRatioClassName($className, $response);
					if ($matchRatio == 1.0)
					{
						return $contents[$i];
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
			return $contents[$structure];
		}
		return null;
	}
}

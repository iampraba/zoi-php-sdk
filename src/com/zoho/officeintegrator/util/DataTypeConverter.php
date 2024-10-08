<?php
namespace com\zoho\officeintegrator\util;

use com\zoho\officeintegrator\util\Constants;

/**
 * This class converts JSON value to the expected data type.
 */
class DataTypeConverter
{
	private static $PRE_CONVERTER_MAP = array();
	private static $POST_CONVERTER_MAP = array();

	/**
	 * This method is to initialize the PreConverter and PostConverter lambda functions.
	 */
	static function init()
	{
	    if ((!empty(self::$PRE_CONVERTER_MAP) && count(self::$PRE_CONVERTER_MAP) != 0) && (!empty(self::$POST_CONVERTER_MAP) && count(self::$POST_CONVERTER_MAP) != 0))
		{
			return;
        }
		$string = function ($obj) { 
			if(preg_match('/\\\\u([0-9a-fA-F]{4})/', $obj))
			{
				return print_r(json_decode('' . $obj . ''), true);
			}
			return print_r($obj,true); 
		};
        $integer = function ($obj) { return intval($obj); };
        $float = function ($obj) { return floatval($obj); };
        $long = function ($obj) { return print_r($obj, true); };
		$bool = function ($obj) { return (bool)$obj; };
		$double = function ($obj) { return (double)$obj; };
        $stringToDateTime = function ($obj) { return date_create($obj)->setTimezone(new \DateTimeZone(date_default_timezone_get())); };
		$dateTimeToString = function ($obj) { return $obj->format(\Datetime::ATOM); };
		$stringToDate = function ($obj) { return date('Y-m-d', strtotime($obj)); };
		$dateToString = function ($obj) { return $obj->format('Y-m-d'); };
		$preObject = function ($obj) { return self::preConvertObjectData($obj); };
		$postObject = function ($obj) { return self::postConvertObjectData($obj); };
		$timeZonetoSting = function ($obj) { return $obj->getName(); };
		$stringtoTimeZone = function ($obj) { return new \DateTimeZone($obj); };
		$LocalTimetoSting = function ($obj) { return $obj->format("H:i"); };
		$stringtoLocalTime = function ($obj) { return \DateTime::createFromFormat("H:i", $obj); };
        self::addToMap(Constants::STRING_NAMESPACE, $string, $string);
        self::addToMap(Constants::INTEGER_NAMESPACE, $integer, $integer);
        self::addToMap(Constants::LONG_NAMESPACE, $long, $long);
        self::addToMap(Constants::FLOAT_NAMESPACE, $float, $float);
        self::addToMap(Constants::BOOLEAN_NAMESPACE, $bool, $bool);
        self::addToMap(\DateTime::class, $stringToDateTime, $dateTimeToString);
		self::addToMap(Constants::DATE, $stringToDate, $dateToString);
		self::addToMap(Constants::OBJECT, $preObject, $postObject);
		self::addToMap(Constants::DOUBLE_NAMESPACE, $double, $double);
		self::addToMap(Constants::TIMEZONE_NAMESPACE, $stringtoTimeZone, $timeZonetoSting);
		self::addToMap(Constants::LOCALTIME_NAMESPACE, $stringtoLocalTime, $LocalTimetoSting);
	}

	static function preConvertObjectData($obj)
	{
		return $obj;
	}

	static function postConvertObjectData($obj)
	{
		if(is_array($obj) &&  count($obj) > 0)
		{
			$list = array();
			foreach($obj as $data)
			{
				if($data instanceof \DateTime )
				{
					if($data->format('H') == "00" && $data->format('i') == "00" && $data->format('s') == "00" && $data->format('u') == "000000")
					{
						array_push($list, DataTypeConverter::postConvert($data, "Date"));
					}
					else
					{
						array_push($list, DataTypeConverter::postConvert($data, "DateTime"));
					}
				}
				else
				{
					array_push($list, $data);
				}
			}

			return $list;
		}
		return $obj;
	}

	static function addToMap($name, $preConverter, $postConverter)
	{
	    self::$PRE_CONVERTER_MAP[$name] = $preConverter;
	    self::$POST_CONVERTER_MAP[$name] = $postConverter;
	}

    static function preConvert($obj, $type)
	{
		self::init();
		if(array_key_exists($type, self::$PRE_CONVERTER_MAP))
		{
			return self::$PRE_CONVERTER_MAP[$type]($obj);
		}
        return $obj;
	}

	static function postConvert($obj, $type)
	{
		self::init();
		if(array_key_exists($type, self::$POST_CONVERTER_MAP))
		{
			return self::$POST_CONVERTER_MAP[$type]($obj);
		}
		return $obj;
	}
}
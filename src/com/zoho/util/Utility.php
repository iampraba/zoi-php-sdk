<?php
namespace com\zoho\util;

use com\zoho\exception\SDKException;
/**
 * This class handles module field details.
 */
class Utility
{
    public static $apiTypeVsDataType = array();

    public static $apiTypeVsStructureName = array();

    public static $jsonDetails;

    public static $newFile = false;

    public static $getModifiedModules = false;

    public static $forceRefresh = false;

    public static function assertNotNull($value, $errorCode, $errorMessage)
	{
		if($value == null)
		{
			throw new SDKException($errorCode, $errorMessage);
		}
    }

    public static function getJSONObject($json, $key)
    {
        foreach ($json as $keyJSON => $value)
        {
            if (strtolower($key) == strtolower($keyJSON))
            {
                return $value;
            }
        }
    return null;
    }
}
?>
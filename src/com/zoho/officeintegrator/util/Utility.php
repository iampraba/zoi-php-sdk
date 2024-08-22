<?php
namespace com\zoho\officeintegrator\util;

use com\zoho\officeintegrator\exception\SDKException;
/**
 * This class handles module field details.
 */
class Utility
{
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
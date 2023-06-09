<?php
namespace com\zoho\dc;

use com\zoho\dc\DataCenter;

/**
 * This class represents the properties of Zoho in IN Domain.
 */
class INDataCenter extends DataCenter
{
    private static $PRODUCTION = null;

    private static $SANDBOX = null;

    private static $DEVELOPER = null;

    private static $IN = null;

    /**
     * This Environment class instance represents the Zoho Production Environment in IN Domain.
     * @return Environment A Environment class instance.
     */
    public static function PRODUCTION()
    {
        self::$IN = new INDataCenter();

        if (self::$PRODUCTION == null)
        {
            self::$PRODUCTION = DataCenter::setEnvironment("https://www.zohoapis.in", self::$IN ->getIAMUrl(), self::$IN->getFileUploadUrl(), "in_prd");
        }

        return self::$PRODUCTION;
    }

    /**
     * This Environment class instance represents the Zoho Sandbox Environment in IN Domain.
     * @return Environment A Environment class instance.
     */
    public static function SANDBOX()
    {
        self::$IN = new INDataCenter();

        if (self::$SANDBOX == null)
        {
            self::$SANDBOX = DataCenter::setEnvironment("https://sandbox.zohoapis.in", self::$IN ->getIAMUrl(), self::$IN->getFileUploadUrl(), "in_sdb");
        }

        return self::$SANDBOX;
    }

    /**
     * This Environment class instance represents the Zoho Developer Environment in IN Domain.
     * @return Environment A Environment class instance.
     */
    public static function DEVELOPER()
    {
        self::$IN = new INDataCenter();

        if (self::$DEVELOPER == null)
        {
            self::$DEVELOPER = DataCenter::setEnvironment("https://developer.zohoapis.in", self::$IN ->getIAMUrl(), self::$IN->getFileUploadUrl(), "in_dev");
        }

        return self::$DEVELOPER;
    }

    public function getIAMUrl()
    {
        return "https://accounts.zoho.in/oauth/v2/token";
    }

    public function getFileUploadUrl()
    {
        return "https://content.zohoapis.in";
    }
}
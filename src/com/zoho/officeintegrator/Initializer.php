<?php
namespace com\zoho\officeintegrator;

use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\sdkconfigbuilder\SDKConfig;
use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\RequestProxy;
use com\zoho\officeintegrator\dc\Environment;
use com\zoho\api\authenticator\store\TokenStore;
use com\zoho\officeintegrator\logger\SDKLogger;

/**
 * This class to initialize Zoho SDK.
 */
class Initializer
{
    private static $initializer;
    private $environment = null;
    private $store = null;
    private $tokens = null;
    public static $jsonDetails = null;
    private $requestProxy = null;
    private $sdkConfig = null;

    public static function initialize($environment, $tokens, $store, $sdkConfig, $logger=null, $proxy=null)
    {
        try
        {
            SDKLogger::initialize($logger);
            try
            {
                if(is_null(self::$jsonDetails))
                {
                    self::$jsonDetails = json_decode(file_get_contents(__DIR__ . '/../../../../'. Constants::JSON_DETAILS_FILE_PATH), true);
                }
            }
            catch (\Exception $ex)
            {
                throw new SDKException(Constants::JSON_DETAILS_ERROR, null, null, $ex);
            }
            self::$initializer = new Initializer();
            $initializer = new Initializer();
            $initializer->environment = $environment;
            $initializer->sdkConfig = $sdkConfig;
            $initializer->requestProxy = $proxy;
            $initializer->store = $store;
            $initializer->tokens = $tokens;
            self::$initializer = $initializer;
            SDKLogger::info(Constants::INITIALIZATION_SUCCESSFUL . $initializer->toString());
        }
        catch(SDKException $e)
        {
            throw $e;
        }
        catch (\Exception $e)
        {
            throw new SDKException(Constants::INITIALIZATION_EXCEPTION, null, null, $e);
        }
    }

    /**
     * This method to switch the different user in SDK environment.
     * @param Environment $environment A Environment class instance containing the API base URL and Accounts URL.
     * @param $tokens A Token class instance containing the OAuth client application information.
     * @param SDKConfig $sdkConfig A SDKConfig class instance containing the SDK configuration.
     */
    public static function switchUser($environment, $tokens, $sdkConfig, $proxy=null)
    {
        $initializer = new Initializer();
        $initializer->environment = $environment;
        $initializer->store = self::$initializer->store;
        $initializer->sdkConfig = $sdkConfig;
        $initializer->requestProxy = $proxy;
        $initializer->tokens = $tokens;
        self::$initializer = $initializer;
        SDKLogger::info(Constants::INITIALIZATION_SWITCHED . $initializer->toString());
    }

    public static function getJSON($filePath)
    {
        return json_decode(file_get_contents($filePath),TRUE);
    }

    /**
     * This method to get Initializer class instance.
     *
     * @return Initializer A Initializer class instance representing the SDK configuration details.
     */
    public static function getInitializer()
    {
        return self::$initializer;
    }

    /**
     * This is a getter method to get API environment.
     *
     * @return Environment A Environment representing the API environment.
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * This is a getter method to get API environment.
     *
     * @return TokenStore A TokenStore class instance containing the token store information.
     */
    public function getStore()
    {
        return $this->store;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * This is a getter method to get RequestProxy.
     *
     * @return RequestProxy A RequestProxy class instance representing the proxy.
     */
    public function getRequestProxy()
    {
        return $this->requestProxy;
    }

    /**
     * This is a getter method to get SDK configuration.
     * @return SDKConfig A SDKConfig instance representing the configuration
     */
    public function getSDKConfig()
    {
        return $this->sdkConfig;
    }

    public function toString()
	{
		return Constants::IN_ENVIRONMENT . self::$initializer->getEnvironment()->getUrl() . ".";
	}
}
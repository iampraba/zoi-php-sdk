<?php
namespace com\zoho\officeintegrator;

/**
 * The Builder class to build SDKConfig
 */
class SDKConfigBuilder
{
    private $pickListValidation;
    private $enableSSLVerification;
    private $connectionTimeout;
    private $timeout;

    public function __Construct()
    {
        $this->pickListValidation = true;
        $this->enableSSLVerification = true;
        $this->connectionTimeout = 0;
        $this->timeout = 0;
    }

    /**
     * This is a setter method to set pickListValidation.
     * @param $pickListValidation
     */
    public function pickListValidation(bool $pickListValidation)
    {
        $this->pickListValidation = $pickListValidation;
        return $this;
    }

    /**
     * This is a setter method to set enableSSLVerification.
     * @param $enableSSLVerification
     */
    public function sslVerification(bool $enableSSLVerification)
    {
        $this->enableSSLVerification = $enableSSLVerification;
        return $this;
    }

    /**
     * This is a setter method to set connectionTimeout.
     * @param $connectionTimeout A int number of seconds to wait while trying to connect.
     */
    public function connectionTimeout(int $connectionTimeout)
    {
        $this->connectionTimeout = $connectionTimeout > 0 ? $connectionTimeout : 0;
        return $this;
    }

    /**
     * This is a setter method to set timeout.
     * @param $timeout A int maximum number of seconds to allow cURL functions to execute.
     */
    public function timeout(int $timeout)
    {
        $this->timeout = $timeout > 0 ? $timeout : 0;
        return $this;
    }

    // CURLOPT_CONNECTTIMEOUT is a segment of the time represented by CURLOPT_TIMEOUT, so the value of the CURLOPT_TIMEOUT should be greater than the value of the CURLOPT_CONNECTTIMEOUT.

    /**
     * The method to build the SDKConfig instance
     * @returns An instance of SDKConfig
     */
    public function build()
    {
        return new \com\zoho\officeintegrator\sdkconfigbuilder\SDKConfig($this->pickListValidation, $this->enableSSLVerification, $this->connectionTimeout, $this->timeout);
    }
}

namespace com\zoho\officeintegrator\sdkconfigbuilder;

/**
 * The class to configure the SDK.
 */
class SDKConfig
{
    private $pickListValidation;
    private $enableSSLVerification;
    private $connectionTimeout;
    private $timeout;

    public function __Construct(bool $pickListValidation, bool $enableSSLVerification, int $connectionTimeout, int $timeout)
    {
        $this->pickListValidation = $pickListValidation;
        $this->enableSSLVerification = $enableSSLVerification;
        $this->connectionTimeout = $connectionTimeout;
        $this->timeout = $timeout;
    }

    public function getPickListValidation()
    {
        return $this->pickListValidation;
    }

    public function isSSLVerificationEnabled()
    {
        return $this->enableSSLVerification;
    }

	public function connectionTimeout()
	{
		return $this->connectionTimeout;
	}

	public function timeout()
	{
		return $this->timeout;
	}
}
<?php
namespace com\zoho\officeintegrator;

use com\zoho\api\authenticator\OAuth2;
use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\util\Utility;
use com\zoho\api\authenticator\store\TokenStore;
use com\zoho\officeintegrator\sdkconfigbuilder\SDKConfig;
use com\zoho\officeintegrator\dc\Environment;
use com\zoho\officeintegrator\RequestProxy;
use com\zoho\api\authenticator\store\FileStore;
use com\zoho\officeintegrator\logger\Logger;
use com\zoho\officeintegrator\logger\LogBuilder;
use com\zoho\officeintegrator\logger\Levels;

class InitializeBuilder
{
    private $environment;
    private $store;
    private $tokens;
    private $requestProxy;
    private $sdkConfig;
    private $logger;
    private $errorMessage;
    private $initializer;

    function __construct()
    {
        $this->initializer = Initializer::getInitializer();
        $this->errorMessage = (Initializer::getInitializer() != null) ? Constants::SWITCH_USER_ERROR : Constants::INITIALIZATION_ERROR;
        if(Initializer::getInitializer() != null)
        {
            $previousInitializer = Initializer::getInitializer();
            $this->environment = $previousInitializer->getEnvironment();
            $this->tokens = $previousInitializer->getTokens();
            $this->sdkConfig = $previousInitializer->getSDKConfig();
        }
    }

    public function initialize()
    {
        Utility::assertNotNull($this->environment, $this->errorMessage, Constants::ENVIRONMENT_ERROR_MESSAGE);
        if(is_null($this->store))
        {
            $isCreate = false;
            foreach ($this->tokens as $tokenInstance)
            {
                if($tokenInstance instanceof OAuth2)
                {
                    $isCreate = true;
                    break;
                }
            }
            if($isCreate)
            {
                $this->store = new FileStore(getcwd() . DIRECTORY_SEPARATOR . Constants::TOKEN_FILE);
            }
        }
        if(is_null($this->sdkConfig))
        {
            $this->sdkConfig = (new SDKConfigBuilder())->build();
        }
        if(is_null($this->logger))
        {
            $this->logger = (new LogBuilder())->level(Levels::OFF)->filePath(null)->build();
        }
        Initializer::initialize($this->environment, $this->tokens, $this->store, $this->sdkConfig, $this->logger, $this->requestProxy);
    }

    public function switchUser()
    {
        Utility::assertNotNull(Initializer::getInitializer(), Constants::SDK_UNINITIALIZATION_ERROR, Constants::SDK_UNINITIALIZATION_MESSAGE);
        if(is_null($this->sdkConfig))
        {
            $this->sdkConfig = (new SDKConfigBuilder())->build();
        }
        Initializer::switchUser($this->environment, $this->tokens, $this->sdkConfig, $this->requestProxy);
    }

    public function logger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function tokens($tokens)
    {
        Utility::assertNotNull($tokens, $this->errorMessage, Constants::TOKEN_ERROR_MESSAGE);
        $this->tokens = $tokens;
        return $this;
    }

    public function SDKConfig(SDKConfig $sdkConfig)
    {
        $this->sdkConfig = $sdkConfig;
        return $this;
    }

    public function requestProxy(RequestProxy $requestProxy)
    {
        $this->requestProxy = $requestProxy;
        return $this;
    }

    public function store(TokenStore $store)
    {
        $this->store = $store;
        return $this;
    }

    public function environment(Environment $environment)
    {
        Utility::assertNotNull($environment, $this->errorMessage, Constants::ENVIRONMENT_ERROR_MESSAGE);
        $this->environment = $environment;
        return $this;
    }
}
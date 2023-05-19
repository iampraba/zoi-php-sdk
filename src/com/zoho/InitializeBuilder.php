<?php

namespace com\zoho;

use com\zoho\util\Constants;

use com\zoho\util\Utility;

use com\zoho\exception\SDKException;

use com\zoho\api\authenticator\Token;

use com\zoho\api\authenticator\store\TokenStore;

use com\zoho\UserSignature;

use com\zoho\sdkconfigbuilder\SDKConfig;

use com\zoho\dc\Environment;

use com\zoho\api\logger\LogBuilder;

use com\zoho\RequestProxy;

use com\zoho\api\logger\Levels;

use com\zoho\api\authenticator\store\FileStore;

use com\zoho\api\logger\Logger;

class InitializeBuilder
{
    private $environment;

    private $store;

    private $user;

    private $token;

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
            $this->user = Initializer::getInitializer()->getUser();

            $this->environment = Initializer::getInitializer()->getEnvironment();

            $this->token = Initializer::getInitializer()->getToken();

            $this->sdkConfig = Initializer::getInitializer()->getSDKConfig();
        }
    }

    public function initialize()
    {
        Utility::assertNotNull($this->user, $this->errorMessage, Constants::USER_SIGNATURE_ERROR_MESSAGE);

        Utility::assertNotNull($this->environment, $this->errorMessage, Constants::ENVIRONMENT_ERROR_MESSAGE);

        Utility::assertNotNull($this->token, $this->errorMessage, Constants::TOKEN_ERROR_MESSAGE);

        if(is_null($this->store))
        {
            $this->store = new FileStore(getcwd() . DIRECTORY_SEPARATOR . Constants::TOKEN_FILE);
        }

        if(is_null($this->sdkConfig))
        {
            $this->sdkConfig = (new SDKConfigBuilder())->build();
        }

        Initializer::initialize($this->user, $this->environment, $this->token, $this->store, $this->sdkConfig, $this->logger, $this->requestProxy);
    }

    public function switchUser()
    {
        Utility::assertNotNull(Initializer::getInitializer(), Constants::SDK_UNINITIALIZATION_ERROR, Constants::SDK_UNINITIALIZATION_MESSAGE);

        Initializer::switchUser($this->user, $this->environment, $this->token, $this->sdkConfig, $this->requestProxy);
    }

    public function logger(Logger $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function token(Token $token)
    {
        Utility::assertNotNull($token, $this->errorMessage, Constants::TOKEN_ERROR_MESSAGE);

        $this->token = $token;

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

    public function user(UserSignature $user)
    {
        Utility::assertNotNull($user, $this->errorMessage, Constants::USER_SIGNATURE_ERROR_MESSAGE);

        $this->user = $user;

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
?>
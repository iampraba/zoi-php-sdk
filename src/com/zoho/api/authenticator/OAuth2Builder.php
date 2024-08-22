<?php
namespace com\zoho\api\authenticator;

use com\zoho\officeintegrator\util\Utility;
use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\exception\SDKException;

class OAuth2Builder
{
    private $clientID;
    private $clientSecret;
    private $redirectURL;
    private $refreshToken;
    private $grantToken;
    private $accessToken;
    private $id;
    private $userSignature;
    private $authenticationSchema;

    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function clientId(string $clientID)
    {
        Utility::assertNotNull($clientID, Constants::TOKEN_ERROR, Constants::CLIENT_ID_NULL_ERROR_MESSAGE);
        $this->clientID = $clientID;
        return $this;
    }

    public function clientSecret(string $clientSecret)
    {
        Utility::assertNotNull($clientSecret, Constants::TOKEN_ERROR, Constants::CLIENT_SECRET_NULL_ERROR_MESSAGE);
        $this->clientSecret = $clientSecret;
        return $this;
    }

    public function redirectURL(string $redirectURL)
    {
        $this->redirectURL = $redirectURL;
        return $this;
    }

    public function refreshToken(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    public function grantToken(string $grantToken)
    {
        $this->grantToken = $grantToken;
        return $this;
    }

    public function accessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function userSignature($userSignature)
    {
        $this->userSignature = $userSignature;
        return $this;
    }

    public function authenticationSchema($authenticationSchema)
    {
        $this->authenticationSchema = $authenticationSchema;
        return $this;
    }

    public function build()
    {
        if($this->grantToken == null && $this->refreshToken == null && $this->id == null && $this->accessToken == null && $this->userSignature == null && $this->authenticationSchema == null)
		{
			throw new SDKException(Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR . " - " . join(", ", Constants::OAUTH_MANDATORY_KEYS));
		}
        if ($this->grantToken != null || $this->refreshToken != null)
        {
            if ($this->clientID == null && $this->clientSecret == null && $this->authenticationSchema)
            {
                throw new SDKException(Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR . " - " . join(", ", Constants::OAUTH_MANDATORY_KEYS1));
            }
            else if($this->accessToken != null && $this->authenticationSchema == null)
            {
                throw new SDKException(Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR + "-" .  join(", ", Constants::OAUTH_MANDATORY_KEYS_1));
            }
            else
            {
                Utility::assertNotNull($this->clientID, Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR . " - " . Constants::CLIENT_ID);
                Utility::assertNotNull($this->clientSecret, Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR . " - " . Constants::CLIENT_SECRET);
                Utility::assertNotNull($this->authenticationSchema, Constants::MANDATORY_VALUE_ERROR, Constants::MANDATORY_KEY_ERROR . " - " . Constants::AUTHENTICATION_SCHEMA);
            }
        }
        $class = new \ReflectionClass(OAuth2::class);
        $constructor = $class->getConstructor();
        $constructor->setAccessible(true);
        $object = $class->newInstanceWithoutConstructor();
        $constructor->invoke($object, $this->clientID, $this->clientSecret, $this->grantToken, $this->refreshToken, $this->redirectURL, $this->id, $this->accessToken, $this->userSignature, $this->authenticationSchema);
        return $object;
    }
}
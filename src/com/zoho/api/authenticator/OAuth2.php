<?php
namespace com\zoho\api\authenticator;

use com\zoho\officeintegrator\util\APIHTTPConnector;
use com\zoho\officeintegrator\Initializer;
use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\api\authenticator\Token;
use com\zoho\officeintegrator\logger\SDKLogger;
use Exception;
use ReflectionClass;

/**
 * This class gets the tokens and checks the expiry time.
 */
class OAuth2 implements Token
{
    private $clientID = null;
    private $clientSecret = null;
    private $redirectURL = null;
    private $grantToken = null;
    private $refreshToken = null;
    private $accessToken = null;
    private $expiresIn = null;
    private $userSignature = null;
    private $id = null;
    private $authenticationSchema;

    private function __construct($clientID, $clientSecret, $grantToken, $refreshToken, $redirectURL=null, $id=null, $accessToken=null, $userSignature=null, $authenticationSchema=null)
    {
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->grantToken = $grantToken;
        $this->refreshToken = $refreshToken;
        $this->redirectURL = $redirectURL;
        $this->accessToken = $accessToken;
        $this->id = $id;
        $this->userSignature = $userSignature;
		$this->authenticationSchema = $authenticationSchema;
    }

    /**
     * This is a getter method to get OAuth client id.
     * @return string A string representing the OAuth client id.
     */
    public function getClientId()
    {
        return $this->clientID;
    }

    /**
     * This is a getter method to get OAuth client secret.
     * @return string A string representing the OAuth client secret.
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * This is a getter method to get OAuth redirect URL.
     * @return string A string representing the OAuth redirect URL.
     */
    public function getRedirectURL()
    {
        return $this->redirectURL;
    }

    /**
     * This is a getter method to get grant token.
     * @return NULL|string A string representing the grant token.
     */
    public function getGrantToken()
    {
        return $this->grantToken;
    }

    /**
     * This is a getter method to get refresh token.
     * @return NULL|string|mixed A string representing the refresh token.
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * This is a setter method to set refresh token.
     * @param string $refreshToken A string containing the refresh token.
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * This is a getter method to set OAuth redirect URL.
     * @param string A string representing the OAuth redirect URL.
     */
    public function setRedirectURL($redirectURL)
    {
        $this->redirectURL = $redirectURL;
    }

    /**
     * This is a setter method to set OAuth client id.
     * @param string A string representing the OAuth client id.
     */
    public function setClientId($clientID)
    {
        $this->clientID = $clientID;
    }

    /**
     * This is a getter method to set OAuth client secret.
     * @param string A string representing the OAuth client secret.
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * This is a setter method to set grant token.
     * @param string A string representing the grant token.
     */
    public function setGrantToken($grantToken)
    {
        $this->grantToken = $grantToken;
    }

    /**
     * This is a getter method to get access token.
     * @return string A string representing the access token.
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * This is a setter method to set access token.
     * @param string $accessToken A string containing the access token.
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * This is a getter method to get token expire time.
     * @return string A string representing the token expire time.
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * This is a setter method to set token expire time.
     * @param string $expiresIn A string containing the token expire time.
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }

    public function getUserSignature()
    {
        return $this->userSignature;
    }

    public function setUserSignature($userSignature)
    {
        $this->userSignature = $userSignature;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAuthenticationSchema()
	{
		return $this->authenticationSchema;
	}

	public function setAuthenticationSchema(AuthenticationSchema $authenticationSchema)
	{
		$this->authenticationSchema = $authenticationSchema;
	}

    public function generateToken()
    {
        $this->getToken();
    }

    public function getToken()
    {
        try
        {
            $refreshUrl = $this->authenticationSchema->getRefreshUrl();
            $tokenUrl = $this->authenticationSchema->getTokenUrl();
            $initializer = Initializer::getInitializer();
            $store = $initializer->getStore();
            $oauthToken = null;
            if ($this->getId() != null)
            {
                $oauthToken = $store->findTokenById($this->getId());
                $this->mergeObjects($this, $oauthToken);
            }
            else
            {
                $oauthToken = $store->findToken($this);
            }
            if($oauthToken == null)
            {
                if ($this->getUserSignature() != null)
                {
                    $this->checkTokenDetails();
                }
                $oauthToken = $this;
            }
            if ($oauthToken->getAccessToken() == null)
            {
                if ($oauthToken->getRefreshToken() != null)
                {
                    SDKLogger::info(Constants::ACCESS_TOKEN_USING_REFRESH_TOKEN_MESSAGE);
                    $oauthToken->refreshAccessToken($oauthToken, $store, $refreshUrl);
                }
                else
                {
                    SDKLogger::info(Constants::ACCESS_TOKEN_USING_GRANT_TOKEN_MESSAGE);
                    $oauthToken->generateAccessToken($oauthToken, $store, $tokenUrl);
                }
            }
            else if ($oauthToken->getExpiresIn() != null && $this->isAccessTokenExpired($oauthToken->getExpiresIn())) //access token will expire in next 5 seconds or less
            {
                SDKLogger::info(Constants::REFRESH_TOKEN_MESSAGE);
                $oauthToken->refreshAccessToken($oauthToken, $store, $refreshUrl);
            }
            else if ($oauthToken->getExpiresIn() == null && $oauthToken->getAccessToken() != null && $oauthToken->getId() == null)
            {
                $store->saveToken($oauthToken);
            }
            return $oauthToken->getAccessToken();
        }
        catch(SDKException $ex)
        {
            throw $ex;
        }
        catch(Exception $ex)
        {
            throw new SDKException(null, null, null, $ex);
        }
    }

    public function checkTokenDetails()
    {
        if ($this->getGrantToken() == null && $this->getRefreshToken() == null)
        {
            throw new SDKException(Constants::MANDATORY_VALUE_ERROR, Constants::GET_TOKEN_BY_USER_NAME_ERROR . " - " . (join(", ", Constants::OAUTH_MANDATORY_KEYS2)));
        }
        return true;
    }

    public function mergeObjects($first, $second)
    {
        $reflection_class = new ReflectionClass(get_class($first));
        foreach ($reflection_class->getProperties() as $field) 
        {
            if (in_array($field->getName(), Constants::OAUTH_TOKEN_FIELDS))
            {
                $field->setAccessible(true);
                $value1= $field->getValue($first);
                $value2 = $field->getValue($second);
                $value = ($value1 != null ) ? $value1 : $value2;
                $field->setValue($first, $value);
            }
        }
    }

    public function authenticate(APIHTTPConnector $urlConnection, $config)
    {
        if($config != null)
        {
		    $tokenConfig = $config;
			if(array_key_exists(Constants::LOCATION, $tokenConfig) && array_key_exists(Constants::NAME, $tokenConfig))
			{
				if(strtolower($tokenConfig[Constants::LOCATION]) == strtolower(Constants::HEADER))
				{
					$urlConnection->addHeader($tokenConfig[Constants::NAME], Constants::OAUTH_HEADER_PREFIX . $this->getToken());
				}
				else if (strtolower($tokenConfig[Constants::LOCATION]) == strtolower(Constants::PARAM))
				{
					$urlConnection->addParam($tokenConfig[Constants::NAME], Constants::OAUTH_HEADER_PREFIX. $this->getToken());
				}
			}
        }
        else
        {
            $urlConnection->addHeader(Constants::AUTHORIZATION, Constants::OAUTH_HEADER_PREFIX . $this->getToken());
        }
    }

    public function getResponseFromServer($request_params, $url)
    {
        $curl_pointer = curl_init();
        curl_setopt($curl_pointer, CURLOPT_URL, $url);
        curl_setopt($curl_pointer, CURLOPT_HEADER, 1);
        curl_setopt($curl_pointer, CURLOPT_POSTFIELDS, $this->getUrlParamsAsString($request_params));
        curl_setopt($curl_pointer, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_pointer, CURLOPT_USERAGENT, Constants::USER_AGENT);
        curl_setopt($curl_pointer, CURLOPT_POST, count($request_params));
        curl_setopt($curl_pointer, CURLOPT_CUSTOMREQUEST, Constants::REQUEST_METHOD_POST);
        if(!Initializer::getInitializer()->getSDKConfig()->isSSLVerificationEnabled())
        {
            curl_setopt($curl_pointer, CURLOPT_SSL_VERIFYPEER, false);
        }
        $result = curl_exec($curl_pointer);
        curl_close($curl_pointer);
        SDKLogger::info($this->toString($url));
        return $result;
    }

    public function toString($url)
	{
		return "POST - " . Constants::URL . " = " . $url . "."; // No I18N
	}

    private function refreshAccessToken($oauthToken, $store, $url)
    {
        $requestParams = array();
        $requestParams[Constants::CLIENT_ID] =  $oauthToken->getClientId();
        $requestParams[Constants::CLIENT_SECRET] =  $oauthToken->getClientSecret();
        $requestParams[Constants::GRANT_TYPE] = Constants::REFRESH_TOKEN;
        $requestParams[Constants::REFRESH_TOKEN] =  $oauthToken->getRefreshToken();
        try
        {
            $this->processResponse($oauthToken, $this->getResponseFromServer($requestParams, $url));
            $store->saveToken($oauthToken);
        }
        catch(SDKException $ex)
        {
            throw $ex;
        }
        catch (\Exception $ex)
        {
            throw new SDKException(null, Constants::SAVE_TOKEN_ERROR, null, $ex);
        }
        return $this;
    }

    public function generateAccessToken($oauthToken, $store, $url)
    {
        $requestParams = array();
        $requestParams[Constants::CLIENT_ID] =  $oauthToken->getClientId();
        $requestParams[Constants::CLIENT_SECRET] =  $oauthToken->getClientSecret();
        if($oauthToken->getRedirectURL() != null)
        {
            $requestParams[Constants::REDIRECT_URI] =  $oauthToken->getRedirectURL();
        }
        $requestParams[Constants::GRANT_TYPE] = Constants::GRANT_TYPE_AUTH_CODE;
        $requestParams[Constants::CODE] = $oauthToken->getGrantToken();
        try
        {
            $this->processResponse($oauthToken, $this->getResponseFromServer($requestParams, $url));
            $store->saveToken($oauthToken);
        }
        catch(SDKException $ex)
        {
            throw $ex;
        }
        catch (Exception $ex)
        {
            throw new SDKException(null, Constants::SAVE_TOKEN_ERROR, null, $ex);
        }
    }

    public function processResponse($oauthToken, $response)
    {
        $headerRows = explode("\n",$response);
        $responseBody = end($headerRows);
        $jsonResponse = json_decode($responseBody, true);
        if (!array_key_exists(Constants::ACCESS_TOKEN, $jsonResponse))
        {
            throw new SDKException(Constants::INVALID_TOKEN_ERROR, array_key_exists(Constants::ERROR, $jsonResponse) ? $jsonResponse[Constants::ERROR] : Constants::NO_ACCESS_TOKEN_ERROR);
        }
        $oauthToken->setAccessToken($jsonResponse[Constants::ACCESS_TOKEN]);
        $oauthToken->setExpiresIn($this->getTokenExpiresIn($jsonResponse));
        if (array_key_exists(Constants::REFRESH_TOKEN, $jsonResponse))
        {
            $oauthToken->setRefreshToken($jsonResponse[Constants::REFRESH_TOKEN]);
        }
    }

    private function getTokenExpiresIn($response)
    {
        $expireIn = $response[Constants::EXPIRES_IN];
        if(!array_key_exists(Constants::EXPIRES_IN_SEC, $response))
        {
            $expireIn= $expireIn * 1000;
        }
        return $this->getCurrentTimeInMillis() + $expireIn;
    }

    public function getCurrentTimeInMillis()
    {
        return round(microtime(true) * 1000);
    }

    public function isAccessTokenExpired($expiry_time)
    {
        return ((((double)$expiry_time) - $this->getCurrentTimeInMillis()) < 5000);
    }

    public function getUrlParamsAsString($urlParams)
    {
        $paramsAsString = "";
        foreach ($urlParams as $key => $value)
        {
            $paramsAsString = $paramsAsString . $key . "=" . $value . "&";
        }
        $paramsAsString = rtrim($paramsAsString, "&");
        return str_replace(PHP_EOL, '', $paramsAsString);
    }

    public function remove()
    {
        try
        {
            if (Initializer::getInitializer() == null)
			{
				throw new SDKException(Constants::SDK_UNINITIALIZATION_ERROR, Constants::SDK_UNINITIALIZATION_MESSAGE);
			}
            $initializer = Initializer::getInitializer();
			$store = $initializer->getStore();
			$store->deleteToken($this->getId());
        }
        catch(SDKException $ex)
        {
            throw $ex;
        }
        catch (Exception $ex)
        {
            throw new SDKException(null, null, null, $ex);
        }
    }
}
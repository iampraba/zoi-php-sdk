<?php
namespace com\zoho\api\authenticator\store;

use com\zoho\api\authenticator\OAuth2;
use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\UserSignature;

/**
 * This class stores the user token details to the file.
 */
class FileStore implements TokenStore
{
    private $filePath = null;
    private $headers = array(Constants::ID, Constants::USER_MAIL, Constants::CLIENT_ID, Constants::CLIENT_SECRET, Constants::REFRESH_TOKEN, Constants::ACCESS_TOKEN, Constants::GRANT_TOKEN, Constants::EXPIRY_TIME, Constants::REDIRECT_URL);

    /**
     * Creates an FileStore class instance with the specified parameters.
     * @param string $filePath A string containing the absolute file path to store tokens.
     */
    public function __construct($filePath)
    {
        $this->filePath = trim($filePath);
        $csvWriter = fopen($this->filePath, 'a');//opens file in append mode
        if (trim(file_get_contents($this->filePath)) == false)
        {
            fwrite($csvWriter, implode(",", $this->headers));
        }
        fclose($csvWriter);
    }

    public function findToken($token)
    {
        if (!($token instanceof OAuth2))
        {
            return $token;
        }
        try
        {
            $csvReader = file($this->filePath, FILE_IGNORE_NEW_LINES);
            $oauthToken = $token;
            $isRowPresent = false;
            for($index = 1; $index < sizeof($csvReader); $index++)
            {
                $allContents = $csvReader[$index];
                $nextRecord = str_getcsv($allContents);
                if (sizeof($nextRecord) > 1)
                {
                    $isRowPresent = $this->checkCondition($oauthToken, $nextRecord);
                    if ($isRowPresent)
                    {
                        $this->setMergeData($oauthToken, $nextRecord);
                        return $oauthToken;
                    }
                }
            }
            if(!$isRowPresent)
            {
                return $token;
            }
        }
        catch (\Exception $ex)
        {
            throw new SDKException(Constants::TOKEN_STORE, Constants::GET_TOKEN_FILE_ERROR, null, $ex);
        }
        return $token;
    }

    public function saveToken($token)
    {
        if (!($token instanceof OAuth2))
        {
            return;
        }
        try 
        {
            $oauthToken = $token;
            $csvReader = file($this->filePath);
            $isRowPresent = false;
            for ($index = 1; $index < sizeof($csvReader); $index++)
            {
                $allContents = $csvReader[$index];
                $nextRecord = str_getcsv($allContents);
                if (sizeof($nextRecord) > 1) 
                {
                    if ($oauthToken->getId() != null) 
                    {
                        $id = $this->getData($nextRecord[0]);
                        if ($id != null && $oauthToken->getId() != null && $id == $oauthToken->getId()) 
                        {
                            $isRowPresent = true;
                        }
                    }
                    else
                    {
                        $isRowPresent = $this->checkCondition($oauthToken, $nextRecord);
                    }
                    if ($isRowPresent) 
                    {
                        $this->setMergeData($oauthToken, $nextRecord);
                        array_splice($csvReader, $index, 1, implode(",", $this->setToken($oauthToken)) . "\n");
                        break;
                    }
                } 
                else 
                {
                    unset($csvReader[$index]);
                }
            }
            if (!$isRowPresent) 
            {
                if ($oauthToken->getId() != null || $oauthToken->getUserSignature() != null) 
                {
                    if ($oauthToken->getRefreshToken() == null && $oauthToken->getGrantToken() == null && $oauthToken->getAccessToken() == null) 
                    {
                        throw new SDKException(Constants::TOKEN_STORE, Constants::GET_TOKEN_FILE_ERROR1);
                    }
                }
                if ($oauthToken->getId() == null) 
                {
                    $newID = $this->generateId($csvReader);
                    $oauthToken->setId($newID);
                }
                array_push($csvReader, "\n");
                array_push($csvReader, implode(",", $this->setToken($oauthToken)));
            }
            file_put_contents($this->filePath, $csvReader);
        }
        catch (SDKException $ex)
        {
            throw $ex;
        }
        catch (\Exception $ex)
        {
            throw new SDKException(Constants::TOKEN_STORE, Constants::SAVE_TOKEN_FILE_ERROR, null, $ex);
        }
        return $token;
    }

    public function deleteToken($id)
    {
        try 
        {
            $csvReader = file($this->filePath, FILE_IGNORE_NEW_LINES);
            $isRowPresent = false;
            for ($index = 1; $index < sizeof($csvReader); $index++) 
            {
                $nextRecord = $csvReader[$index];
                if (sizeof($nextRecord) > 1) 
                {
                    $recordId = $this->getData($nextRecord[0]);
                    if ($recordId != null && $recordId == $id) 
                    {
                        $isRowPresent = true;
                        unset($csvReader[$index]);
                    }
                }
            }
            if ($isRowPresent) 
            {
                file_put_contents($this->filePath, implode("\n", $csvReader));
            } 
            else 
            {
                throw new SDKException(Constants::TOKEN_STORE, Constants::GET_TOKEN_BY_ID_FILE_ERROR);
            }
        } 
        catch (SDKException $e) 
        {
            throw $e;
        } 
        catch (\Exception $ex)
        {
            throw new SDKException(Constants::TOKEN_STORE, Constants::DELETE_TOKEN_FILE_ERROR, $ex);
        }
    }

    public function getTokens()
    {
        $csvReader = null;
        $tokens = array();
        try
        {
            $csvReader = file($this->filePath, FILE_IGNORE_NEW_LINES);
            for ($index = 1; $index < sizeof($csvReader); $index++)
            {
                $allContents = $csvReader[$index];
                $nextRecord = str_getcsv($allContents);
                $class = new \ReflectionClass(OAuth2::class);
                $token = $class->newInstanceWithoutConstructor();
                $this->setMergeData($token, $nextRecord);
                array_push($tokens, $token);
            }
        }
        catch (\Exception $ex)
        {
            throw new SDKException(Constants::TOKEN_STORE, Constants::GET_TOKENS_FILE_ERROR, null, $ex);
        }
        return $tokens;
    }

    public function deleteTokens()
    {
        try
        {
            file_put_contents($this->filePath, implode(",", $this->headers));
        }
        catch(\Exception $ex)
        {
            throw new SDKException(Constants::TOKEN_STORE, Constants::DELETE_TOKENS_FILE_ERROR, null, $ex);
        }
    }

    public function findTokenById($id)
    {
        try 
        {
            $csvReader = file($this->filePath, FILE_IGNORE_NEW_LINES);
            $class = new \ReflectionClass(OAuth2::class);
            $oauthToken = $class->newInstanceWithoutConstructor();
            $isRowPresent = false;
            for ($index = 1; $index < sizeof($csvReader); $index++) 
            {
                $nextRecord = str_getcsv($csvReader[$index]);
                if ($nextRecord[0] == $id) 
                {
                    $isRowPresent = true;
                    $this->setMergeData($oauthToken, $nextRecord);
                    return $oauthToken;
                }
            }
            if (!$isRowPresent) 
            {
                throw new SDKException(Constants::TOKEN_STORE, Constants::GET_TOKEN_BY_ID_FILE_ERROR);
            }
        }
        catch (SDKException $ex)
        {
            throw $ex;
        }
        catch (\Exception $e)
        {
            throw new SDKException(Constants::TOKEN_STORE, Constants::GET_TOKEN_BY_ID_FILE_ERROR, $e);
        }
    }

    private function checkCondition(OAuth2 $oauthToken, array $nextRecord)
    {
        $isRowPresent = false;
        if ($oauthToken->getUserSignature() != null)
        {
            $name = $oauthToken->getUserSignature()->getName();
            $userName = $this->getData($nextRecord[1]);
            if ($name != null && strlen($name) > 0 && $userName != null && strlen($userName) > 0 && $name == $userName)
            {
                $isRowPresent = true;
            }
        }
        elseif ($oauthToken->getAccessToken() != null && $oauthToken->getClientId() == null && $oauthToken->getClientSecret() == null)
        {
            $accessToken = $this->getData($nextRecord[5]);
            if($accessToken != null && strlen($accessToken) > 0 && strlen($oauthToken->getAccessToken()) > 0 && $oauthToken->getAccessToken() == $accessToken)
            {
                $isRowPresent = true;
            }
        }
        elseif (($oauthToken->getRefreshToken() != null || $oauthToken->getGrantToken() != null) && $oauthToken->getClientId() != null && $oauthToken->getClientSecret() != null)
        {
            $grantToken = $this->getData($nextRecord[6]);
            $refreshToken = $this->getData($nextRecord[4]);
            if ($grantToken != null && strlen($grantToken) > 0 && $oauthToken->getGrantToken() != null && $oauthToken->getGrantToken() == $grantToken)
            {
                $isRowPresent = true;
            }
            elseif ($refreshToken != null && strlen($refreshToken) > 0 && $oauthToken->getRefreshToken() != null && $oauthToken->getRefreshToken() == $refreshToken)
            {
                $isRowPresent = true;
            }
        }
        return $isRowPresent;
    }

    private function getData(String $value)
    {
        return ($value != null && !empty($value) && strlen($value) > 0) ? $value : null;
    }

    /**
     * @throws SDKException
     */
    private function setMergeData(OAuth2 $oauthToken, array $nextRecord)
    {
        if ($oauthToken->getId() == null)
        {
            $oauthToken->setId( $this->getData($nextRecord[0]));
        }
        if ($oauthToken->getUserSignature() == null)
        {
            $name = $this->getData($nextRecord[1]);
			if ($name != null)
            {
                $oauthToken->setUserSignature(new UserSignature($name));
            }
		}
        if ($oauthToken->getClientId() == null)
        {
            $oauthToken->setClientId($this->getData($nextRecord[2]));
        }
        if ($oauthToken->getClientSecret() == null)
        {
            $oauthToken->setClientSecret($this->getData($nextRecord[3]));
        }
        if ($oauthToken->getRefreshToken() == null)
        {
            $oauthToken->setRefreshToken($this->getData($nextRecord[4]));
        }
        if ($oauthToken->getAccessToken() == null)
        {
            $oauthToken->setAccessToken($this->getData($nextRecord[5]));
        }
        if ($oauthToken->getGrantToken() == null)
        {
            $oauthToken->setGrantToken($this->getData($nextRecord[6]));
        }
        if ($oauthToken->getExpiresIn() == null)
        {
            $expiresIn = $this->getData($nextRecord[7]);
			if ($expiresIn != null)
            {
                $oauthToken->setExpiresIn(StrVal($expiresIn));
            }
		}
        if ($oauthToken->getRedirectURL() == null)
        {
            $oauthToken->setRedirectURL($this->getData($nextRecord[8]));
        }
    }

    private function setToken(OAuth2 $oauthToken)
    {
        $data = array();
        $data[0] = $oauthToken->getId();
        $data[1] = $oauthToken->getUserSignature() != null ? $oauthToken->getUserSignature()->getName() : null;
        $data[2] = $oauthToken->getClientId();
        $data[3] = $oauthToken->getClientSecret();
        $data[4] = $oauthToken->getRefreshToken();
        $data[5] = $oauthToken->getAccessToken();
        $data[6] = $oauthToken->getGrantToken();
        $data[7] = $oauthToken->getExpiresIn();
        $data[8] = $oauthToken->getRedirectURL();
        return $data;

    }

    private function generateId($allContents)
    {
        $maxValue = 0;
        if (sizeof($allContents) > 1)
        {
            for ($index =1; $index < sizeof($allContents); $index++)
            {
                $nextRecord = $allContents[$index];
                if(strlen($nextRecord) > 1 && $nextRecord[0] != null && strlen($nextRecord[0]))
                {
                    if ($maxValue < intval($nextRecord[0]))
                    {
                        $maxValue = intval($nextRecord[0]);
                    }
                }
            }
        }
        return strval($maxValue + 1);
    }
}
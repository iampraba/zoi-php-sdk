<?php

namespace com\zoho\api\authenticator;

use com\zoho\exception\SDKException;
use com\zoho\util\APIHTTPConnector;
use com\zoho\util\Constants;
use Exception;

/**
 * Summary of APIKey
 */
class APIKey implements Token {

    private $apikey = null;

	private $authorizeType = null;

	public function __construct($apikey, $authorizeType) {
        $this->apikey = $apikey;
		$this->authorizeType = $authorizeType;
    }

	public function getApikey() {
		return $this->apikey;
	}

	public function setApikey(string $apikey) {
		$this->$apikey = $apikey;
	}

	public function authenticate(APIHTTPConnector $urlConnection) {
		try {
            if ( $this->authorizeType == Constants::PARAMS ) {
                $urlConnection->addParam("apikey", $this->getApikey());
            } else if ( $this->authorizeType == Constants::HEADERS ) {
                $urlConnection->addHeader("X-API-Key", $this->getApikey());
            } else {
                throw new SDKException(Constants::TOKEN_ERROR, "Set authorise type to add apikey in parameter or header.", null, null);
            }
        } catch (Exception $e)
        {
            throw new SDKException(Constants::INITIALIZATION_EXCEPTION, null, null, $e);
        }
	}

	public function remove() {
		return null;
	}

}
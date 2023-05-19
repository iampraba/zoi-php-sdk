<?php
namespace com\zoho;

use com\zoho\util\Constants;

use com\zoho\exception\SDKException;

/**
 * This class represents the user email.
 */
class UserSignature
{
    private $email = null;

    /**
     * Creates an UserSignature class instance with the specified user email.
     * @param string $email A string containing the user email.
     */
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $error = array();

            $error[Constants::FIELD] =  Constants::EMAIL;

            $error[Constants::EXPECTED_TYPE] = Constants::EMAIL;

            throw new SDKException(Constants::USER_SIGNATURE_ERROR, null, $error, null);
        }

        $this->email = $email;
    }

    /**
     * This is a getter method to get user email.
     * @return string A string representing the user email.
     */
    public function getEmail()
    {
        return $this->email;
    }
}
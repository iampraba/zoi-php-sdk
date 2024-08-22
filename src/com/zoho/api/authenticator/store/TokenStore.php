<?php
namespace com\zoho\api\authenticator\store;

use com\zoho\api\authenticator\Token;

/**
 * This interface stores the user token details.
 */
interface TokenStore
{
    public function findToken(Token $token);

    public function findTokenById($id);
    
    public function saveToken(Token $token);
    
    public function deleteToken($id);
    
    public function getTokens();
    
    public function deleteTokens();
}
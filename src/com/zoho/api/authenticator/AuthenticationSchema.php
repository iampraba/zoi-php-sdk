<?php
namespace com\zoho\api\authenticator;

abstract class AuthenticationSchema
{
    public abstract function getAuthenticationType();
    public abstract function getTokenUrl();
    public abstract function getRefreshUrl();
    public abstract function getSchema();
}

<?php
namespace com\zoho\api\authenticator;

class AuthenticationType 
{
	private $name;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		$this->name;
	}

	public static function parse($location) 
	{
		switch (strtolower($location)) 
		{
			case "oauth2" || "token":
				return new AuthenticationType($location);
			default:
				throw new \InvalidArgumentException("Given class is not a enum");
		}
    }

	public static function OAUTH2()
	{
		return new AuthenticationType("oauth2");
	}

	public static function TOKEN()
	{
		return new AuthenticationType("token");
	}
}
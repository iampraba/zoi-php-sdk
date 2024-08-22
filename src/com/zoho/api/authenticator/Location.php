<?php
namespace com\zoho\api\authenticator;

class Location 
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
			case "header" || "param" || "variable":
				return new Location($location);
			default:
				throw new \InvalidArgumentException("Given class is not a enum");
		}
    }

	public static function HEADER()
	{
		return new Location("header");
	}

	public static function PARAM()
	{
		return new Location("param");
	}

	public static function VARIABLE()
	{
		return new Location("variable");
	}
}
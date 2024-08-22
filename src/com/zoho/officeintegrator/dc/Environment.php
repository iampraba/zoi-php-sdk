<?php
namespace com\zoho\officeintegrator\dc;

abstract class Environment
{
    public abstract function getUrl();
	
	public abstract function getDc();
	
	public abstract function getLocation();
	
	public abstract function getName();
	
	public abstract function getValue();
}

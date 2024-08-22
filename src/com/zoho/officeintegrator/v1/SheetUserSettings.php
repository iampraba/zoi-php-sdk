<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class SheetUserSettings implements Model
{

	private  $displayName;
	private  $keyModified=array();

	/**
	 * The method to get the displayName
	 * @return string | null A string representing the displayName
	 */
	public  function getDisplayName()
	{
		return $this->displayName; 

	}

	/**
	 * The method to set the value to displayName
	 * @param string $displayName A string
	 */
	public  function setDisplayName(string $displayName)
	{
		$this->displayName=$displayName; 
		$this->keyModified['display_name'] = 1; 

	}

	/**
	 * The method to check if the user has modified the given key
	 * @param string $key A string
	 * @return int | null A int representing the modification
	 */
	public  function isKeyModified(string $key)
	{
		if(((array_key_exists($key, $this->keyModified))))
		{
			return $this->keyModified[$key]; 

		}
		return null; 

	}

	/**
	 * The method to mark the given key as modified
	 * @param string $key A string
	 * @param int $modification A int
	 */
	public  function setKeyModified(string $key, int $modification)
	{
		$this->keyModified[$key] = $modification; 

	}
} 

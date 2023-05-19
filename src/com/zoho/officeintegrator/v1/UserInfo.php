<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class UserInfo implements Model
{

	private  $userId;
	private  $displayName;
	private  $keyModified=array();

	/**
	 * The method to get the userId
	 * @return string A string representing the userId
	 */
	public  function getUserId()
	{
		return $this->userId; 

	}

	/**
	 * The method to set the value to userId
	 * @param string $userId A string
	 */
	public  function setUserId(string $userId)
	{
		$this->userId=$userId; 
		$this->keyModified['user_id'] = 1; 

	}

	/**
	 * The method to get the displayName
	 * @return string A string representing the displayName
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
	 * @return int A int representing the modification
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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class SessionDeleteSuccessResponse implements Model, SheetResponseHandler, ShowResponseHandler
{

	private  $sessionDelete;
	private  $keyModified=array();

	/**
	 * The method to get the sessionDelete
	 * @return string | null A string representing the sessionDelete
	 */
	public  function getSessionDelete()
	{
		return $this->sessionDelete; 

	}

	/**
	 * The method to set the value to sessionDelete
	 * @param string $sessionDelete A string
	 */
	public  function setSessionDelete(string $sessionDelete)
	{
		$this->sessionDelete=$sessionDelete; 
		$this->keyModified['session_delete'] = 1; 

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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class DocumentSessionDeleteSuccessResponse implements Model, WriterResponseHandler
{

	private  $sessionDeleted;
	private  $keyModified=array();

	/**
	 * The method to get the sessionDeleted
	 * @return bool A bool representing the sessionDeleted
	 */
	public  function getSessionDeleted()
	{
		return $this->sessionDeleted; 

	}

	/**
	 * The method to set the value to sessionDeleted
	 * @param bool $sessionDeleted A bool
	 */
	public  function setSessionDeleted(bool $sessionDeleted)
	{
		$this->sessionDeleted=$sessionDeleted; 
		$this->keyModified['session_deleted'] = 1; 

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

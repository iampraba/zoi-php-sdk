<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class CompareDocumentResponse implements Model, WriterResponseHandler
{

	private  $compareUrl;
	private  $sessionDeleteUrl;
	private  $keyModified=array();

	/**
	 * The method to get the compareUrl
	 * @return string A string representing the compareUrl
	 */
	public  function getCompareUrl()
	{
		return $this->compareUrl; 

	}

	/**
	 * The method to set the value to compareUrl
	 * @param string $compareUrl A string
	 */
	public  function setCompareUrl(string $compareUrl)
	{
		$this->compareUrl=$compareUrl; 
		$this->keyModified['compare_url'] = 1; 

	}

	/**
	 * The method to get the sessionDeleteUrl
	 * @return string A string representing the sessionDeleteUrl
	 */
	public  function getSessionDeleteUrl()
	{
		return $this->sessionDeleteUrl; 

	}

	/**
	 * The method to set the value to sessionDeleteUrl
	 * @param string $sessionDeleteUrl A string
	 */
	public  function setSessionDeleteUrl(string $sessionDeleteUrl)
	{
		$this->sessionDeleteUrl=$sessionDeleteUrl; 
		$this->keyModified['session_delete_url'] = 1; 

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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class SessionInfo implements Model
{

	private  $documentId;
	private  $createdTimeMs;
	private  $createdTime;
	private  $expiresOnMs;
	private  $expiresOn;
	private  $sessionUrl;
	private  $sessionDeleteUrl;
	private  $keyModified=array();

	/**
	 * The method to get the documentId
	 * @return string | null A string representing the documentId
	 */
	public  function getDocumentId()
	{
		return $this->documentId; 

	}

	/**
	 * The method to set the value to documentId
	 * @param string $documentId A string
	 */
	public  function setDocumentId(string $documentId)
	{
		$this->documentId=$documentId; 
		$this->keyModified['document_id'] = 1; 

	}

	/**
	 * The method to get the createdTimeMs
	 * @return string | null A string representing the createdTimeMs
	 */
	public  function getCreatedTimeMs()
	{
		return $this->createdTimeMs; 

	}

	/**
	 * The method to set the value to createdTimeMs
	 * @param string $createdTimeMs A string
	 */
	public  function setCreatedTimeMs(string $createdTimeMs)
	{
		$this->createdTimeMs=$createdTimeMs; 
		$this->keyModified['created_time_ms'] = 1; 

	}

	/**
	 * The method to get the createdTime
	 * @return string | null A string representing the createdTime
	 */
	public  function getCreatedTime()
	{
		return $this->createdTime; 

	}

	/**
	 * The method to set the value to createdTime
	 * @param string $createdTime A string
	 */
	public  function setCreatedTime(string $createdTime)
	{
		$this->createdTime=$createdTime; 
		$this->keyModified['created_time'] = 1; 

	}

	/**
	 * The method to get the expiresOnMs
	 * @return string | null A string representing the expiresOnMs
	 */
	public  function getExpiresOnMs()
	{
		return $this->expiresOnMs; 

	}

	/**
	 * The method to set the value to expiresOnMs
	 * @param string $expiresOnMs A string
	 */
	public  function setExpiresOnMs(string $expiresOnMs)
	{
		$this->expiresOnMs=$expiresOnMs; 
		$this->keyModified['expires_on_ms'] = 1; 

	}

	/**
	 * The method to get the expiresOn
	 * @return string | null A string representing the expiresOn
	 */
	public  function getExpiresOn()
	{
		return $this->expiresOn; 

	}

	/**
	 * The method to set the value to expiresOn
	 * @param string $expiresOn A string
	 */
	public  function setExpiresOn(string $expiresOn)
	{
		$this->expiresOn=$expiresOn; 
		$this->keyModified['expires_on'] = 1; 

	}

	/**
	 * The method to get the sessionUrl
	 * @return string | null A string representing the sessionUrl
	 */
	public  function getSessionUrl()
	{
		return $this->sessionUrl; 

	}

	/**
	 * The method to set the value to sessionUrl
	 * @param string $sessionUrl A string
	 */
	public  function setSessionUrl(string $sessionUrl)
	{
		$this->sessionUrl=$sessionUrl; 
		$this->keyModified['session_url'] = 1; 

	}

	/**
	 * The method to get the sessionDeleteUrl
	 * @return string | null A string representing the sessionDeleteUrl
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

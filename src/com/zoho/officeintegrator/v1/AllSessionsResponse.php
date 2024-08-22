<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class AllSessionsResponse implements Model, WriterResponseHandler
{

	private  $documentId;
	private  $collaboratorsCount;
	private  $activeSessionsCount;
	private  $documentName;
	private  $documentType;
	private  $createdTime;
	private  $createdTimeMs;
	private  $expiresOn;
	private  $expiresOnMs;
	private  $sessions;
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
	 * The method to get the collaboratorsCount
	 * @return int | null A int representing the collaboratorsCount
	 */
	public  function getCollaboratorsCount()
	{
		return $this->collaboratorsCount; 

	}

	/**
	 * The method to set the value to collaboratorsCount
	 * @param int $collaboratorsCount A int
	 */
	public  function setCollaboratorsCount(int $collaboratorsCount)
	{
		$this->collaboratorsCount=$collaboratorsCount; 
		$this->keyModified['collaborators_count'] = 1; 

	}

	/**
	 * The method to get the activeSessionsCount
	 * @return int | null A int representing the activeSessionsCount
	 */
	public  function getActiveSessionsCount()
	{
		return $this->activeSessionsCount; 

	}

	/**
	 * The method to set the value to activeSessionsCount
	 * @param int $activeSessionsCount A int
	 */
	public  function setActiveSessionsCount(int $activeSessionsCount)
	{
		$this->activeSessionsCount=$activeSessionsCount; 
		$this->keyModified['active_sessions_count'] = 1; 

	}

	/**
	 * The method to get the documentName
	 * @return string | null A string representing the documentName
	 */
	public  function getDocumentName()
	{
		return $this->documentName; 

	}

	/**
	 * The method to set the value to documentName
	 * @param string $documentName A string
	 */
	public  function setDocumentName(string $documentName)
	{
		$this->documentName=$documentName; 
		$this->keyModified['document_name'] = 1; 

	}

	/**
	 * The method to get the documentType
	 * @return string | null A string representing the documentType
	 */
	public  function getDocumentType()
	{
		return $this->documentType; 

	}

	/**
	 * The method to set the value to documentType
	 * @param string $documentType A string
	 */
	public  function setDocumentType(string $documentType)
	{
		$this->documentType=$documentType; 
		$this->keyModified['document_type'] = 1; 

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
	 * The method to get the sessions
	 * @return array | null A array representing the sessions
	 */
	public  function getSessions()
	{
		return $this->sessions; 

	}

	/**
	 * The method to set the value to sessions
	 * @param array $sessions A array
	 */
	public  function setSessions(array $sessions)
	{
		$this->sessions=$sessions; 
		$this->keyModified['sessions'] = 1; 

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

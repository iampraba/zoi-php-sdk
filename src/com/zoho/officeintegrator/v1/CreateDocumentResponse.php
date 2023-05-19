<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class CreateDocumentResponse implements Model, WriterResponseHandler, ShowResponseHandler
{

	private  $documentUrl;
	private  $documentId;
	private  $saveUrl;
	private  $sessionId;
	private  $sessionDeleteUrl;
	private  $documentDeleteUrl;
	private  $keyModified=array();

	/**
	 * The method to get the documentUrl
	 * @return string A string representing the documentUrl
	 */
	public  function getDocumentUrl()
	{
		return $this->documentUrl; 

	}

	/**
	 * The method to set the value to documentUrl
	 * @param string $documentUrl A string
	 */
	public  function setDocumentUrl(string $documentUrl)
	{
		$this->documentUrl=$documentUrl; 
		$this->keyModified['document_url'] = 1; 

	}

	/**
	 * The method to get the documentId
	 * @return string A string representing the documentId
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
	 * The method to get the saveUrl
	 * @return string A string representing the saveUrl
	 */
	public  function getSaveUrl()
	{
		return $this->saveUrl; 

	}

	/**
	 * The method to set the value to saveUrl
	 * @param string $saveUrl A string
	 */
	public  function setSaveUrl(string $saveUrl)
	{
		$this->saveUrl=$saveUrl; 
		$this->keyModified['save_url'] = 1; 

	}

	/**
	 * The method to get the sessionId
	 * @return string A string representing the sessionId
	 */
	public  function getSessionId()
	{
		return $this->sessionId; 

	}

	/**
	 * The method to set the value to sessionId
	 * @param string $sessionId A string
	 */
	public  function setSessionId(string $sessionId)
	{
		$this->sessionId=$sessionId; 
		$this->keyModified['session_id'] = 1; 

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
	 * The method to get the documentDeleteUrl
	 * @return string A string representing the documentDeleteUrl
	 */
	public  function getDocumentDeleteUrl()
	{
		return $this->documentDeleteUrl; 

	}

	/**
	 * The method to set the value to documentDeleteUrl
	 * @param string $documentDeleteUrl A string
	 */
	public  function setDocumentDeleteUrl(string $documentDeleteUrl)
	{
		$this->documentDeleteUrl=$documentDeleteUrl; 
		$this->keyModified['document_delete_url'] = 1; 

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

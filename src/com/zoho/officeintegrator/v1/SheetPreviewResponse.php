<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class SheetPreviewResponse implements Model, SheetResponseHandler
{

	private  $gridviewUrl;
	private  $previewUrl;
	private  $documentId;
	private  $sessionId;
	private  $sessionDeleteUrl;
	private  $documentDeleteUrl;
	private  $keyModified=array();

	/**
	 * The method to get the gridviewUrl
	 * @return string | null A string representing the gridviewUrl
	 */
	public  function getGridviewUrl()
	{
		return $this->gridviewUrl; 

	}

	/**
	 * The method to set the value to gridviewUrl
	 * @param string $gridviewUrl A string
	 */
	public  function setGridviewUrl(string $gridviewUrl)
	{
		$this->gridviewUrl=$gridviewUrl; 
		$this->keyModified['gridview_url'] = 1; 

	}

	/**
	 * The method to get the previewUrl
	 * @return string | null A string representing the previewUrl
	 */
	public  function getPreviewUrl()
	{
		return $this->previewUrl; 

	}

	/**
	 * The method to set the value to previewUrl
	 * @param string $previewUrl A string
	 */
	public  function setPreviewUrl(string $previewUrl)
	{
		$this->previewUrl=$previewUrl; 
		$this->keyModified['preview_url'] = 1; 

	}

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
	 * The method to get the sessionId
	 * @return string | null A string representing the sessionId
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
	 * The method to get the documentDeleteUrl
	 * @return string | null A string representing the documentDeleteUrl
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

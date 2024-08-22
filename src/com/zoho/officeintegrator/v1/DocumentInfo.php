<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class DocumentInfo implements Model
{

	private  $documentName;
	private  $documentId;
	private  $keyModified=array();

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

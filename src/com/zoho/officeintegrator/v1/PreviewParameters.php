<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\StreamWrapper;
use com\zoho\util\Model;

class PreviewParameters implements Model
{

	private  $url;
	private  $document;
	private  $documentInfo;
	private  $permissions;
	private  $keyModified=array();

	/**
	 * The method to get the url
	 * @return string A string representing the url
	 */
	public  function getUrl()
	{
		return $this->url; 

	}

	/**
	 * The method to set the value to url
	 * @param string $url A string
	 */
	public  function setUrl(string $url)
	{
		$this->url=$url; 
		$this->keyModified['url'] = 1; 

	}

	/**
	 * The method to get the document
	 * @return StreamWrapper An instance of StreamWrapper
	 */
	public  function getDocument()
	{
		return $this->document; 

	}

	/**
	 * The method to set the value to document
	 * @param StreamWrapper $document An instance of StreamWrapper
	 */
	public  function setDocument(StreamWrapper $document)
	{
		$this->document=$document; 
		$this->keyModified['document'] = 1; 

	}

	/**
	 * The method to get the documentInfo
	 * @return PreviewDocumentInfo An instance of PreviewDocumentInfo
	 */
	public  function getDocumentInfo()
	{
		return $this->documentInfo; 

	}

	/**
	 * The method to set the value to documentInfo
	 * @param PreviewDocumentInfo $documentInfo An instance of PreviewDocumentInfo
	 */
	public  function setDocumentInfo(PreviewDocumentInfo $documentInfo)
	{
		$this->documentInfo=$documentInfo; 
		$this->keyModified['document_info'] = 1; 

	}

	/**
	 * The method to get the permissions
	 * @return array A array representing the permissions
	 */
	public  function getPermissions()
	{
		return $this->permissions; 

	}

	/**
	 * The method to set the value to permissions
	 * @param array $permissions A array
	 */
	public  function setPermissions(array $permissions)
	{
		$this->permissions=$permissions; 
		$this->keyModified['permissions'] = 1; 

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

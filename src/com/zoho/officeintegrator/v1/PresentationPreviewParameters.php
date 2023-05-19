<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\StreamWrapper;
use com\zoho\util\Model;

class PresentationPreviewParameters implements Model
{

	private  $url;
	private  $document;
	private  $language;
	private  $documentInfo;
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
	 * The method to get the language
	 * @return string A string representing the language
	 */
	public  function getLanguage()
	{
		return $this->language; 

	}

	/**
	 * The method to set the value to language
	 * @param string $language A string
	 */
	public  function setLanguage(string $language)
	{
		$this->language=$language; 
		$this->keyModified['language'] = 1; 

	}

	/**
	 * The method to get the documentInfo
	 * @return DocumentInfo An instance of DocumentInfo
	 */
	public  function getDocumentInfo()
	{
		return $this->documentInfo; 

	}

	/**
	 * The method to set the value to documentInfo
	 * @param DocumentInfo $documentInfo An instance of DocumentInfo
	 */
	public  function setDocumentInfo(DocumentInfo $documentInfo)
	{
		$this->documentInfo=$documentInfo; 
		$this->keyModified['document_info'] = 1; 

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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class DocumentConversionOutputOptions implements Model
{

	private  $format;
	private  $documentName;
	private  $password;
	private  $includeChanges;
	private  $includeComments;
	private  $keyModified=array();

	/**
	 * The method to get the format
	 * @return string | null A string representing the format
	 */
	public  function getFormat()
	{
		return $this->format; 

	}

	/**
	 * The method to set the value to format
	 * @param string $format A string
	 */
	public  function setFormat(string $format)
	{
		$this->format=$format; 
		$this->keyModified['format'] = 1; 

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
	 * The method to get the password
	 * @return string | null A string representing the password
	 */
	public  function getPassword()
	{
		return $this->password; 

	}

	/**
	 * The method to set the value to password
	 * @param string $password A string
	 */
	public  function setPassword(string $password)
	{
		$this->password=$password; 
		$this->keyModified['password'] = 1; 

	}

	/**
	 * The method to get the includeChanges
	 * @return string | null A string representing the includeChanges
	 */
	public  function getIncludeChanges()
	{
		return $this->includeChanges; 

	}

	/**
	 * The method to set the value to includeChanges
	 * @param string $includeChanges A string
	 */
	public  function setIncludeChanges(string $includeChanges)
	{
		$this->includeChanges=$includeChanges; 
		$this->keyModified['include_changes'] = 1; 

	}

	/**
	 * The method to get the includeComments
	 * @return string | null A string representing the includeComments
	 */
	public  function getIncludeComments()
	{
		return $this->includeComments; 

	}

	/**
	 * The method to set the value to includeComments
	 * @param string $includeComments A string
	 */
	public  function setIncludeComments(string $includeComments)
	{
		$this->includeComments=$includeComments; 
		$this->keyModified['include_comments'] = 1; 

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

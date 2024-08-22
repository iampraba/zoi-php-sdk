<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\StreamWrapper;
use com\zoho\officeintegrator\util\Model;

class DocumentConversionParameters implements Model
{

	private  $document;
	private  $url;
	private  $password;
	private  $outputOptions;
	private  $keyModified=array();

	/**
	 * The method to get the document
	 * @return StreamWrapper | null An instance of StreamWrapper
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
	 * The method to get the url
	 * @return string | null A string representing the url
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
	 * The method to get the outputOptions
	 * @return DocumentConversionOutputOptions | null An instance of DocumentConversionOutputOptions
	 */
	public  function getOutputOptions()
	{
		return $this->outputOptions; 

	}

	/**
	 * The method to set the value to outputOptions
	 * @param DocumentConversionOutputOptions $outputOptions An instance of DocumentConversionOutputOptions
	 */
	public  function setOutputOptions(DocumentConversionOutputOptions $outputOptions)
	{
		$this->outputOptions=$outputOptions; 
		$this->keyModified['output_options'] = 1; 

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

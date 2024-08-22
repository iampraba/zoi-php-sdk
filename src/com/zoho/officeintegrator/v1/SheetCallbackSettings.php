<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class SheetCallbackSettings implements Model
{

	private  $saveFormat;
	private  $saveUrl;
	private  $saveUrlParams;
	private  $saveUrlHeaders;
	private  $keyModified=array();

	/**
	 * The method to get the saveFormat
	 * @return string | null A string representing the saveFormat
	 */
	public  function getSaveFormat()
	{
		return $this->saveFormat; 

	}

	/**
	 * The method to set the value to saveFormat
	 * @param string $saveFormat A string
	 */
	public  function setSaveFormat(string $saveFormat)
	{
		$this->saveFormat=$saveFormat; 
		$this->keyModified['save_format'] = 1; 

	}

	/**
	 * The method to get the saveUrl
	 * @return string | null A string representing the saveUrl
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
	 * The method to get the saveUrlParams
	 * @return array | null A array representing the saveUrlParams
	 */
	public  function getSaveUrlParams()
	{
		return $this->saveUrlParams; 

	}

	/**
	 * The method to set the value to saveUrlParams
	 * @param array $saveUrlParams A array
	 */
	public  function setSaveUrlParams(array $saveUrlParams)
	{
		$this->saveUrlParams=$saveUrlParams; 
		$this->keyModified['save_url_params'] = 1; 

	}

	/**
	 * The method to get the saveUrlHeaders
	 * @return array | null A array representing the saveUrlHeaders
	 */
	public  function getSaveUrlHeaders()
	{
		return $this->saveUrlHeaders; 

	}

	/**
	 * The method to set the value to saveUrlHeaders
	 * @param array $saveUrlHeaders A array
	 */
	public  function setSaveUrlHeaders(array $saveUrlHeaders)
	{
		$this->saveUrlHeaders=$saveUrlHeaders; 
		$this->keyModified['save_url_headers'] = 1; 

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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class ZohoShowEditorSettings implements Model
{

	private  $language;
	private  $keyModified=array();

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

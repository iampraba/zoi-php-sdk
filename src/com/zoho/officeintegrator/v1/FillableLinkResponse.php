<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class FillableLinkResponse implements Model, WriterResponseHandler
{

	private  $fillableFormUrl;
	private  $keyModified=array();

	/**
	 * The method to get the fillableFormUrl
	 * @return string A string representing the fillableFormUrl
	 */
	public  function getFillableFormUrl()
	{
		return $this->fillableFormUrl; 

	}

	/**
	 * The method to set the value to fillableFormUrl
	 * @param string $fillableFormUrl A string
	 */
	public  function setFillableFormUrl(string $fillableFormUrl)
	{
		$this->fillableFormUrl=$fillableFormUrl; 
		$this->keyModified['fillable_form_url'] = 1; 

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

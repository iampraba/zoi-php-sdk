<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class FillableLinkOutputSettings implements Model
{

	private  $format;
	private  $keyModified=array();

	/**
	 * The method to get the format
	 * @return string A string representing the format
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

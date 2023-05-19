<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class FillableFormOptions implements Model
{

	private  $download;
	private  $print;
	private  $submit;
	private  $keyModified=array();

	/**
	 * The method to get the download
	 * @return bool A bool representing the download
	 */
	public  function getDownload()
	{
		return $this->download; 

	}

	/**
	 * The method to set the value to download
	 * @param bool $download A bool
	 */
	public  function setDownload(bool $download)
	{
		$this->download=$download; 
		$this->keyModified['download'] = 1; 

	}

	/**
	 * The method to get the print
	 * @return bool A bool representing the print
	 */
	public  function getPrint()
	{
		return $this->print; 

	}

	/**
	 * The method to set the value to print
	 * @param bool $print A bool
	 */
	public  function setPrint(bool $print)
	{
		$this->print=$print; 
		$this->keyModified['print'] = 1; 

	}

	/**
	 * The method to get the submit
	 * @return bool A bool representing the submit
	 */
	public  function getSubmit()
	{
		return $this->submit; 

	}

	/**
	 * The method to set the value to submit
	 * @param bool $submit A bool
	 */
	public  function setSubmit(bool $submit)
	{
		$this->submit=$submit; 
		$this->keyModified['submit'] = 1; 

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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\StreamWrapper;
use com\zoho\officeintegrator\util\Model;

class FileBodyWrapper implements Model, WriterResponseHandler, SheetResponseHandler, ShowResponseHandler
{

	private  $file;
	private  $keyModified=array();

	/**
	 * The method to get the file
	 * @return StreamWrapper | null An instance of StreamWrapper
	 */
	public  function getFile()
	{
		return $this->file; 

	}

	/**
	 * The method to set the value to file
	 * @param StreamWrapper $file An instance of StreamWrapper
	 */
	public  function setFile(StreamWrapper $file)
	{
		$this->file=$file; 
		$this->keyModified['file'] = 1; 

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

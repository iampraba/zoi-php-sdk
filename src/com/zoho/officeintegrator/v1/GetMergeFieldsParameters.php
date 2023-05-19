<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\StreamWrapper;
use com\zoho\util\Model;

class GetMergeFieldsParameters implements Model
{

	private  $fileContent;
	private  $fileUrl;
	private  $keyModified=array();

	/**
	 * The method to get the fileContent
	 * @return StreamWrapper An instance of StreamWrapper
	 */
	public  function getFileContent()
	{
		return $this->fileContent; 

	}

	/**
	 * The method to set the value to fileContent
	 * @param StreamWrapper $fileContent An instance of StreamWrapper
	 */
	public  function setFileContent(StreamWrapper $fileContent)
	{
		$this->fileContent=$fileContent; 
		$this->keyModified['file_content'] = 1; 

	}

	/**
	 * The method to get the fileUrl
	 * @return string A string representing the fileUrl
	 */
	public  function getFileUrl()
	{
		return $this->fileUrl; 

	}

	/**
	 * The method to set the value to fileUrl
	 * @param string $fileUrl A string
	 */
	public  function setFileUrl(string $fileUrl)
	{
		$this->fileUrl=$fileUrl; 
		$this->keyModified['file_url'] = 1; 

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

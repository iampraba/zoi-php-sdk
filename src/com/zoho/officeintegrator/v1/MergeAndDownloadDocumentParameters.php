<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\StreamWrapper;
use com\zoho\util\Model;

class MergeAndDownloadDocumentParameters implements Model
{

	private  $fileContent;
	private  $fileUrl;
	private  $outputFormat;
	private  $mergeData;
	private  $mergeDataCsvContent;
	private  $mergeDataJsonContent;
	private  $mergeDataCsvUrl;
	private  $mergeDataJsonUrl;
	private  $password;
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
	 * The method to get the outputFormat
	 * @return string A string representing the outputFormat
	 */
	public  function getOutputFormat()
	{
		return $this->outputFormat; 

	}

	/**
	 * The method to set the value to outputFormat
	 * @param string $outputFormat A string
	 */
	public  function setOutputFormat(string $outputFormat)
	{
		$this->outputFormat=$outputFormat; 
		$this->keyModified['output_format'] = 1; 

	}

	/**
	 * The method to get the mergeData
	 * @return array A array representing the mergeData
	 */
	public  function getMergeData()
	{
		return $this->mergeData; 

	}

	/**
	 * The method to set the value to mergeData
	 * @param array $mergeData A array
	 */
	public  function setMergeData(array $mergeData)
	{
		$this->mergeData=$mergeData; 
		$this->keyModified['merge_data'] = 1; 

	}

	/**
	 * The method to get the mergeDataCsvContent
	 * @return StreamWrapper An instance of StreamWrapper
	 */
	public  function getMergeDataCsvContent()
	{
		return $this->mergeDataCsvContent; 

	}

	/**
	 * The method to set the value to mergeDataCsvContent
	 * @param StreamWrapper $mergeDataCsvContent An instance of StreamWrapper
	 */
	public  function setMergeDataCsvContent(StreamWrapper $mergeDataCsvContent)
	{
		$this->mergeDataCsvContent=$mergeDataCsvContent; 
		$this->keyModified['merge_data_csv_content'] = 1; 

	}

	/**
	 * The method to get the mergeDataJsonContent
	 * @return StreamWrapper An instance of StreamWrapper
	 */
	public  function getMergeDataJsonContent()
	{
		return $this->mergeDataJsonContent; 

	}

	/**
	 * The method to set the value to mergeDataJsonContent
	 * @param StreamWrapper $mergeDataJsonContent An instance of StreamWrapper
	 */
	public  function setMergeDataJsonContent(StreamWrapper $mergeDataJsonContent)
	{
		$this->mergeDataJsonContent=$mergeDataJsonContent; 
		$this->keyModified['merge_data_json_content'] = 1; 

	}

	/**
	 * The method to get the mergeDataCsvUrl
	 * @return string A string representing the mergeDataCsvUrl
	 */
	public  function getMergeDataCsvUrl()
	{
		return $this->mergeDataCsvUrl; 

	}

	/**
	 * The method to set the value to mergeDataCsvUrl
	 * @param string $mergeDataCsvUrl A string
	 */
	public  function setMergeDataCsvUrl(string $mergeDataCsvUrl)
	{
		$this->mergeDataCsvUrl=$mergeDataCsvUrl; 
		$this->keyModified['merge_data_csv_url'] = 1; 

	}

	/**
	 * The method to get the mergeDataJsonUrl
	 * @return string A string representing the mergeDataJsonUrl
	 */
	public  function getMergeDataJsonUrl()
	{
		return $this->mergeDataJsonUrl; 

	}

	/**
	 * The method to set the value to mergeDataJsonUrl
	 * @param string $mergeDataJsonUrl A string
	 */
	public  function setMergeDataJsonUrl(string $mergeDataJsonUrl)
	{
		$this->mergeDataJsonUrl=$mergeDataJsonUrl; 
		$this->keyModified['merge_data_json_url'] = 1; 

	}

	/**
	 * The method to get the password
	 * @return string A string representing the password
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

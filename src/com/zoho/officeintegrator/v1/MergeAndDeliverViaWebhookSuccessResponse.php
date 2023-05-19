<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class MergeAndDeliverViaWebhookSuccessResponse implements Model, WriterResponseHandler
{

	private  $mergeReportDataUrl;
	private  $records;
	private  $keyModified=array();

	/**
	 * The method to get the mergeReportDataUrl
	 * @return string A string representing the mergeReportDataUrl
	 */
	public  function getMergeReportDataUrl()
	{
		return $this->mergeReportDataUrl; 

	}

	/**
	 * The method to set the value to mergeReportDataUrl
	 * @param string $mergeReportDataUrl A string
	 */
	public  function setMergeReportDataUrl(string $mergeReportDataUrl)
	{
		$this->mergeReportDataUrl=$mergeReportDataUrl; 
		$this->keyModified['merge_report_data_url'] = 1; 

	}

	/**
	 * The method to get the records
	 * @return array A array representing the records
	 */
	public  function getRecords()
	{
		return $this->records; 

	}

	/**
	 * The method to set the value to records
	 * @param array $records A array
	 */
	public  function setRecords(array $records)
	{
		$this->records=$records; 
		$this->keyModified['records'] = 1; 

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

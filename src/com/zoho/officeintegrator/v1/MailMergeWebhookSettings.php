<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class MailMergeWebhookSettings implements Model
{

	private  $invokeUrl;
	private  $invokePeriod;
	private  $keyModified=array();

	/**
	 * The method to get the invokeUrl
	 * @return string A string representing the invokeUrl
	 */
	public  function getInvokeUrl()
	{
		return $this->invokeUrl; 

	}

	/**
	 * The method to set the value to invokeUrl
	 * @param string $invokeUrl A string
	 */
	public  function setInvokeUrl(string $invokeUrl)
	{
		$this->invokeUrl=$invokeUrl; 
		$this->keyModified['invoke_url'] = 1; 

	}

	/**
	 * The method to get the invokePeriod
	 * @return string A string representing the invokePeriod
	 */
	public  function getInvokePeriod()
	{
		return $this->invokePeriod; 

	}

	/**
	 * The method to set the value to invokePeriod
	 * @param string $invokePeriod A string
	 */
	public  function setInvokePeriod(string $invokePeriod)
	{
		$this->invokePeriod=$invokePeriod; 
		$this->keyModified['invoke_period'] = 1; 

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

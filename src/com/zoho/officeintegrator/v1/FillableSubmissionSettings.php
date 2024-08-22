<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class FillableSubmissionSettings implements Model
{

	private  $callbackOptions;
	private  $redirectUrl;
	private  $onsubmitMessage;
	private  $keyModified=array();

	/**
	 * The method to get the callbackOptions
	 * @return FillableCallbackSettings | null An instance of FillableCallbackSettings
	 */
	public  function getCallbackOptions()
	{
		return $this->callbackOptions; 

	}

	/**
	 * The method to set the value to callbackOptions
	 * @param FillableCallbackSettings $callbackOptions An instance of FillableCallbackSettings
	 */
	public  function setCallbackOptions(FillableCallbackSettings $callbackOptions)
	{
		$this->callbackOptions=$callbackOptions; 
		$this->keyModified['callback_options'] = 1; 

	}

	/**
	 * The method to get the redirectUrl
	 * @return string | null A string representing the redirectUrl
	 */
	public  function getRedirectUrl()
	{
		return $this->redirectUrl; 

	}

	/**
	 * The method to set the value to redirectUrl
	 * @param string $redirectUrl A string
	 */
	public  function setRedirectUrl(string $redirectUrl)
	{
		$this->redirectUrl=$redirectUrl; 
		$this->keyModified['redirect_url'] = 1; 

	}

	/**
	 * The method to get the onsubmitMessage
	 * @return string | null A string representing the onsubmitMessage
	 */
	public  function getOnsubmitMessage()
	{
		return $this->onsubmitMessage; 

	}

	/**
	 * The method to set the value to onsubmitMessage
	 * @param string $onsubmitMessage A string
	 */
	public  function setOnsubmitMessage(string $onsubmitMessage)
	{
		$this->onsubmitMessage=$onsubmitMessage; 
		$this->keyModified['onsubmit_message'] = 1; 

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

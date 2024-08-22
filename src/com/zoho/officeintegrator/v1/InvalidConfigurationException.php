<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class InvalidConfigurationException implements Model, WriterResponseHandler, SheetResponseHandler, ShowResponseHandler, ResponseHandler
{

	private  $keyName;
	private  $code;
	private  $parameterName;
	private  $message;
	private  $keyModified=array();

	/**
	 * The method to get the keyName
	 * @return string | null A string representing the keyName
	 */
	public  function getKeyName()
	{
		return $this->keyName; 

	}

	/**
	 * The method to set the value to keyName
	 * @param string $keyName A string
	 */
	public  function setKeyName(string $keyName)
	{
		$this->keyName=$keyName; 
		$this->keyModified['key_name'] = 1; 

	}

	/**
	 * The method to get the code
	 * @return int | null A int representing the code
	 */
	public  function getCode()
	{
		return $this->code; 

	}

	/**
	 * The method to set the value to code
	 * @param int $code A int
	 */
	public  function setCode(int $code)
	{
		$this->code=$code; 
		$this->keyModified['code'] = 1; 

	}

	/**
	 * The method to get the parameterName
	 * @return string | null A string representing the parameterName
	 */
	public  function getParameterName()
	{
		return $this->parameterName; 

	}

	/**
	 * The method to set the value to parameterName
	 * @param string $parameterName A string
	 */
	public  function setParameterName(string $parameterName)
	{
		$this->parameterName=$parameterName; 
		$this->keyModified['parameter_name'] = 1; 

	}

	/**
	 * The method to get the message
	 * @return string | null A string representing the message
	 */
	public  function getMessage()
	{
		return $this->message; 

	}

	/**
	 * The method to set the value to message
	 * @param string $message A string
	 */
	public  function setMessage(string $message)
	{
		$this->message=$message; 
		$this->keyModified['message'] = 1; 

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

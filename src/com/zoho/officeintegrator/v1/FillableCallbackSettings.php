<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class FillableCallbackSettings implements Model
{

	private  $output;
	private  $url;
	private  $httpMethodType;
	private  $retries;
	private  $timeout;
	private  $keyModified=array();

	/**
	 * The method to get the output
	 * @return FillableLinkOutputSettings An instance of FillableLinkOutputSettings
	 */
	public  function getOutput()
	{
		return $this->output; 

	}

	/**
	 * The method to set the value to output
	 * @param FillableLinkOutputSettings $output An instance of FillableLinkOutputSettings
	 */
	public  function setOutput(FillableLinkOutputSettings $output)
	{
		$this->output=$output; 
		$this->keyModified['output'] = 1; 

	}

	/**
	 * The method to get the url
	 * @return string A string representing the url
	 */
	public  function getUrl()
	{
		return $this->url; 

	}

	/**
	 * The method to set the value to url
	 * @param string $url A string
	 */
	public  function setUrl(string $url)
	{
		$this->url=$url; 
		$this->keyModified['url'] = 1; 

	}

	/**
	 * The method to get the httpMethodType
	 * @return string A string representing the httpMethodType
	 */
	public  function getHttpMethodType()
	{
		return $this->httpMethodType; 

	}

	/**
	 * The method to set the value to httpMethodType
	 * @param string $httpMethodType A string
	 */
	public  function setHttpMethodType(string $httpMethodType)
	{
		$this->httpMethodType=$httpMethodType; 
		$this->keyModified['http_method_type'] = 1; 

	}

	/**
	 * The method to get the retries
	 * @return int A int representing the retries
	 */
	public  function getRetries()
	{
		return $this->retries; 

	}

	/**
	 * The method to set the value to retries
	 * @param int $retries A int
	 */
	public  function setRetries(int $retries)
	{
		$this->retries=$retries; 
		$this->keyModified['retries'] = 1; 

	}

	/**
	 * The method to get the timeout
	 * @return int A int representing the timeout
	 */
	public  function getTimeout()
	{
		return $this->timeout; 

	}

	/**
	 * The method to set the value to timeout
	 * @param int $timeout A int
	 */
	public  function setTimeout(int $timeout)
	{
		$this->timeout=$timeout; 
		$this->keyModified['timeout'] = 1; 

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

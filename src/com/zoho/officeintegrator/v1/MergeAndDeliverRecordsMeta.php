<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class MergeAndDeliverRecordsMeta implements Model
{

	private  $downloadLink;
	private  $email;
	private  $name;
	private  $status;
	private  $keyModified=array();

	/**
	 * The method to get the downloadLink
	 * @return string | null A string representing the downloadLink
	 */
	public  function getDownloadLink()
	{
		return $this->downloadLink; 

	}

	/**
	 * The method to set the value to downloadLink
	 * @param string $downloadLink A string
	 */
	public  function setDownloadLink(string $downloadLink)
	{
		$this->downloadLink=$downloadLink; 
		$this->keyModified['download_link'] = 1; 

	}

	/**
	 * The method to get the email
	 * @return string | null A string representing the email
	 */
	public  function getEmail()
	{
		return $this->email; 

	}

	/**
	 * The method to set the value to email
	 * @param string $email A string
	 */
	public  function setEmail(string $email)
	{
		$this->email=$email; 
		$this->keyModified['email'] = 1; 

	}

	/**
	 * The method to get the name
	 * @return string | null A string representing the name
	 */
	public  function getName()
	{
		return $this->name; 

	}

	/**
	 * The method to set the value to name
	 * @param string $name A string
	 */
	public  function setName(string $name)
	{
		$this->name=$name; 
		$this->keyModified['name'] = 1; 

	}

	/**
	 * The method to get the status
	 * @return string | null A string representing the status
	 */
	public  function getStatus()
	{
		return $this->status; 

	}

	/**
	 * The method to set the value to status
	 * @param string $status A string
	 */
	public  function setStatus(string $status)
	{
		$this->status=$status; 
		$this->keyModified['status'] = 1; 

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

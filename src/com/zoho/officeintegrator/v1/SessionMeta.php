<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class SessionMeta implements Model, WriterResponseHandler, SheetResponseHandler, ShowResponseHandler
{

	private  $status;
	private  $info;
	private  $userInfo;
	private  $keyModified=array();

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
	 * The method to get the info
	 * @return SessionInfo | null An instance of SessionInfo
	 */
	public  function getInfo()
	{
		return $this->info; 

	}

	/**
	 * The method to set the value to info
	 * @param SessionInfo $info An instance of SessionInfo
	 */
	public  function setInfo(SessionInfo $info)
	{
		$this->info=$info; 
		$this->keyModified['info'] = 1; 

	}

	/**
	 * The method to get the userInfo
	 * @return SessionUserInfo | null An instance of SessionUserInfo
	 */
	public  function getUserInfo()
	{
		return $this->userInfo; 

	}

	/**
	 * The method to set the value to userInfo
	 * @param SessionUserInfo $userInfo An instance of SessionUserInfo
	 */
	public  function setUserInfo(SessionUserInfo $userInfo)
	{
		$this->userInfo=$userInfo; 
		$this->keyModified['user_info'] = 1; 

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

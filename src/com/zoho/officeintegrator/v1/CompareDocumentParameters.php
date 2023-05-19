<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\StreamWrapper;
use com\zoho\util\Model;

class CompareDocumentParameters implements Model
{

	private  $document1;
	private  $url1;
	private  $document2;
	private  $url2;
	private  $title;
	private  $lang;
	private  $keyModified=array();

	/**
	 * The method to get the document1
	 * @return StreamWrapper An instance of StreamWrapper
	 */
	public  function getDocument1()
	{
		return $this->document1; 

	}

	/**
	 * The method to set the value to document1
	 * @param StreamWrapper $document1 An instance of StreamWrapper
	 */
	public  function setDocument1(StreamWrapper $document1)
	{
		$this->document1=$document1; 
		$this->keyModified['document1'] = 1; 

	}

	/**
	 * The method to get the url1
	 * @return string A string representing the url1
	 */
	public  function getUrl1()
	{
		return $this->url1; 

	}

	/**
	 * The method to set the value to url1
	 * @param string $url1 A string
	 */
	public  function setUrl1(string $url1)
	{
		$this->url1=$url1; 
		$this->keyModified['url1'] = 1; 

	}

	/**
	 * The method to get the document2
	 * @return StreamWrapper An instance of StreamWrapper
	 */
	public  function getDocument2()
	{
		return $this->document2; 

	}

	/**
	 * The method to set the value to document2
	 * @param StreamWrapper $document2 An instance of StreamWrapper
	 */
	public  function setDocument2(StreamWrapper $document2)
	{
		$this->document2=$document2; 
		$this->keyModified['document2'] = 1; 

	}

	/**
	 * The method to get the url2
	 * @return string A string representing the url2
	 */
	public  function getUrl2()
	{
		return $this->url2; 

	}

	/**
	 * The method to set the value to url2
	 * @param string $url2 A string
	 */
	public  function setUrl2(string $url2)
	{
		$this->url2=$url2; 
		$this->keyModified['url2'] = 1; 

	}

	/**
	 * The method to get the title
	 * @return string A string representing the title
	 */
	public  function getTitle()
	{
		return $this->title; 

	}

	/**
	 * The method to set the value to title
	 * @param string $title A string
	 */
	public  function setTitle(string $title)
	{
		$this->title=$title; 
		$this->keyModified['title'] = 1; 

	}

	/**
	 * The method to get the lang
	 * @return string A string representing the lang
	 */
	public  function getLang()
	{
		return $this->lang; 

	}

	/**
	 * The method to set the value to lang
	 * @param string $lang A string
	 */
	public  function setLang(string $lang)
	{
		$this->lang=$lang; 
		$this->keyModified['lang'] = 1; 

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

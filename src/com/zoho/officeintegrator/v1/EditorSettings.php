<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class EditorSettings implements Model
{

	private  $unit;
	private  $language;
	private  $view;
	private  $keyModified=array();

	/**
	 * The method to get the unit
	 * @return string | null A string representing the unit
	 */
	public  function getUnit()
	{
		return $this->unit; 

	}

	/**
	 * The method to set the value to unit
	 * @param string $unit A string
	 */
	public  function setUnit(string $unit)
	{
		$this->unit=$unit; 
		$this->keyModified['unit'] = 1; 

	}

	/**
	 * The method to get the language
	 * @return string | null A string representing the language
	 */
	public  function getLanguage()
	{
		return $this->language; 

	}

	/**
	 * The method to set the value to language
	 * @param string $language A string
	 */
	public  function setLanguage(string $language)
	{
		$this->language=$language; 
		$this->keyModified['language'] = 1; 

	}

	/**
	 * The method to get the view
	 * @return string | null A string representing the view
	 */
	public  function getView()
	{
		return $this->view; 

	}

	/**
	 * The method to set the value to view
	 * @param string $view A string
	 */
	public  function setView(string $view)
	{
		$this->view=$view; 
		$this->keyModified['view'] = 1; 

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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class UiOptions implements Model
{

	private  $saveButton;
	private  $chatPanel;
	private  $fileMenu;
	private  $darkMode;
	private  $keyModified=array();

	/**
	 * The method to get the saveButton
	 * @return string | null A string representing the saveButton
	 */
	public  function getSaveButton()
	{
		return $this->saveButton; 

	}

	/**
	 * The method to set the value to saveButton
	 * @param string $saveButton A string
	 */
	public  function setSaveButton(string $saveButton)
	{
		$this->saveButton=$saveButton; 
		$this->keyModified['save_button'] = 1; 

	}

	/**
	 * The method to get the chatPanel
	 * @return string | null A string representing the chatPanel
	 */
	public  function getChatPanel()
	{
		return $this->chatPanel; 

	}

	/**
	 * The method to set the value to chatPanel
	 * @param string $chatPanel A string
	 */
	public  function setChatPanel(string $chatPanel)
	{
		$this->chatPanel=$chatPanel; 
		$this->keyModified['chat_panel'] = 1; 

	}

	/**
	 * The method to get the fileMenu
	 * @return string | null A string representing the fileMenu
	 */
	public  function getFileMenu()
	{
		return $this->fileMenu; 

	}

	/**
	 * The method to set the value to fileMenu
	 * @param string $fileMenu A string
	 */
	public  function setFileMenu(string $fileMenu)
	{
		$this->fileMenu=$fileMenu; 
		$this->keyModified['file_menu'] = 1; 

	}

	/**
	 * The method to get the darkMode
	 * @return string | null A string representing the darkMode
	 */
	public  function getDarkMode()
	{
		return $this->darkMode; 

	}

	/**
	 * The method to set the value to darkMode
	 * @param string $darkMode A string
	 */
	public  function setDarkMode(string $darkMode)
	{
		$this->darkMode=$darkMode; 
		$this->keyModified['dark_mode'] = 1; 

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

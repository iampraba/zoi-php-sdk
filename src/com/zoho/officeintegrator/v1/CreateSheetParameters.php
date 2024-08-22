<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\StreamWrapper;
use com\zoho\officeintegrator\util\Model;

class CreateSheetParameters implements Model
{

	private  $url;
	private  $document;
	private  $callbackSettings;
	private  $editorSettings;
	private  $permissions;
	private  $documentInfo;
	private  $userInfo;
	private  $uiOptions;
	private  $keyModified=array();

	/**
	 * The method to get the url
	 * @return string | null A string representing the url
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
	 * The method to get the document
	 * @return StreamWrapper | null An instance of StreamWrapper
	 */
	public  function getDocument()
	{
		return $this->document; 

	}

	/**
	 * The method to set the value to document
	 * @param StreamWrapper $document An instance of StreamWrapper
	 */
	public  function setDocument(StreamWrapper $document)
	{
		$this->document=$document; 
		$this->keyModified['document'] = 1; 

	}

	/**
	 * The method to get the callbackSettings
	 * @return SheetCallbackSettings | null An instance of SheetCallbackSettings
	 */
	public  function getCallbackSettings()
	{
		return $this->callbackSettings; 

	}

	/**
	 * The method to set the value to callbackSettings
	 * @param SheetCallbackSettings $callbackSettings An instance of SheetCallbackSettings
	 */
	public  function setCallbackSettings(SheetCallbackSettings $callbackSettings)
	{
		$this->callbackSettings=$callbackSettings; 
		$this->keyModified['callback_settings'] = 1; 

	}

	/**
	 * The method to get the editorSettings
	 * @return SheetEditorSettings | null An instance of SheetEditorSettings
	 */
	public  function getEditorSettings()
	{
		return $this->editorSettings; 

	}

	/**
	 * The method to set the value to editorSettings
	 * @param SheetEditorSettings $editorSettings An instance of SheetEditorSettings
	 */
	public  function setEditorSettings(SheetEditorSettings $editorSettings)
	{
		$this->editorSettings=$editorSettings; 
		$this->keyModified['editor_settings'] = 1; 

	}

	/**
	 * The method to get the permissions
	 * @return array | null A array representing the permissions
	 */
	public  function getPermissions()
	{
		return $this->permissions; 

	}

	/**
	 * The method to set the value to permissions
	 * @param array $permissions A array
	 */
	public  function setPermissions(array $permissions)
	{
		$this->permissions=$permissions; 
		$this->keyModified['permissions'] = 1; 

	}

	/**
	 * The method to get the documentInfo
	 * @return DocumentInfo | null An instance of DocumentInfo
	 */
	public  function getDocumentInfo()
	{
		return $this->documentInfo; 

	}

	/**
	 * The method to set the value to documentInfo
	 * @param DocumentInfo $documentInfo An instance of DocumentInfo
	 */
	public  function setDocumentInfo(DocumentInfo $documentInfo)
	{
		$this->documentInfo=$documentInfo; 
		$this->keyModified['document_info'] = 1; 

	}

	/**
	 * The method to get the userInfo
	 * @return SheetUserSettings | null An instance of SheetUserSettings
	 */
	public  function getUserInfo()
	{
		return $this->userInfo; 

	}

	/**
	 * The method to set the value to userInfo
	 * @param SheetUserSettings $userInfo An instance of SheetUserSettings
	 */
	public  function setUserInfo(SheetUserSettings $userInfo)
	{
		$this->userInfo=$userInfo; 
		$this->keyModified['user_info'] = 1; 

	}

	/**
	 * The method to get the uiOptions
	 * @return SheetUiOptions | null An instance of SheetUiOptions
	 */
	public  function getUiOptions()
	{
		return $this->uiOptions; 

	}

	/**
	 * The method to set the value to uiOptions
	 * @param SheetUiOptions $uiOptions An instance of SheetUiOptions
	 */
	public  function setUiOptions(SheetUiOptions $uiOptions)
	{
		$this->uiOptions=$uiOptions; 
		$this->keyModified['ui_options'] = 1; 

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

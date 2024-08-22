<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\StreamWrapper;
use com\zoho\officeintegrator\util\Model;

class CreateDocumentParameters implements Model
{

	private  $url;
	private  $document;
	private  $callbackSettings;
	private  $documentDefaults;
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
	 * @return CallbackSettings | null An instance of CallbackSettings
	 */
	public  function getCallbackSettings()
	{
		return $this->callbackSettings; 

	}

	/**
	 * The method to set the value to callbackSettings
	 * @param CallbackSettings $callbackSettings An instance of CallbackSettings
	 */
	public  function setCallbackSettings(CallbackSettings $callbackSettings)
	{
		$this->callbackSettings=$callbackSettings; 
		$this->keyModified['callback_settings'] = 1; 

	}

	/**
	 * The method to get the documentDefaults
	 * @return DocumentDefaults | null An instance of DocumentDefaults
	 */
	public  function getDocumentDefaults()
	{
		return $this->documentDefaults; 

	}

	/**
	 * The method to set the value to documentDefaults
	 * @param DocumentDefaults $documentDefaults An instance of DocumentDefaults
	 */
	public  function setDocumentDefaults(DocumentDefaults $documentDefaults)
	{
		$this->documentDefaults=$documentDefaults; 
		$this->keyModified['document_defaults'] = 1; 

	}

	/**
	 * The method to get the editorSettings
	 * @return EditorSettings | null An instance of EditorSettings
	 */
	public  function getEditorSettings()
	{
		return $this->editorSettings; 

	}

	/**
	 * The method to set the value to editorSettings
	 * @param EditorSettings $editorSettings An instance of EditorSettings
	 */
	public  function setEditorSettings(EditorSettings $editorSettings)
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
	 * @return UserInfo | null An instance of UserInfo
	 */
	public  function getUserInfo()
	{
		return $this->userInfo; 

	}

	/**
	 * The method to set the value to userInfo
	 * @param UserInfo $userInfo An instance of UserInfo
	 */
	public  function setUserInfo(UserInfo $userInfo)
	{
		$this->userInfo=$userInfo; 
		$this->keyModified['user_info'] = 1; 

	}

	/**
	 * The method to get the uiOptions
	 * @return UiOptions | null An instance of UiOptions
	 */
	public  function getUiOptions()
	{
		return $this->uiOptions; 

	}

	/**
	 * The method to set the value to uiOptions
	 * @param UiOptions $uiOptions An instance of UiOptions
	 */
	public  function setUiOptions(UiOptions $uiOptions)
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

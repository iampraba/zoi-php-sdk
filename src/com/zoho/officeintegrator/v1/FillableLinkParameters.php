<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\StreamWrapper;
use com\zoho\officeintegrator\util\Model;

class FillableLinkParameters implements Model
{

	private  $document;
	private  $url;
	private  $documentInfo;
	private  $userInfo;
	private  $prefillData;
	private  $formLanguage;
	private  $submitSettings;
	private  $formOptions;
	private  $keyModified=array();

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
	 * The method to get the prefillData
	 * @return array | null A array representing the prefillData
	 */
	public  function getPrefillData()
	{
		return $this->prefillData; 

	}

	/**
	 * The method to set the value to prefillData
	 * @param array $prefillData A array
	 */
	public  function setPrefillData(array $prefillData)
	{
		$this->prefillData=$prefillData; 
		$this->keyModified['prefill_data'] = 1; 

	}

	/**
	 * The method to get the formLanguage
	 * @return string | null A string representing the formLanguage
	 */
	public  function getFormLanguage()
	{
		return $this->formLanguage; 

	}

	/**
	 * The method to set the value to formLanguage
	 * @param string $formLanguage A string
	 */
	public  function setFormLanguage(string $formLanguage)
	{
		$this->formLanguage=$formLanguage; 
		$this->keyModified['form_language'] = 1; 

	}

	/**
	 * The method to get the submitSettings
	 * @return FillableSubmissionSettings | null An instance of FillableSubmissionSettings
	 */
	public  function getSubmitSettings()
	{
		return $this->submitSettings; 

	}

	/**
	 * The method to set the value to submitSettings
	 * @param FillableSubmissionSettings $submitSettings An instance of FillableSubmissionSettings
	 */
	public  function setSubmitSettings(FillableSubmissionSettings $submitSettings)
	{
		$this->submitSettings=$submitSettings; 
		$this->keyModified['submit_settings'] = 1; 

	}

	/**
	 * The method to get the formOptions
	 * @return FillableFormOptions | null An instance of FillableFormOptions
	 */
	public  function getFormOptions()
	{
		return $this->formOptions; 

	}

	/**
	 * The method to set the value to formOptions
	 * @param FillableFormOptions $formOptions An instance of FillableFormOptions
	 */
	public  function setFormOptions(FillableFormOptions $formOptions)
	{
		$this->formOptions=$formOptions; 
		$this->keyModified['form_options'] = 1; 

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

<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class CombinePDFsParameters implements Model
{

	private  $inputOptions;
	private  $outputSettings;
	private  $keyModified=array();

	/**
	 * The method to get the inputOptions
	 * @return array | null A array representing the inputOptions
	 */
	public  function getInputOptions()
	{
		return $this->inputOptions; 

	}

	/**
	 * The method to set the value to inputOptions
	 * @param array $inputOptions A array
	 */
	public  function setInputOptions(array $inputOptions)
	{
		$this->inputOptions=$inputOptions; 
		$this->keyModified['input_options'] = 1; 

	}

	/**
	 * The method to get the outputSettings
	 * @return CombinePDFsOutputSettings | null An instance of CombinePDFsOutputSettings
	 */
	public  function getOutputSettings()
	{
		return $this->outputSettings; 

	}

	/**
	 * The method to set the value to outputSettings
	 * @param CombinePDFsOutputSettings $outputSettings An instance of CombinePDFsOutputSettings
	 */
	public  function setOutputSettings(CombinePDFsOutputSettings $outputSettings)
	{
		$this->outputSettings=$outputSettings; 
		$this->keyModified['output_settings'] = 1; 

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

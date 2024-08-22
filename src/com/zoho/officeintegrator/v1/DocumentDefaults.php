<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class DocumentDefaults implements Model
{

	private  $orientation;
	private  $paperSize;
	private  $fontName;
	private  $fontSize;
	private  $trackChanges;
	private  $language;
	private  $margin;
	private  $keyModified=array();

	/**
	 * The method to get the orientation
	 * @return string | null A string representing the orientation
	 */
	public  function getOrientation()
	{
		return $this->orientation; 

	}

	/**
	 * The method to set the value to orientation
	 * @param string $orientation A string
	 */
	public  function setOrientation(string $orientation)
	{
		$this->orientation=$orientation; 
		$this->keyModified['orientation'] = 1; 

	}

	/**
	 * The method to get the paperSize
	 * @return string | null A string representing the paperSize
	 */
	public  function getPaperSize()
	{
		return $this->paperSize; 

	}

	/**
	 * The method to set the value to paperSize
	 * @param string $paperSize A string
	 */
	public  function setPaperSize(string $paperSize)
	{
		$this->paperSize=$paperSize; 
		$this->keyModified['paper_size'] = 1; 

	}

	/**
	 * The method to get the fontName
	 * @return string | null A string representing the fontName
	 */
	public  function getFontName()
	{
		return $this->fontName; 

	}

	/**
	 * The method to set the value to fontName
	 * @param string $fontName A string
	 */
	public  function setFontName(string $fontName)
	{
		$this->fontName=$fontName; 
		$this->keyModified['font_name'] = 1; 

	}

	/**
	 * The method to get the fontSize
	 * @return int | null A int representing the fontSize
	 */
	public  function getFontSize()
	{
		return $this->fontSize; 

	}

	/**
	 * The method to set the value to fontSize
	 * @param int $fontSize A int
	 */
	public  function setFontSize(int $fontSize)
	{
		$this->fontSize=$fontSize; 
		$this->keyModified['font_size'] = 1; 

	}

	/**
	 * The method to get the trackChanges
	 * @return string | null A string representing the trackChanges
	 */
	public  function getTrackChanges()
	{
		return $this->trackChanges; 

	}

	/**
	 * The method to set the value to trackChanges
	 * @param string $trackChanges A string
	 */
	public  function setTrackChanges(string $trackChanges)
	{
		$this->trackChanges=$trackChanges; 
		$this->keyModified['track_changes'] = 1; 

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
	 * The method to get the margin
	 * @return Margin | null An instance of Margin
	 */
	public  function getMargin()
	{
		return $this->margin; 

	}

	/**
	 * The method to set the value to margin
	 * @param Margin $margin An instance of Margin
	 */
	public  function setMargin(Margin $margin)
	{
		$this->margin=$margin; 
		$this->keyModified['margin'] = 1; 

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

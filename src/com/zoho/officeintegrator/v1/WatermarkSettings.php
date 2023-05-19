<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\util\Model;

class WatermarkSettings implements Model
{

	private  $text;
	private  $type;
	private  $orientation;
	private  $fontName;
	private  $fontSize;
	private  $fontColor;
	private  $opacity;
	private  $keyModified=array();

	/**
	 * The method to get the text
	 * @return string A string representing the text
	 */
	public  function getText()
	{
		return $this->text; 

	}

	/**
	 * The method to set the value to text
	 * @param string $text A string
	 */
	public  function setText(string $text)
	{
		$this->text=$text; 
		$this->keyModified['text'] = 1; 

	}

	/**
	 * The method to get the type
	 * @return string A string representing the type
	 */
	public  function getType()
	{
		return $this->type; 

	}

	/**
	 * The method to set the value to type
	 * @param string $type A string
	 */
	public  function setType(string $type)
	{
		$this->type=$type; 
		$this->keyModified['type'] = 1; 

	}

	/**
	 * The method to get the orientation
	 * @return string A string representing the orientation
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
	 * The method to get the fontName
	 * @return string A string representing the fontName
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
	 * @return int A int representing the fontSize
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
	 * The method to get the fontColor
	 * @return string A string representing the fontColor
	 */
	public  function getFontColor()
	{
		return $this->fontColor; 

	}

	/**
	 * The method to set the value to fontColor
	 * @param string $fontColor A string
	 */
	public  function setFontColor(string $fontColor)
	{
		$this->fontColor=$fontColor; 
		$this->keyModified['font_color'] = 1; 

	}

	/**
	 * The method to get the opacity
	 * @return float A float representing the opacity
	 */
	public  function getOpacity()
	{
		return $this->opacity; 

	}

	/**
	 * The method to set the value to opacity
	 * @param float $opacity A float
	 */
	public  function setOpacity(float $opacity)
	{
		$this->opacity=$opacity; 
		$this->keyModified['opacity'] = 1; 

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

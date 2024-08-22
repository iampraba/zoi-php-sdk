<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class Margin implements Model
{

	private  $left;
	private  $right;
	private  $top;
	private  $bottom;
	private  $keyModified=array();

	/**
	 * The method to get the left
	 * @return string | null A string representing the left
	 */
	public  function getLeft()
	{
		return $this->left; 

	}

	/**
	 * The method to set the value to left
	 * @param string $left A string
	 */
	public  function setLeft(string $left)
	{
		$this->left=$left; 
		$this->keyModified['left'] = 1; 

	}

	/**
	 * The method to get the right
	 * @return string | null A string representing the right
	 */
	public  function getRight()
	{
		return $this->right; 

	}

	/**
	 * The method to set the value to right
	 * @param string $right A string
	 */
	public  function setRight(string $right)
	{
		$this->right=$right; 
		$this->keyModified['right'] = 1; 

	}

	/**
	 * The method to get the top
	 * @return string | null A string representing the top
	 */
	public  function getTop()
	{
		return $this->top; 

	}

	/**
	 * The method to set the value to top
	 * @param string $top A string
	 */
	public  function setTop(string $top)
	{
		$this->top=$top; 
		$this->keyModified['top'] = 1; 

	}

	/**
	 * The method to get the bottom
	 * @return string | null A string representing the bottom
	 */
	public  function getBottom()
	{
		return $this->bottom; 

	}

	/**
	 * The method to set the value to bottom
	 * @param string $bottom A string
	 */
	public  function setBottom(string $bottom)
	{
		$this->bottom=$bottom; 
		$this->keyModified['bottom'] = 1; 

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

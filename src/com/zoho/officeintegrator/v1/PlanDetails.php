<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\util\Model;

class PlanDetails implements Model, ResponseHandler
{

	private  $usageLimit;
	private  $apikeyGeneratedTime;
	private  $remainingUsageLimit;
	private  $lastPaymentDateMs;
	private  $nextPaymentDateMs;
	private  $lastPaymentDate;
	private  $apikeyId;
	private  $planName;
	private  $apikeyGeneratedTimeMs;
	private  $paymentLink;
	private  $nextPaymentDate;
	private  $subscriptionInterval;
	private  $totalUsage;
	private  $subscriptionPeriod;
	private  $keyModified=array();

	/**
	 * The method to get the usageLimit
	 * @return string | null A string representing the usageLimit
	 */
	public  function getUsageLimit()
	{
		return $this->usageLimit; 

	}

	/**
	 * The method to set the value to usageLimit
	 * @param string $usageLimit A string
	 */
	public  function setUsageLimit(string $usageLimit)
	{
		$this->usageLimit=$usageLimit; 
		$this->keyModified['usage_limit'] = 1; 

	}

	/**
	 * The method to get the apikeyGeneratedTime
	 * @return string | null A string representing the apikeyGeneratedTime
	 */
	public  function getApikeyGeneratedTime()
	{
		return $this->apikeyGeneratedTime; 

	}

	/**
	 * The method to set the value to apikeyGeneratedTime
	 * @param string $apikeyGeneratedTime A string
	 */
	public  function setApikeyGeneratedTime(string $apikeyGeneratedTime)
	{
		$this->apikeyGeneratedTime=$apikeyGeneratedTime; 
		$this->keyModified['apikey_generated_time'] = 1; 

	}

	/**
	 * The method to get the remainingUsageLimit
	 * @return string | null A string representing the remainingUsageLimit
	 */
	public  function getRemainingUsageLimit()
	{
		return $this->remainingUsageLimit; 

	}

	/**
	 * The method to set the value to remainingUsageLimit
	 * @param string $remainingUsageLimit A string
	 */
	public  function setRemainingUsageLimit(string $remainingUsageLimit)
	{
		$this->remainingUsageLimit=$remainingUsageLimit; 
		$this->keyModified['remaining_usage_limit'] = 1; 

	}

	/**
	 * The method to get the lastPaymentDateMs
	 * @return string | null A string representing the lastPaymentDateMs
	 */
	public  function getLastPaymentDateMs()
	{
		return $this->lastPaymentDateMs; 

	}

	/**
	 * The method to set the value to lastPaymentDateMs
	 * @param string $lastPaymentDateMs A string
	 */
	public  function setLastPaymentDateMs(string $lastPaymentDateMs)
	{
		$this->lastPaymentDateMs=$lastPaymentDateMs; 
		$this->keyModified['last_payment_date_ms'] = 1; 

	}

	/**
	 * The method to get the nextPaymentDateMs
	 * @return string | null A string representing the nextPaymentDateMs
	 */
	public  function getNextPaymentDateMs()
	{
		return $this->nextPaymentDateMs; 

	}

	/**
	 * The method to set the value to nextPaymentDateMs
	 * @param string $nextPaymentDateMs A string
	 */
	public  function setNextPaymentDateMs(string $nextPaymentDateMs)
	{
		$this->nextPaymentDateMs=$nextPaymentDateMs; 
		$this->keyModified['next_payment_date_ms'] = 1; 

	}

	/**
	 * The method to get the lastPaymentDate
	 * @return string | null A string representing the lastPaymentDate
	 */
	public  function getLastPaymentDate()
	{
		return $this->lastPaymentDate; 

	}

	/**
	 * The method to set the value to lastPaymentDate
	 * @param string $lastPaymentDate A string
	 */
	public  function setLastPaymentDate(string $lastPaymentDate)
	{
		$this->lastPaymentDate=$lastPaymentDate; 
		$this->keyModified['last_payment_date'] = 1; 

	}

	/**
	 * The method to get the apikeyId
	 * @return string | null A string representing the apikeyId
	 */
	public  function getApikeyId()
	{
		return $this->apikeyId; 

	}

	/**
	 * The method to set the value to apikeyId
	 * @param string $apikeyId A string
	 */
	public  function setApikeyId(string $apikeyId)
	{
		$this->apikeyId=$apikeyId; 
		$this->keyModified['apikey_id'] = 1; 

	}

	/**
	 * The method to get the planName
	 * @return string | null A string representing the planName
	 */
	public  function getPlanName()
	{
		return $this->planName; 

	}

	/**
	 * The method to set the value to planName
	 * @param string $planName A string
	 */
	public  function setPlanName(string $planName)
	{
		$this->planName=$planName; 
		$this->keyModified['plan_name'] = 1; 

	}

	/**
	 * The method to get the apikeyGeneratedTimeMs
	 * @return string | null A string representing the apikeyGeneratedTimeMs
	 */
	public  function getApikeyGeneratedTimeMs()
	{
		return $this->apikeyGeneratedTimeMs; 

	}

	/**
	 * The method to set the value to apikeyGeneratedTimeMs
	 * @param string $apikeyGeneratedTimeMs A string
	 */
	public  function setApikeyGeneratedTimeMs(string $apikeyGeneratedTimeMs)
	{
		$this->apikeyGeneratedTimeMs=$apikeyGeneratedTimeMs; 
		$this->keyModified['apikey_generated_time_ms'] = 1; 

	}

	/**
	 * The method to get the paymentLink
	 * @return string | null A string representing the paymentLink
	 */
	public  function getPaymentLink()
	{
		return $this->paymentLink; 

	}

	/**
	 * The method to set the value to paymentLink
	 * @param string $paymentLink A string
	 */
	public  function setPaymentLink(string $paymentLink)
	{
		$this->paymentLink=$paymentLink; 
		$this->keyModified['payment_link'] = 1; 

	}

	/**
	 * The method to get the nextPaymentDate
	 * @return string | null A string representing the nextPaymentDate
	 */
	public  function getNextPaymentDate()
	{
		return $this->nextPaymentDate; 

	}

	/**
	 * The method to set the value to nextPaymentDate
	 * @param string $nextPaymentDate A string
	 */
	public  function setNextPaymentDate(string $nextPaymentDate)
	{
		$this->nextPaymentDate=$nextPaymentDate; 
		$this->keyModified['next_payment_date'] = 1; 

	}

	/**
	 * The method to get the subscriptionInterval
	 * @return string | null A string representing the subscriptionInterval
	 */
	public  function getSubscriptionInterval()
	{
		return $this->subscriptionInterval; 

	}

	/**
	 * The method to set the value to subscriptionInterval
	 * @param string $subscriptionInterval A string
	 */
	public  function setSubscriptionInterval(string $subscriptionInterval)
	{
		$this->subscriptionInterval=$subscriptionInterval; 
		$this->keyModified['subscription_interval'] = 1; 

	}

	/**
	 * The method to get the totalUsage
	 * @return string | null A string representing the totalUsage
	 */
	public  function getTotalUsage()
	{
		return $this->totalUsage; 

	}

	/**
	 * The method to set the value to totalUsage
	 * @param string $totalUsage A string
	 */
	public  function setTotalUsage(string $totalUsage)
	{
		$this->totalUsage=$totalUsage; 
		$this->keyModified['total_usage'] = 1; 

	}

	/**
	 * The method to get the subscriptionPeriod
	 * @return string | null A string representing the subscriptionPeriod
	 */
	public  function getSubscriptionPeriod()
	{
		return $this->subscriptionPeriod; 

	}

	/**
	 * The method to set the value to subscriptionPeriod
	 * @param string $subscriptionPeriod A string
	 */
	public  function setSubscriptionPeriod(string $subscriptionPeriod)
	{
		$this->subscriptionPeriod=$subscriptionPeriod; 
		$this->keyModified['subscription_period'] = 1; 

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

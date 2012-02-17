<?php
/**
 * 
 * This source file is subject to add validator
 * and validate given value.Gives error massage if 
 * value is not valid.
 * 
 *
 * @category   ZendX
 * @package    Custom
 * @copyright  Copyright (c) 2011
 * @author     Sanjay Rathod, Shashank Patel
 * @version    $Id: 
 */
class ZendX_Custom_Data_Validator extends Zend_Validate
{
	/**
	* Array of validation failure messages
	*
	* @var array
	*/
	protected $_errorMessages = array();

	/**
	* Stores count of added validators
	*
	* @var numeric
	*/
	protected $_count = 0;


	/**
	* Adds a validator to the end of the chain
	*
	* @param  string $ssValue stores value to validate
	* @param  array $asValidator Stores validator array
	* @author Sanjay Rathod, Shashank Patel
	* @return boolean
	*/
	public function customAddValidatorAndValidateValue($ssValue = "", $asValidator = array())
	{
		if ( !is_array($asValidator) || empty($asValidator) ) return false;
		
		foreach ( $asValidator as $snKey => $ssValidator )
		{
			// class doesn't exist, and "false" given for not using the auto-loader to try to load it
			// if "true" given than auto-loader try to load that class if not exist
			if (!class_exists($ssValidator,false)) return false;
			
			$this->addValidator(new $ssValidator, true);
			$this->_count++;
		}
		
		if($this->_count == 0) return false;
		
		if($this->isValid($ssValue))
			return true;
		else
		{
			$this->_errorMessages = $this->getMessages();
			return false;
		}
	}

	/**
	* Returns array of validation failure messages
	*
	* @author Sanjay Rathod, Shashank Patel
	* @return array
	*/
	public function customGetErrorMassages()
	{
		return $this->_errorMessages;
	}
}
<?php
/**
 * Tests_Validation
 *
 * Unit test case for Validation
 *
 * @package zend-rest
 * @subpackage phpunit
 * @author     Shashank Patel
 *
 */

class Tests_Validation extends PHPUnit_Framework_TestCase
{
	public function testValidateEmail()
    {
		$ssEmail = "shashank@virtueinfo.com1";
		$asValidator = array('Zend_Validate_NotEmpty','Zend_Validate_EmailAddress');
		$oCustomDataValidator = new ZendX_Custom_Data_Validator();
		$bIsValid = $oCustomDataValidator->customAddValidatorAndValidateValue($ssEmail,$asValidator);

		if(!$bIsValid)
			$asMassages = $oCustomDataValidator->customGetErrorMassages();
		else
			$asMassages = array("success");
	}
} 

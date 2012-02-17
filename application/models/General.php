<?php
/**
 * Application_Model_General Class File.
 * 
 * This General file demonstrates all common functions
 * which include all common functions. 
 * @package    Zend-rest
 * @subpackage application
 * @author     Arpita Rana
 * @version    SVN: $Id: Application_Model_General.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class Application_Model_General
{
	/**
	 * Execute zendRestMail use to send a mail.
	 * @static
	 *
	 * @param $ssMailTo 	= Receiver Email address.
	 * @param $ssMailFrom 	= Sender Email address.
	 * @param $ssSubject 	= Mail Subject.
	 * @param $ssMailBody 	= Mail Body
	 * @return boolean.
	 */
	public static function zendRestMail($ssMailTo, $ssMailFrom , $ssMailSubject , $ssMailBody)
	{
		if ($ssMailTo != '' && $ssMailFrom != '' && $ssMailSubject != '' && $ssMailBody != '')
		{
			$oMail = new Zend_Mail();
			$oMail->setBodyText($ssMailBody);
			$oMail->setFrom($ssMailFrom, 'Test');
			$oMail->addTo($ssMailTo, 'Guest');
			$oMail->setSubject($ssMailSubject);
			$oMail->send();
			return true;
		}
		else
			return false;
	}
	/**
	 * Execute get_Auth_Storage_Session use to store the session.
	 * @static
	 *
	 */
	public static function get_Auth_Storage_Session()
	{
		$storage = new Zend_Auth_Storage_Session();
		return $data = $storage->read();
	}
	 /*
	  @todo Execute generatePassword function to create a password.
	 * @param $snLength Integer Length of a password
	 * @return mix return new password.
	 */
	public static function generatePassword($snLength = 8)
	{
		// start with a blank password
		$smPassword = "";
		// define possible characters
		$smPossible = "0123456789abcdefghijklmnopqrstvwxyz";
		// set up a counter
		$snCounter = 0;
		// add random characters to password until length is reached
		while ($snCounter < $snLength)
		{
			// pick a random character from the possible ones
			$smChar = substr($smPossible, mt_rand(0, strlen($smPossible)-1), 1);
			// we don't want this character if it's already in the password
			if (!strstr($smPassword, $smChar))
			{
			   $smPassword .= $smChar;
			   $snCounter++;
			}
		}
        return $smPassword;
	}
}

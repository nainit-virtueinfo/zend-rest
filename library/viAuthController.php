<?php

/**
 * Model_Contacts
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class ViAuthController extends Zend_Controller_Action
{
	public function ViAuth()
	{
		if(!Zend_Auth::getInstance()->hasIdentity() && (@!isset($_REQUEST['bIsRest']) && @$_REQUEST['bIsRest'] != true))
		{
			if(@$_POST['submit'] != 'Login' && isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL'] != $_SERVER['HTTP_HOST'].'/login/index')
			{
				$this->bootstrap('Frontcontroller')
				->getResource('Frontcontroller')
				->registerPlugin(new CustomLibrary_Controller_Plugin_Auth());
			}
		}
		return true;
	}
}
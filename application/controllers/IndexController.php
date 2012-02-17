<?php
/**
 * IndexController Class File.
 * 
 * This file demonstrates information of index controller.
 * @package    Zend-rest
 * @subpackage application
 * @author     Rashmi Upadhyay
 * @version    SVN: $Id: IndexController.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class IndexController extends Zend_Controller_Action
{
	/**
	 * Function for initialize controller here.
	 */
	public function init()
	{
	}
	/**
	 * Function indexAction which redirect on index action of login controller.
	 */
    public function indexAction()
    {
		$this->_redirect('login/index');
    }
}

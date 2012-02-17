<?php
/**
 * RestserverController Class File.
 * 
 * This file demonstrates For Restserver.
 * @package    Zend-rest
 * @subpackage application
 * @author     Shashank Patel
 * @version    SVN: $Id: RestserverController.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class RestserverController extends Zend_Controller_Action
{
	/**
	 * Function for initialize controller here.
	 */
	public function init()
	{
		/* Initialize action controller here */
	}
	/**
	 * Function indexAction redirect on list action of restclient controller.
	 */
	public function indexAction()
	{
	}
	/**
	 * Function listAction for getting the list of all users.
	 */
	public function listAction()
	{
		$asUserDetail = Model_UsersTable::getUserslist();
		echo Zend_Json_Encoder::encode($asUserDetail);
		exit;
	}
	/**
	 * Function addeditAction for add and edit the user's information.
	 */
	public function addeditAction()
	{
		$asUser = Zend_Json_Decoder::decode($this->getRequest()->getParam('ssUserDetail'),Zend_Json::TYPE_ARRAY);
		
		if ($asUser['id_user'] == 0)
		{
			$oUser = new Model_Users();
			$oUser->saveUser($asUser);			
		}
		else
			$oUser = Model_UsersTable::updateUser($asUser);

		$asResponse = array('status'=>'success','massage'=>'Record added or edited successfully');
		echo Zend_Json_Encoder::encode($asResponse);
		exit;
	}
    /**
	 * Function deleteAction for delete the user.
	 */
	public function deleteAction()
	{
		$snIdUser = $this->getRequest()->getParam('id');
		$oMapper = Model_UsersTable::deleteUser($snIdUser);
		
		$asResponse = array('status'=>'success','massage'=>'Record deleted successfully');
		echo Zend_Json_Encoder::encode($asResponse);
		exit;
	}
	/**
	 * Function putAction for for putting the file from client to server.
	 */
	public function putAction()
	{
		$asResponse = array('status'=>'Ok','massage'=>'successfull execution of put method');
		$ssResponse= Zend_Json_Encoder::encode($asResponse);
		echo $ssResponse;
		exit;
	}
}

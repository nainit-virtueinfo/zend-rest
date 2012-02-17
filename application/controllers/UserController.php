<?php
/**
 * UserController Class File.
 * 
 * This file demonstrates For User's all information which doing 
 * addedit,listing and delete user.
 *
 * @package    Zend-rest
 * @subpackage application
 * @author     Rashmi Upadhyay,Shashank Patel
 * @version    SVN: $Id: UserController.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class UserController extends Zend_Controller_Action
{
	/**
	 * Function for initialize controller here.
	 */
    public function init()
    {
    }

	/**
	 * Function indexAction check session if thereis value in session redirect on list action of user controller else redirect on index of login action..
	 */
	public function indexAction()
	{
		$data = Application_Model_General::get_Auth_Storage_Session();
		if(is_object($data))
		  $this->_redirect('/user/list');
		else
		  $this->_redirect('/login/index');
	}
	
    /**
	 * Function listAction for getting the list of all users.
	 */
    public function listAction()
    {
		$asUserDetail = Model_UsersTable::getUserslist();
		
		$page=$this->_getParam('page',1);
		$paginator = Zend_Paginator::factory($asUserDetail);
		$paginator->setItemCountPerPage(5);
		$paginator->setCurrentPageNumber($page);
		$this->view->paginator=$paginator;
    }

	/**
	 * Function addeditAction for add and edit the user's information.
	 */
	public function addeditAction()
	{
		$oForm = new Application_Form_AddUsers();
		$oForm->submit->setLabel('Save');
		
		if($this->getRequest()->getParam('id') != '' && is_numeric($this->getRequest()->getParam('id')))
			unset($oForm->password);
		
		if($this->getRequest()->isPost())
		{
			if($oForm->isValid($this->getRequest()->getPost()))
			{
				if ($this->getRequest()->getParam('id_user') > 0)
					$oUser = Model_UsersTable::updateUser($oForm->getValues());
				else
				{
					$oUser = new Model_Users();
					$oUser->saveUser($oForm->getValues());
				}
				$this->_redirect('/user/list');
			}
		}
		elseif($this->getRequest()->getParam('id') != '')
		{
			$oUser = Model_UsersTable::findUser($this->getRequest()->getParam('id'));
			$oForm->populate($oUser[0]);
		}
		
		$this->view->snIdUser = ($this->getRequest()->getParam('id')) ? $this->getRequest()->getParam('id') : '';
		$this->view->form = $oForm;
	}
	
	/**
	 * Function deleteAction for delete the user.
	 */
	public function deleteAction()
	{
		if($this->getRequest()->getParam('id') != '')
		{
			$oMapper = Model_UsersTable::deleteUser($this->getRequest()->getParam('id'));
			$this->_redirect('/user/list');
		}
	}
}

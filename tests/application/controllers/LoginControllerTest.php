<?php

class LoginControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

	public function setUp()
	{
		$this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
		parent::setUp();
	}

	public function testIndexAction()
	{
	}
	
    public function testLogincheckAction()
	{
		$asLoginParams = array('action' => 'logincheck', 'controller' => 'login', 'module' => 'default');
		$asListParams = array('action' => 'list', 'controller' => 'user', 'module' => 'default');
		$this->request->setMethod('POST')
			 ->setPost(array('email' => 'sanjayrathod@virtueinfo.com','password'=>'sanjay12'));
		
		$this->dispatch('/login/logincheck');
		
		$this->assertRedirectTo('/user/list');
		$this->assertModule($asLoginParams['module']);
		$this->assertController($asLoginParams['controller']);
		$this->assertAction($asLoginParams['action']);
		
		$this->resetRequest()
			  ->resetResponse();
		$this->request->setMethod('GET')
			  ->setPost(array());
		$this->dispatch('/user/list');
		
		$this->assertModule($asListParams['module']);
		$this->assertController($asListParams['controller']);
		$this->assertAction($asListParams['action']);
		$this->assertQueryContentContains('h3','User List');
	}

    public function testLogoutAction()
    {
		$asLoginParams = array('action' => 'logincheck', 'controller' => 'login', 'module' => 'default');
		$asLogoutParams = array('action' => 'logout', 'controller' => 'login', 'module' => 'default');
		$this->request->setMethod('POST')
			 ->setPost(array('email' => 'sanjayrathod@virtueinfo.com','password'=>'sanjay12'));
		
		$this->dispatch('/login/logincheck');
		
		$this->assertRedirectTo('/user/list');
		$this->assertModule($asLoginParams['module']);
		$this->assertController($asLoginParams['controller']);
		$this->assertAction($asLoginParams['action']);
		
		$this->resetRequest()
			  ->resetResponse();
		$this->request->setMethod('GET')
			  ->setPost(array());
		$this->dispatch('/login/logout');
        $this->assertModule($asLogoutParams['module']);
		$this->assertController($asLogoutParams['controller']);
		$this->assertAction($asLogoutParams['action']);
		
		$this->resetRequest()
			  ->resetResponse();
		$this->request->setMethod('GET')
			  ->setPost(array());
		$this->dispatch('/login/index');
		$this->assertQueryContentContains('label','Email');
    }

	/*public function testForgotpasswordAction()
	{
		$asLoginParams = array('action' => 'logincheck', 'controller' => 'login', 'module' => 'default');
		$asForgotParams = array('action' => 'forgotpassword', 'controller' => 'login', 'module' => 'default');
		$this->request->setMethod('POST')
			  ->setPost(array('email' => 'sanjayrathod@virtueinfo.com','password'=>'sanjay12'));
		
		$this->dispatch('/login/logincheck');
		
		$this->assertRedirectTo('/user/list');
		
		$this->assertModule($asLoginParams['module']);
		$this->assertController($asLoginParams['controller']);
		$this->assertAction($asLoginParams['action']);
		
		$this->resetRequest()
			  ->resetResponse();
		
		$this->request->setMethod('POST')
			  ->setPost(array('email' => 'test@gmail.com'));
		$this->dispatch('/login/forgotpassword');
		
		$this->assertModule($asForgotParams['module']);
		$this->assertController($asForgotParams['controller']);
		$this->assertAction($asForgotParams['action']);
		//$this->assertRedirectTo('/login/forgotpassword');
	}*/
}

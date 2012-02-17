<?php

class RestclientControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
    }

    public function testListAction()
    {
        $asLoginParams = array('action' => 'logincheck', 'controller' => 'login', 'module' => 'default');
		$asListParams = array('action' => 'list', 'controller' => 'restclient', 'module' => 'default');
		
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
		$this->dispatch('/restclient/list');
		
		$this->assertModule($asListParams['module']);
		$this->assertController($asListParams['controller']);
		$this->assertAction($asListParams['action']);
		$this->assertQueryContentContains('h3','User List');
    }

    public function testAddUserAction()
    {
        $asLoginParams = array('action' => 'logincheck', 'controller' => 'login', 'module' => 'default');
		$asAddParams = array('action' => 'addedit', 'controller' => 'restclient', 'module' => 'default');
		$asListParams = array('action' => 'list', 'controller' => 'restclient', 'module' => 'default');
		
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
			->setPost(array('email' => 'shashank12.virtueinfo@gmail.com','password'=>'shashank','first_name'=>'sanjay','last_name'=>'Patel','city'=>'Rajkot'));
		
		$this->dispatch('/restclient/addedit');
		
		$this->assertRedirectTo('/restclient/list');
		$this->assertModule($asAddParams['module']);
		$this->assertController($asAddParams['controller']);
		$this->assertAction($asAddParams['action']);
		
		$this->resetRequest()
			->resetResponse();
		$this->request->setMethod('GET')
			->setPost(array());
		$this->dispatch('/restclient/list');
		
		$this->assertModule($asListParams['module']);
		$this->assertController($asListParams['controller']);
		$this->assertAction($asListParams['action']);
		$this->assertQueryContentContains('h3','User List');
	}

	public function testEditUserAction()
	{
		$asLoginParams = array('action' => 'logincheck', 'controller' => 'login', 'module' => 'default');
		$asAddParams = array('action' => 'addedit', 'controller' => 'restclient', 'module' => 'default');
		$asListParams = array('action' => 'list', 'controller' => 'restclient', 'module' => 'default');
		
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
			->setPost(array('id_user'=>2,'email' => 'shashank.virtueinfo@gmail.com','password'=>'shashank','first_name'=>'shashankUpdate','last_name'=>'PatelUpdate','city'=>'RajkotUpdate'));
		
		$this->dispatch('/restclient/addedit?id=2');
		
		$this->assertRedirectTo('/restclient/list');
		$this->assertModule($asAddParams['module']);
		$this->assertController($asAddParams['controller']);
		$this->assertAction($asAddParams['action']);
		
		$this->resetRequest()
			->resetResponse();
		$this->request->setMethod('GET')
			->setPost(array());
		$this->dispatch('/restclient/list');
		
		$this->assertModule($asListParams['module']);
		$this->assertController($asListParams['controller']);
		$this->assertAction($asListParams['action']);
		$this->assertQueryContentContains('h3','User List');
	}
    public function testDeleteAction()
    {
        $asLoginParams = array('action' => 'logincheck', 'controller' => 'login', 'module' => 'default');
		$asDeleteParams = array('action' => 'delete', 'controller' => 'restclient', 'module' => 'default');
		$asListParams = array('action' => 'list', 'controller' => 'restclient', 'module' => 'default');
		
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
		
		$this->dispatch('/restclient/delete?id=4');
		
		$this->assertRedirectTo('/restclient/list');
		$this->assertModule($asDeleteParams['module']);
		$this->assertController($asDeleteParams['controller']);
		$this->assertAction($asDeleteParams['action']);
		
		$this->resetRequest()
			  ->resetResponse();
		$this->request->setMethod('GET')
			  ->setPost(array());
		$this->dispatch('/restclient/list');
		
		$this->assertModule($asListParams['module']);
		$this->assertController($asListParams['controller']);
		$this->assertAction($asListParams['action']);
		$this->assertQueryContentContains('h3','User List');
    }

    public function testPutAction()
    {
        /*$params = array('action' => 'put', 'controller' => 'Restclient', 'module' => 'default');
        $url = $this->url($this->urlizeOptions($params));
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($params['module']);
        $this->assertController($params['controller']);
        $this->assertAction($params['action']);
        /*$this->assertQueryContentContains(
            'div#view-content p',
            'View script for controller <b>' . $params['controller'] . '</b> and script/action name <b>' . $params['action'] . '</b>'
            );*/
    }
}

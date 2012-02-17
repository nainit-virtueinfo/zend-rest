<?php
/**
 * Bootstrap.
 * 
 * This file is entry point of domain.
 * @package    Zend-rest
 * @subpackage application
 * @author     Arpita Rana.
 * @version    SVN: $Id: Bootstrap.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('CustomLibrary_');
    }
	
	/**
	 * Execute _initConstants.
	 */
	protected function _initConstants()
	{
		$registry = Zend_Registry::getInstance();
		$registry->constants = new Zend_Config( $this->getApplication()->getOption('constants'));	
	}
	/**
     * Execute _initinitAdminModuleAutoloader function to  autoload 
     * all models and form of admin module   
     */   
    protected function _initAdminModuleAutoloader()
    {
		    $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Admin_',
            'basePath'  => APPLICATION_PATH .'/modules/admin', 'resourceTypes' => array ('form' => array('path' => 'forms','namespace' => 'Form', ),
																						 'model'=> array( 'path' => 'models', 'namespace' => 'Model', ),)
       ));
        return $autoloader;
	}
	/**
     * Execute _initShoppingadminModuleAutoloader function to  autoload 
     * all models and form of admin module   
     */   
    protected function _initShoppingadminModuleAutoloader()
    {	
		    $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Shoppingadmin_',
            'basePath'  => APPLICATION_PATH .'/modules/shoppingadmin', 'resourceTypes' => array ('form' => array('path' => 'forms','namespace' => 'Form', ),
																						 'model'=> array( 'path' => 'models', 'namespace' => 'Model', ),)
       ));
       
		
        return $autoloader;
	}
	protected function _initViewHelpers()
    {
		$view = new Zend_View();	
		
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
		$view->jQuery()->addStylesheet($view->baseUrl .'/js/jquery/css/ui-lightness/jquery-ui-1.8.13.custom.css');
		$view->jQuery()->setLocalPath($view->baseUrl .'/js/jquery/js/jquery-1.5.1.min.js');
		$view->jQuery()->setUiLocalPath($view->baseUrl .'/js/jquery/js/jquery-ui-1.8.13.custom.min.js');
		$view->jQuery()->enable();
		$view->jQuery()->uiEnable();
		$view->addHelperPath("ZendX/Core/ViewHelper/Html", "ZendX_Core_ViewHelper_Html");
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

		return $view;
    }
	
	protected function _initDoctrine()
    {
        $this->getApplication()->getAutoloader()
                               ->pushAutoloader(array('Doctrine', 'autoload'));	
								spl_autoload_register(array('Doctrine', 'modelsAutoload')); // with the help of it generate sql and write in it.
		$doctrineConfig = $this->getOption('doctrine');		
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(Doctrine::ATTR_MODEL_LOADING,$doctrineConfig['model_autoloading']);
        $manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);
		Doctrine_Core::loadModels($doctrineConfig['models_path']);  // this loads all model classes.		
        $conn = Doctrine_Manager::connection($doctrineConfig['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
        return $conn;
    }
	/**
	* Execute _initConstants.
	*/
	protected function _initCheckAuth()
	{
	     //Zend_Controller_Request_Abstract
	     $this->bootstrap('FrontController');
	     $this->_front = $this->getResource('FrontController');
	    
	    $oRouter = $this->_front->getRouter();
        $oRequest = new Zend_Controller_Request_Http();
                 
        $oRouter->route($oRequest);
        $ssModuleName = $oRequest->getModuleName();
        $ssControllerName=$oRequest->getControllerName();
        $ssActionName=$oRequest->getActionName();
        
		$oAuth = Zend_Auth::getInstance();
        if (!$oAuth->hasIdentity())
        {
           if ($ssControllerName!='login') 
           {
               $oResponse = new Zend_Controller_Response_Http();
               $oResponse->setRedirect('/login/index');
               $this->_front->setResponse($oResponse);
           }
        }
	}	
	protected function _initLayoutHelper()
    {
        $this->bootstrap('frontController');
        $layout = Zend_Controller_Action_HelperBroker::addHelper(new ModuleLayoutLoader());
    }
	protected function _initLocale() 
	{
		if (Zend_Session::namespaceIsset('language') && !isset($_GET['lan']))
		 {
			$sess = new Zend_Session_Namespace('language');
			$ssLan=$sess->language;
	    }
		else
		{
			$ssLan=(isset($_GET['lan'])) ? $_GET['lan'] : 'en';
			$sess = new Zend_Session_Namespace('language');
			$sess->language=$ssLan;
		}
	    // define locale
		//$ssLan=(isset($_GET['lan']))?$_GET['lan']:'fr';
	    $locale = new Zend_Locale($ssLan);
		
	    // register it so that it can be used all over the website
	    Zend_Registry::set('Zend_Locale', $locale);
	}

	protected function _initTranslate()
	{
		// Get Locale
		$locale = Zend_Registry::get('Zend_Locale');
		

		// Set up and load the translations (there are my custom translations for my app)
		$translate = new Zend_Translate(
		                array(
		                    'adapter' => 'array',
		                    'content' => APPLICATION_PATH . '/languages/' . $locale . '.php',
		                    'locale' => $locale)
		);
	
		// Set up ZF's translations for validation messages.
		$translate_msg = new Zend_Translate(
		                array(
		                    'adapter' => 'array',
		                    'content' => APPLICATION_PATH . '/resources/languages/' . $locale . '/Zend_Validate.php',
		                    'locale' => $locale)
		);

		// Add translation of validation messages
		$translate->addTranslation($translate_msg);

		Zend_Form::setDefaultTranslator($translate);

		// Save it for later
		Zend_Registry::set('Zend_Translate', $translate);
		
	}
	
	public function _initRouter()
	{	
		// get instance of front controller 
		$frontController  = Zend_Controller_Front::getInstance();
		$route = new Zend_Controller_Router_Route('user/list/:id/',array('controller'=>'user','module'=>'default','action'=>'list','id'=>''));
       // add this route to the front controller
        $frontController->getRouter()->addRoute('user',$route);
		
		/*$frontController = Zend_Controller_Front::getInstance();
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/route.ini');
		$router = $frontController->getRouter();
		$router->addConfig($config,'routes');*/
	}
	
	
	/**
	 * Execute _initRoutes.
	 */
	/*protected function _initRoutes()
	{
        // Create instance for front controller
		$oController =  Zend_Controller_Front::getInstance();		
		// Get Router
		$oRouter = $oController->getRouter();
		$oController->setControllerDirectory('./application/controllers')
			    ->setRouter($oRouter)
			    ->setBaseUrl( '/'.SUB_FOLDER_PREFIX ); // set the base url!
	}*/
}
class ModuleLayoutLoader extends Zend_Controller_Action_Helper_Abstract
// looks up layout by module in application.ini
{
    public function preDispatch()
    {
        $bootstrap = $this->getActionController()
                          ->getInvokeArg('bootstrap');
        $config = $bootstrap->getOptions();
		
        $module = $this->getRequest()->getModuleName();
		/*if(isset($config[$module]))
			echo "<pre>";print_R($config[$module]);exit;
		if($config[$module] == 'shoppingadmin' && isset($config[$module]['resources']['layout']['layout'])*/
		
        if (isset($config[$module]['resources']['layout']['layout']))
		{
			$layoutScript = $config[$module]['resources']['layout']['layout'];  //layout name
			$layoutPath = $config[$module]['resources']['layout']['layoutPath']; //layout path application/modules/modulesname/layouts/scripts/
		    $this->getActionController()
		        	 ->getHelper('layout')
		       		 ->setLayout($layoutScript)
					 ->setLayoutPath($layoutPath);
        }
    }
}
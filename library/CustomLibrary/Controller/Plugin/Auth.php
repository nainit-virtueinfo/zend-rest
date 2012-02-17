<?php

class CustomLibrary_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    /**
     * Predispatch method to authenticate user
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
	 
        //user only to login for access to admin functions
        /*if ('admin' != $request->getModuleName()) {
            return;
        }
         
        if (App_Model_Users::isLoggedIn() && App_Model_Users::isAdmin()) {
            //user is logged in and allowed to access admin functions
            return;
        }*/
		if ('admin' == $request->getModuleName()) {
            return;
        }
         
        /**
         * User not logged in or not allowed to access admin ... redirect to login.
         * Note: if user is logged in but not authorised, we redirect to login
         * to allow user to login as a different user with the right permissions.
         */
		 Zend_Session::destroy(true);
	if($request->getActionName() != 'logincheck'){ 
			$request->setModuleName('default')
			->setControllerName('login')
			->setActionName('index');
			//->setDispatched(FALSE);
			header("Location:http://".$_SERVER['HTTP_HOST']."/login/index");
		}	
		
		
    }
} 

<?php
/**
 * LoginController Class File.
 * 
 * This file demonstrates the rich information about User's.
 * Function which is use to direct interation with database i.e. a function 
 * from which user is login and get password through mail. 
 *
 * @package    Zend-rest
 * @subpackage application
 * @author     Nainit Kalariya
 * @version    SVN: $Id: LoginController.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */

class LoginController extends Zend_Controller_Action
{
    public function __call($method, $args)
    {
        if ('Action' == substr($method, -6)) 
        {
            echo "Error generate";
            exit;
        }
        throw new Exception('Invalid method "'. $method. '" called',500);
    }

    /**
     * Function for initialize controller here.
     */
    public function init()
    {
    }

    /**
    * Function indexAction set the layout of user's login form.
    */
    public function indexAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(is_object($data))
            $this->_redirect('/user/list');
        $form = new Application_Form_Login();
        $this->view->form = $form;
        $this->_helper->_layout->setLayout('loginlayout');
    }

    /**
     * Function for logincheckAction which check user's given email and password.
     */
    public function logincheckAction()
    {
        $form = new Application_Form_Login();
        $this->view->form = $form;
        $request = $this->getRequest();
        if ($request->isPost())
        {
            if ($form->isValid($request->getPost()))
            {
                $adapter = $this->_getAuthAdapter($form->getValues());
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($adapter);
                if($result->isValid())
                {
                    $oSessionNamespace = new Zend_Session_Namespace($auth->getStorage()->getNamespace());
                    $oSessionNamespace->setExpirationSeconds(600);
                    $this->_redirect('/user/list');
                }
                else
                    $this->view->errorMessage = "Invalid username or password. Please try again.";	
            }
        }
        $this->render('index');
        $this->_helper->_layout->setLayout('loginlayout');
    }

    protected function _process($values)
    {
        // Get our authentication adapter and check credentials
        $adapter = $this->_getAuthAdapter();
        $adapter->setIdentity($values['email']); 
        $adapter->setCredential(MD5($values['password']));
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);
        //echo $result->isValid();
        //echo "<pre>";print_R($auth);exit;
        if($result->isValid()) 
        {
            // For registring session namespace
            $oSessionNamespace = new Zend_Session_Namespace($auth->getStorage()->getNamespace());
            // For setting session expire time
            //$oSessionNamespace->setExpirationSeconds(900);
            //$user = $adapter->getResultRowObject();           
            //$auth->getStorage()->write($user);
            //echo "<pre>";print_R($user);
            //$snNewGeneratedUniqueCode = Application_Model_General::generatePassword();
            //$amUserUnique = md5($snNewGeneratedUniqueCode.gettimeofday(true));
            //echo $amUserUnique;echo "<br>";
            //echo $user['id_user'];exit;
            //$this->getDbTable()->update(array('security_code'=>$amUserUnique), array('id_user = ?'=>$user->getIdUser()));
            return true;
        }
        else
            $this->view->errorMessage = "Invalid username or password. Please try again.";
    }

    /**
     * Function for doing get Authentication of given user's values.
     */
    protected function _getAuthAdapter($values)
    {
        $authAdapter = new ZendX_Doctrine_Auth_Adapter(Doctrine::getConnectionByTableName('Model_Users'));
        $encryptedPassword = MD5($values['password']);
        $authAdapter->setTableName('Model_Users u')
            ->setIdentityColumn('u.email')
            ->setCredentialColumn('u.password')
            ->setIdentity($values['email'])
            ->setCredential($encryptedPassword);
        return $authAdapter;
    }

    /**
     * Function logoutAction which clear Credential of user.
     */
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy(true);
        $this->_redirect('/index/index'); // back to login page
    }

    /**
     * Function forgotpasswordAction which send mail for forgotted password on given user's email address.
     */
    public function forgotpasswordAction()
    {
        $this->view->ssMessage = implode($this->_helper->flashMessenger->getMessages(),'.');
        $oForgotPasswordForm = new Application_Form_ForgotPassword();
        $this->view->forgotPasswordForm = $oForgotPasswordForm;
        if ($this->getRequest()->isPost())
        {
            $asUserFormDetail = $this->getRequest()->getPost();
            if ($oForgotPasswordForm->isValid($asUserFormDetail))
            {
                $saFormDetails = $oForgotPasswordForm->getValues();
                $saUserDetail = Doctrine::getTable('Model_Users')->checkEmailExist($saFormDetails['email']);

                if ($saUserDetail)
                {
                    $updatePassword = strtoupper(substr(sha1(uniqid(rand(),true)),0,6));
                    Doctrine_Query::create()
                         ->update("Model_Users u")
                         ->set("u.password", "md5(?)", array($updatePassword))
                         ->where("u.email = ?", array($this->_getParam('email')))
                         ->execute();
                    $ssMailBody = $this->view->getHelper('partial')->partial('login/forgotPassword.phtml',array('firstname'=>$saUserDetail[0]['first_name'],'password'=>$updatePassword));
                    $mailSubject = "Stream - forgot password notification";
                    Application_Model_General::zendRestMail($oForgotPasswordForm->getValue('email'),'test@noreply.com',$mailSubject,$ssMailBody);
                    $this->_helper->flashMessenger->addMessage('Your password is send successfully on your email address');
                    $this->_redirect('/login/forgotpassword');
                }
                else
                    $this->view->ssMessage = 'Email is not matched!!! Please try again';
            }
        }
    }

    public function changepasswordAction()
    {
        $changepasswordform = new Application_Form_Changepassword();
        $changepasswordform->submit->setLabel('Save');
        $this->view->form = $changepasswordform;

        if ($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            if ($changepasswordform->isValid($formData))
            {
                $storage = new Zend_Auth_Storage_Session();
                $data = $storage->read();
                $saFormDetails = $changepasswordform->getValues();
                $oldpassword=md5($saFormDetails['oldpassword']);
                $getpassword = Doctrine::getTable('Model_Users')->getPassword($data);
                if($getpassword[0]['password'] == $oldpassword)
                {
                    if(($formData['newpassword'])==($formData['confirmpassword']))
                    {
                        unset($formData['confirmpassword']);
                        $newpassword = Doctrine::getTable('Model_Users')->changePassword($saFormDetails,$data);
                        $this->view->errormessage ="Your password is  successfully changed";
                    }
                    else
                    {
                        $this->view->errormessage ="new password and confirm password does not match";
                    }
                }
                else
                {
                    $this->view->errormessage ="old password does not match to your original password";
                }
            }
        }
    }
}
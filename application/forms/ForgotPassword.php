<?php
/**
 * Application_Form_ForgotPassword Class File.
 * 
 * This ForgotPassword set the Elements for forgotpassword form
 * @package    Zend-rest
 * @subpackage application
 * @author     Arpita Rana
 * @version    SVN: $Id: Application_Form_ForgotPassword.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class Application_Form_ForgotPassword extends Zend_Form
{
	/**
	 * Execute init.
	 */
    public function init()
    {
		$this->setMethod('post');
		$this->addElement('text', 'email', array('label' => 'Email:','required' => true,'filters' => array('StringTrim'),
						  'validators' => array(array('StringLength',false, array(0, 50)),
						  array('NotEmpty',false,array('messages'=>array(Zend_Validate_NotEmpty::IS_EMPTY =>'Email can not be left blank',))),
						 ),));
		
        $this->addElement('submit', 'submit', array('ignore' => true,'label' => 'Login'));
    }
}


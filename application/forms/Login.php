<?php
/**
 * Application_Form_Login Class File.
 * 
 * This Login set the Elements for login form
 * 
 * @package    Zend-rest
 * @subpackage application
 * @author     Arpita Rana
 * @version    SVN: $Id: Application_Form_Login.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class Application_Form_Login extends Zend_Form
{
	/**
	 * executes init.
	 */
    public function init()
    {
		/* Form Elements & Other Definitions Here ... */
        $oEmailFormText = new Zend_Form_Element_Text("email");
        $oEmailFormText->setLabel("Email")
						->setRequired(true)
						->addFilter('StripTags')
						->addFilter('StringTrim')
						->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Username or password required')))
						->setAttrib('class', 'loginTextbox');

        $oPswFormText = new Zend_Form_Element_Password("password");
        $oPswFormText->setLabel('Password')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Username or password required')))
			  ->setAttrib('class', 'loginTextbox');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($oEmailFormText, $oPswFormText, $submit));    
     }
}


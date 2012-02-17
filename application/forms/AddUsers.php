<?php
/**
 * Application_Form_AddUsers Class File.
 * 
 * This AddUsers set the Elements for adduser form
 * 
 * @package    Zend-rest
 * @subpackage application
 * @author     Arpita Rana
 * @version    SVN: $Id: Application_Form_AddUsers.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class Application_Form_AddUsers extends Zend_Form
{
    /**
	 * executes init.
	 */
	 
	public function init()
	{
		$translator = $this->getTranslator();
		
		/* Form Elements & Other Definitions Here ... */
		$this->setMethod('POST');
		
		// Add id_user element.
		$this->addElement('hidden', 'id_user', array(
			'required'   => false,
			'filters'    => array('Int'),
		));
		
		// Add an email element.
		$this->addElement('text', 'email', array(
			'label'      =>  $translator->translate('Email'),
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				'EmailAddress',
			)
		));
		
		$this->addElement('password', 'password', array(
			'label'      => $translator->translate('Password'),
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				'NotEmpty',
			)
		));
		
		$this->addElement('text', 'first_name', array(
			'label'      => $translator->translate('First Name'),
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				'NotEmpty',
			)
		));
		
		$this->addElement('text', 'last_name', array(
			'label'      => $translator->translate('Last Name'),
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				'NotEmpty',
			)
		));
		
		$this->addElement('text', 'city', array(
			'label'      => $translator->translate('City'),
			'required'   => true,
			'filters'    => array('StringTrim'),
			'validators' => array(
				'NotEmpty',
			)
		));
		
		$this->addElement('submit', 'submit', array('label'    => $translator->translate('Save'), 'ignore'   => true,
		));
	}
}
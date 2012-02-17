<?php

class Application_Form_Changepassword extends Zend_Form
{
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->addElement('password','oldpassword',
                          array(
                                'label'    => 'Old Password',
                                'required' => true
                                ));
        $this->addElement('password','newpassword',
                          array(
                                'label'    => 'New Password',
                                'required' => true
                                ));
        $this->addElement('password','confirmpassword',
                          array(
                                'label'    => 'Confirm Password',
                                'required' => true
                                )); 
        $this->addElement("submit","submit",
                                       array(
                                            "label"     => "Save",
                                             "ignore"   =>  true));
    }
}


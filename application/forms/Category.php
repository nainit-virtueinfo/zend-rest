<?php

class Application_Form_Category extends Zend_Form
{
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
         $this->setMethod('POST');
        // Add id_user element.
        $this->addElement('hidden', 'id_category', array(
            'required'   => false,
            'filters'    => array('Int'),
        ));
        /*$oCategoryFormText = new Zend_Form_Element_Text("category");
        $oCategoryFormText->setLabel("category")
                        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Category required')))
                        ->setAttrib('class', 'loginTextbox');*/
        $this->addElement('text', 'category_name', array(
            'label'      => 'Category',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'NotEmpty',
            )
        ));
        $this->addElement('submit', 'submit', array('label'    => 'Save', 'ignore'   => true,
        ));
        //$this->addElements(array($oCategoryFormText));
    }
}


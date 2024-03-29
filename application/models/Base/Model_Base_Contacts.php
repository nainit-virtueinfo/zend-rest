<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Model_Contacts', 'doctrine');

/**
 * Model_Base_Contacts
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_contact
 * @property string $email
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Model_Base_Contacts extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('contacts');
        $this->hasColumn('id_contact', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '255',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}
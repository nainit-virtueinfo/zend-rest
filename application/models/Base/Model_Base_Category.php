<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Model_Category', 'doctrine');

/**
 * Model_Base_Category
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_category
 * @property string $category_name
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class Model_Base_Category extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('category');
        $this->hasColumn('id_category', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => '8',
             ));
        $this->hasColumn('category_name', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             'length' => '100',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}
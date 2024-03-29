<?php

/**
 * Model_Category
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Model_Category extends Model_Base_Category
{
    public function saveAndUpdateCategoryDetails($oCategory,$asCategoryDetail,$snIdCategory = '')
    {
        if($snIdCategory != '')
        {
            Doctrine_Query::create()
                    ->update("Model_Category MT")
                    ->set("MT.category_name", "?" ,$asCategoryDetail['category_name'])
                    ->where('MT.id_category =?', $snIdCategory)
                    ->execute();
            return true;
        }
        else
        {
            $oCategory->category_name = $asCategoryDetail['category_name'];
            $oCategory->save();
            return $oCategory->id_category;
        }
    }
}
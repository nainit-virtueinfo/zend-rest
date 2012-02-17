<?php
/**
 */
class Model_CategoryTable extends Doctrine_Table
{
    /**
    * For getting all product.
    *
    * @author Arpita Rana
    * @access public
    * @return array
    */
    public function getAllCategory($ssField='',$ssSort='',$ssSearchWord='')
    {
        $oQuery =  Doctrine_Query::create()
                            ->select("MC.*")
                            ->from("Model_Category MC")
                            ->orderBy('MC.'.$ssField." ".$ssSort);
                            if($ssSearchWord != '')
                                $oQuery->where("MC.category_name LIKE '%".$ssSearchWord."%'");
                            //->andWhere($this->oRequest->getParameter('ssSearchOption')." LIKE '%".trim(addslashes($this->oRequest->getParameter('ssSearchWord')))."%'");
        return $oQuery->fetchArray();
    }
    /**
    * For checking user's email exist checkUserEmailExist.
    *
    * @author Arpita Rana
    * @access public
    * @return array
    */
    public function checkCategoryExist($ssCategory)
    {
        try
        {
            return Doctrine_Query::create()
                            ->select("MU.*")
                            ->from("Model_Category MU")
                            ->where("MU.category_name =?",$ssCategory)
                            ->fetchArray();
        }
        catch( Exception $e )
        {
            echo $e->getMessage();
            return false;
        }
    }

    /**
    * For getting user detail by given id_user
    *
    * @author Arpita Rana
    * @access public
    * @return array
    */
    public function getCategoryDetailById($snIdCategory)
    {
        if($snIdCategory == '' || !is_numeric($snIdCategory)) return false;
        return Doctrine_Query::create()
                            ->select("MU.*")
                            ->from("Model_Category MU")
                            ->where("id_category =?",$snIdCategory)
                            ->fetchArray();
    }
    /**
    * @todo Execute deleteUser function for delete the particular user based on parameter.
    *
    * @param $snIdUser  Integer UserId.
    * @return type array or boolean.
    */
    public static function deleteCategory($snIdUser)
    {
        if($snIdUser == "" || !is_numeric($snIdUser))
            return false;
        return Doctrine_Query::create()
                    ->delete("Model_Category MU")
                    ->where("id_category = ?", $snIdUser)
                    ->execute();
    }
}
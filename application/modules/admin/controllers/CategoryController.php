<?php

class Admin_CategoryController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
		if($this->getRequest()->isPost())
		{
			$this->view->ssSortBy = ($this->getRequest()->getParam('ssSortBy') != '')?$this->getRequest()->getParam('ssSortBy'):'ASC';
			$ssField = ($this->getRequest()->getParam('ssSortOn') != '')?$this->getRequest()->getParam('ssSortOn'):'category_name';
			$this->view->ssSearchWord = ($this->getRequest()->getParam('ssSearchWord') != '')?trim(addslashes($this->getRequest()->getParam('ssSearchWord'))):'';
			$ssShowAll = ($this->getRequest()->getParam('ssShowall') != '')?$this->getRequest()->getParam('ssShowall'):'';
			$ssPage = ($this->getRequest()->getParam('page') != '')?$this->getRequest()->getParam('page'):1;
			
			if($ssShowAll != '')
				$asProductDetail = Doctrine::getTable('Model_Category')->getAllCategory($ssField,$this->view->ssSortBy);
			elseif($this->view->ssSearchWord != '')
				$asProductDetail = Doctrine::getTable('Model_Category')->getAllCategory($ssField,$this->view->ssSortBy,$this->view->ssSearchWord);			
			else
				$asProductDetail = Doctrine::getTable('Model_Category')->getAllCategory($ssField,$this->view->ssSortBy);			
			
			$page=$this->_getParam('page',1);
			$paginator = Zend_Paginator::factory($asProductDetail);
			$paginator->setItemCountPerPage(5);
			$paginator->setCurrentPageNumber($page);
			$this->view->paginator=$paginator;
			$this->_helper->layout->disableLayout();
			return $this->render('renderlist',array('paginator'=>$this->view->paginator,'ssSearchWord'=>$this->view->ssSearchWord,'ssSortBy'=>$this->view->ssSortBy));			
		}
		else
		{
			$asProductDetail = Doctrine::getTable('Model_Category')->getAllCategory('category_name','ASC');
			$page=$this->_getParam('page',1);
			$paginator = Zend_Paginator::factory($asProductDetail);
			$paginator->setItemCountPerPage(5);
			$paginator->setCurrentPageNumber($page);
			$this->view->paginator=$paginator;
		}
	}
    public function addeditAction()
    {
        // action body
		$oCategoryForm = new Application_Form_Category();
		$this->view->categoryform = $oCategoryForm;
		if($this->getRequest()->isPost())
		{
			if($oCategoryForm->isValid($this->getRequest()->getPost()))
			{
				$saFormDetails = $oCategoryForm->getValues();
				$oCategoryExist = Doctrine::getTable('Model_Category')->checkCategoryExist($saFormDetails['id_users']);
				if(count($oCategoryExist) > 0 && $this->getRequest()->getParam('id_category') == "")
					$this->view->errorMessage = "This category is already exist.";
				elseif($this->getRequest()->getParam('id_category') != "" && isset($oCategoryExist[0]) && $oCategoryExist[0]['id_category'] != $this->getRequest()->getParam('id_category'))
					$this->view->errorMessage = "This category is already exist.";
				else
				{
					$oCategory = new Model_Category();
					$snIdUser = $oCategory->saveAndUpdateCategoryDetails($oCategory,$saFormDetails,($this->getRequest()->getParam('id_category')!=0)?$this->getRequest()->getParam('id_category'):'');
					$this->_redirect('/admin/category/list');
				}
			}
		}
		elseif($this->getRequest()->getParam('id') != '')
		{
			$oCategory = Doctrine::getTable('Model_Category')->getCategoryDetailById($this->getRequest()->getParam('id'));
			$oCategoryForm->populate($oCategory[0]);
		}
		$this->view->param = ($this->getRequest()->getParam('id')) ? $this->getRequest()->getParam('id') : '';
    }
    /**
     * Function deleteAction for delete the user.
     */
    public function deleteAction()
    {
        if($this->getRequest()->getParam('id') != '')
        {
            $oMapper = Model_CategoryTable::deleteCategory($this->getRequest()->getParam('id'));
            $this->_redirect('/admin/category/list');
        }
    }
}
<?php
/**
 * RestclientController Class File.
 * 
 * This file demonstrates For Restclient.
 *
 * @package    Zend-rest
 * @subpackage application
 * @author     Shashank Patel
 * @version    SVN: $Id: RestclientController.class.php 20147 2009-07-13 11:46:57Z FabianLange $  
 */
class RestclientController extends Zend_Controller_Action
{	
	/**
	 * Function for initialize controller here.
	 */
	public function init()
	{
		$this->ssUri = Zend_Registry::getInstance()->constants->REST_SERVER_URI;
		//$this->data=Application_Model_General::get_Auth_Storage_Session();
    }
    
	/**
	 * Function indexAction redirect on list action of restclient controller.
	 */
	public function indexAction()
	{
		$this->_redirect('restclient/list');
	}
	
	/**
	 * Function listAction for getting the list of all users.
	 */
	public function listAction()
	{
		$asResponse = array();
		$client = new Zend_Http_Client($this->ssUri.'/list');
		$client->setParameterGet(array('bIsRest'  => true));
		$client->setConfig(array('timeout' => 30));
		$ssResponse = $client->request('GET');
		
		if($ssResponse->isSuccessful())
		{
			$ssResponseBody = $ssResponse->getBody();
			$asResponse = Zend_Json_Decoder::decode($ssResponseBody,Zend_Json::TYPE_ARRAY);
		}
		$this->view->users = $asResponse;
	}
	
	/**
	 * Function addeditAction for add and edit the user's information.
	 */
	public function addeditAction()
	{
		$oForm = new Application_Form_AddUsers();
		$oForm->submit->setLabel('Save');
		
		if($this->getRequest()->getParam('id') != '' && is_numeric($this->getRequest()->getParam('id')))
			unset($oForm->password);
		
		if($this->getRequest()->isPost())
		{
			if($oForm->isValid($this->getRequest()->getPost()))
			{
				$asUserDetail = $oForm->getValues();
				$ssUserDetail = Zend_Json_Encoder::encode($asUserDetail);
				
				$client = new Zend_Http_Client($this->ssUri.'/addedit');
				$client->setConfig(array('timeout' => 30));
				$client->setParameterPost(array('ssUserDetail'  => $ssUserDetail,'bIsRest' => true));
				
				$ssResponse = $client->request('POST');
				if($ssResponse->isSuccessful())
				{
					$ssResponseBody = $ssResponse->getBody();
					$asResponse = Zend_Json_Decoder::decode($ssResponseBody,Zend_Json::TYPE_ARRAY);
					
					if($asResponse['status'] == 'success')
						$this->_redirect('/restclient/list');
				}
			}
		}
		elseif($this->getRequest()->getParam('id') != '')
		{
			$oUser = Model_UsersTable::findUser($this->getRequest()->getParam('id'));
			$oForm->populate($oUser[0]);
		}
		
		$this->view->snIdUser = ($this->getRequest()->getParam('id')) ? $this->getRequest()->getParam('id') : '';
		$this->view->form = $oForm;
	}
	
	/**
	 * Function deleteAction for delete the user.
	 */
	public function deleteAction()
	{
		if($this->getRequest()->getParam('id') != '')
		{
			$snIdUser = $this->getRequest()->getParam('id');
			$client = new Zend_Http_Client($this->ssUri.'/delete?id='.$snIdUser.'&bIsRest='.true);
			$client->setConfig(array('timeout' => 30));
			$ssResponse = $client->request('DELETE');
			
			if($ssResponse->isSuccessful())
			{
				$ssResponseBody = $ssResponse->getBody();
				$asResponse = Zend_Json_Decoder::decode($ssResponseBody,Zend_Json::TYPE_ARRAY);
				
				if($asResponse['status'] == 'success')
					$this->_redirect('/restclient/list');
			}
		}
	}
	
	/**
	 * Function putAction for for putting the file from client to server.
	 */
	public function putAction()
	{
		$ssFileName= 'Woh_Bheege_Pal.mp3';
		
		$client = new Zend_Http_Client($this->ssUri.'/put?bIsRest='.true);
		
		$ssFilePath = $_SERVER['DOCUMENT_ROOT'].'/uploads/Woh_Bheege_Pal.mp3';
		$fp = fopen($ssFilePath, "r");
		$client->setRawData($fp, 'audio/mpeg3');
		
		echo $response = $client->request('PUT'); exit;
		
		if($response->isSuccessful())
		{
			echo "<pre>";
			// get header array
			$asHeader = $response->getHeaders();
			echo "Headers :";
			print_r($asHeader);
			echo "<br /><hr />";
			
			echo "Body :";
			$ssResBody = $response->getBody();
			$asResponse = Zend_Json_Decoder::decode($ssResBody,Zend_Json::TYPE_ARRAY);
			// OR $asResponse = Zend_Json_Decoder::decode($ssResBody);
			print_r($asResponse);
			echo "<br /><hr />";
		}
		else
			echo "error";
		
		exit;
	}
}

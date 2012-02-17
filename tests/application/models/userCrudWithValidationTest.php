<?php
/**
 * Tests_User
 *
 * Unit test case for User add ,edit ,delete and list
 *
 * @package zend-rest
 * @subpackage phpunit
 * @author     Rashmi Upadhyay
 *
 */

class Tests_UserCrudWithValidation extends PHPUnit_Framework_TestCase
{

	/**
	* enter user
	* @var array
	* @access private
	*/
	private $addblankuser = array();

	/**
	* enter user
	* @var array
	* @access private
	*/
	private $adduser = array('first_name'=>'rashmi','last_name'=>'rashmi','email'=>'virtueinfo.com','password'=>'0ce4ff80e8a029c19abaa08a2019a980','city'=>'ahmedabad');
	
	/**
	* update user
	* @var array
	* @access private
	*/
	private $updateuser = array('id_user'=>'5','first_name'=>'rashmi','last_name'=>'upadhyay','email'=>'rashmi@virtueinfo.com','password'=>'0ce4ff80e8a029c19abaa08a2019a980','city'=>'ahmedabad');	
	
	/**
	* delete user
	* @var int
	* @access private
	*/
	private $deleteiduser = 5;

	/**
	* find user
	* @var int
	* @access private
	*/
	private $findiduser = 1;
	
	/**
	* For add blank user in user table
	* When user array  is not provided
	* @author Rashmi Upadhyay
	* @access public 
	*/

	/**
	* For add user detail
	* When no parameter given
	* @author     Shashank Patel
	* @access public
	*/
	public function testAddUserIfNoParameterGiven()
	{
		$user = new Model_Users();
		$user->saveUser();
		$this->assertFalse(false ,"No parameter given for adding new record");
	}

	/**
	* For add user detail
	* When required field given blank
	* @author     Shashank Patel
	* @access public
	*/
	public function testAddUserIfRequireFieldGivenBlank()
	{
		$asBlankUser = array('first_name'=>'sdsa','last_name'=>'sdasd','email'=>'sdasd','password'=>'sdsadsa','city'=>'Ahmedabad');
		
		$asValidator = array('Zend_Validate_NotEmpty');
		$oCustomDataValidator = new ZendX_Custom_Data_Validator();
		$bValid = true;

		foreach($asBlankUser as $ssField => $ssFieldValue)
		{
			var_dump($oCustomDataValidator->customAddValidatorAndValidateValue($ssFieldValue,$asValidator));
			if($oCustomDataValidator->customAddValidatorAndValidateValue($ssFieldValue,$asValidator))
			{
				echo $ssLastField = $ssField;
				$bValid = false;
				break;
			}
			else
				continue;
		}
		var_dump($bValid);exit;
		//echo $ssLastField."'s Value is required and can't be empty";
		$this->assertFalse(true ,"No parameter given for adding new record");
	}

	/**
	* For add user in user table
	* When user array  is  provided
	* @author Rashmi Upadhyay
	* @access public 
	*/
	
    public function testaddUserSuccessfully()
    {	
        $user = new Model_Users();
        $user->saveUser($this->adduser);
		$this->assertTrue(true ,"Record add successfully");
    }
 	
	/**
	* For update user in user table
	* When user array  is not provided
	* @author Rashmi Upadhyay
	* @access public 
	*/
	
	public function testtrytoUpdateUserwithBlankData()
    {	
        Model_UsersTable ::updateUser('');
		$this->assertFalse(false ,"Record not update because of not pass data");
    }
	
	/**
	* For update user in user table
	* When user array  is provided
	* @author Rashmi Upadhyay
	* @access public 
	*/
	
	public function testUpdateUserSuccessfully()
    {	
        Model_UsersTable ::updateUser($this->updateuser);
		$this->assertTrue(true ,"Record update successfully");
    }
	
	/**
	* For list users
	* @author Rashmi Upadhyay
	* @access public 
	*/
	
	public function testlistUsers()
	{
		$result = Model_UsersTable::getUserslist();
		$this->assertType('array' , $result);	
	}
	
	/**
	* For delete user
	* When id user not provided
	* @author Rashmi Upadhyay
	* @access public 
	*/
	
	public function testdeleteUsersNotSuccessfully()
	{
		$result = Model_UsersTable::deleteUser('');
		$this->assertFalse(false , 'user not delete successfully');	
	}
	
	/**
	* For delete user
	* When id user provided
	* @author Rashmi Upadhyay
	* @access public 
	*/
	
	public function testdeleteUsersSuccessfully()
	{
		$result = Model_UsersTable::deleteUser($this->deleteiduser);
		$this->assertTrue(true , 'user delete successfully');	
	}
	
	/**
	* For find user
	* When id user not provided
	* @author Punam Detharia
	* @access public 
	*/
	
	public function testtrytoFindUserWithBlankId()
	{
		$result = Model_UsersTable::findUser('');
		$this->assertFalse(false , 'user not  found because of not pass id');	
	}
	/**
	* For find user
	* When id user  provided
	* @author Punam Detharia
	* @access public 
	*/
	
	public function testtrytoFindUserWithId()
	{
		$result = Model_UsersTable::findUser($this->findiduser);
		$this->assertType('array' , $result);	
	}

}	
?>

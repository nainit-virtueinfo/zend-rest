<?php
class Common
{
	/**
	* Write to a file
	*
	* @param string $string
	* @return string Some return message
	*/
	public function sayHello($name)
	{
		$message = 'Hello '.$name;
		return $message;
	}
}
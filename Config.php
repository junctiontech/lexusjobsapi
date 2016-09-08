<?php
class Config
{
	/* protected  $hostName;
	protected $userName;
	protected $password;
	protected $databaseName;
	
	if(mysqli_connect_errno())
	{
		con not 
	}
	else
	{
		connection stablish
	}
	
	
	 */
	function connection()
	{
		$connection=mysqli_connect('localhost','root','initial1$','jobportal');
		if(isset($connection))
		{
			return $connection;
		}
	}
	
	function projectCredential()
	{
		
	}
}

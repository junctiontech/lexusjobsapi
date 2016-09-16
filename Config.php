<?php
class Config
{
	
	  static private $con='';
	  private function __construct()
	  {
			 error_reporting(0);
	  }
	
  	  function connection()
  	 {
  	 	  $con=mysqli_connect('localhost','root','','jobportal');
		  if (mysqli_connect_error()) 
		  {
				return 0;
		  }
		else{ return $con; }
  	 	  
  	 }
  	 
  	 static function getConnection()
  	 {
  	 	if(self::$con=='')
  	 	{
  	 		//echo 'new';
  	 		$obj=new Config();
  	 		self::$con=$obj->connection();
  	 		return self::$con;
  	 	}
  	 	else
  	 	{
  	 		//echo 'already';
  	 		return self::$con;
  	 	}
  	 }
}


/*
 * function connection()
	{
		try
		{
			$conn=new PDO("mysql:host=localhost;dbname=JOBPORTAL",'root','');
			$connection=$conn->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::ATTR_ERRMODE);
			return $connection;
		}
		catch (PDOException $e)
		{
			$e->getMessage('Connection Faild'.$e->getMessage());
		}
	}
*/
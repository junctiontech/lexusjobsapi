<?php
include('Config.php');
abstract class sqlfile
{
	function get($tableName,$filter)
	{	
		$i=1;
		$fields='';
		$result=array();
		$connection=Config::getConnection();
		if(isset($connection) && !empty($connection) && $connection!==0)
		{
			if(isset($filter) && !empty($filter) && count($filter)>0)
			{
				foreach($filter as $colum=>$value)
				{
					if($i<count($filter))
					{
						$operator='and';
					}
					else
					{
						$operator='';
					}
					$i++;
					$fields.="$colum='$value' $operator ";
				}
				$sql="select * from $tableName where $fields";//echo $sql;die;
				$query=mysqli_query($connection,$sql);
				if(mysqli_num_rows($query)>0)
				{
					foreach($query as $list)
					{
						$result[]=$list;
					}
					$response=array('code'=>'200','message'=>'Valid Id','result'=>$result);return $response;
				}
				else 
				{
					$response=array('code'=>'401','message'=>'Invalid Id','result'=>mysqli_error($connection));return $response;
				}
			}
			else
			{
				$sql="select * from $tableName";
				$query=mysqli_query($connection,$sql);
				if(mysqli_num_rows($query)>0)
				{
					foreach($query as $list)
					{
						$result[]=$list;
					}
					$response=array('code'=>'200','message'=>'Valid Id','result'=>$result);return $response;
				}
				else 
				{
					$response=array('code'=>'401','message'=>'Unauthorized Request','result'=>mysqli_error($connection));return $response;
				}
			}
		}
		else
		{
			$response=array('code'=>'502','message'=>'Bad Gateway or Connection Failed','result'=>mysqli_error($connection));return $response;
		}
		
	}
	
	
	function post($table,$data)
	{	
		$i=1;
		$fields='';
		$colums='';
		$result=array();
		$connection=Config::getConnection();
		if(isset($connection) && !empty($connection) && $connection!==0)
		{
			foreach($data as $colum=>$values)
			{
				if($i<count($data))
				{
					$comma=',';
				}
				else
				{
					$comma='';
				}
				$colums.="$colum$comma";
				$fields.="'$values'$comma";
				$i++;
			}
			$sql="INSERT INTO $table ($colums) Values ($fields)";
			if(mysqli_query($connection,$sql))
			{
				$lastInsertId=mysqli_insert_id($connection);
				$response=array('code'=>'201','message'=>'Insert Successfully','result'=>$lastInsertId);return $response;
			}
			else
			{ 
				$response=array('code'=>'401','message'=>'Not Insert','result'=> mysqli_error($connection));return $response; 
			}
		}
		else
		{
			$response=array('code'=>'502','message'=>'Bad Gateway or Connection Failed','result'=>mysqli_error($connection));return $response;
		}
	}
	
	function put($table,$data,$filterData)
	{	
		$i=1;
		$j=1;
		$field='';
		$filter='';
		$result=array();
		$connection=Config::getConnection();
		if(isset($connection) && !empty($connection) && $connection!==0)
		{
				foreach($data as $colum=>$value)
				{	
						if($i<count($data))
						{
							$comma=',';
						}
						else
						{
							$comma='';
						}
						$field.="$colum='$value'$comma";
						$i++;
				}
				foreach($filterData as $colum=>$value)
				{
						if($j<count($filterData))
						{
							$comma=',';
						}
						else
						{
							$comma='';
						}
						$filter.="where $colum='$value'$comma";
						$j++;
				}
				$sql="UPDATE $table SET $field $filter";
				$query=mysqli_query($connection,$sql);
				if($query)
				{
						$response=array('code'=>'200','message'=>'Update Successfully','result'=>$data);return $response;
				}
				else
				{
						$response=array('code'=>'401','message'=>'Unauthorized Request','result'=>mysqli_error($connection));return $response;
				}
		}
		else
		{
			$response=array('code'=>'502','message'=>'Bad Gateway or Connection Failed','result'=>mysqli_error($connection));return $response;
		}
	
	}
	
	function delete($tableName,$filter)
	{
		$i=1;
		$field='';
		$result=array();
		$connection=Config::getConnection();
		if(isset($connection) && !empty($connection) && $connection!==0)
		{	
			foreach($filter as $colum=>$value)
			{
				if($i<count($filter))
				{
					$operator='and';
				}
				else
				{
					$operator='';
				}
				$field.="$colum='$value'$operator";
				$i++;
			}
			$sql="DELETE from $tableName where $field";
			$query=mysqli_query($connection,$sql);//echo $query;die;echo 
			if($query)
			{
				$response=array('code'=>'200','message'=>'Delete Successfully','result'=>$filter);return $response;
			}
			else 
			{
				$response=array('code'=>'401','message'=>'Unauthorized Request','result'=>mysqli_error($connection));return $response;
			}
		}
		else
		{
			$response=array('code'=>'502','message'=>'Bad Gateway or Connection Failed','result'=>mysqli_error($connection));return $response;
		}
	}
	
	
	 abstract function search($param);
}
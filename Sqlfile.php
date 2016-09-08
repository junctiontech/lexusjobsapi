<?php
include('Config.php');
class sqlfile extends Config
{
	function get($tableName,$filter)
	{	
		$i=1;
		$fields='';
		$result=array();
		$connection=$this->connection();
		if(isset($connection))
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
				if(mysqli_num_rows($query)!==0)
				{
					foreach($query as $list)
					{
						$result[]=$list;
					}
					$response=array('code'=>'200','message'=>'Valid Id','result'=>$result);return $response;
				}
				else 
				{
					$response=array('code'=>'400','message'=>'Invalid Id','result'=>$result);return $response;
				}
			}
			else
			{
				$sql="select * from $tableName";
				$query=mysqli_query($connection,$sql);
				if(mysqli_num_rows($query)!==0)
				{
					foreach($query as $list)
					{
						$result[]=$list;
					}
					$response=array('code'=>'200','message'=>'Valid Id','result'=>$result);return $response;
				}
				else 
				{
					$response=array('code'=>'401','message'=>'Unauthorized Request','result'=>$result);return $response;
				}
			}
		}
	}
	
	
	function post($table,$data)
	{	
		$i=1;
		$fields='';
		$colums='';
		$result=array();
		$connection=$this->connection();
		if(isset($connection))
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
			mysqli_query($connection,$sql);
			$lastInsertId=mysqli_insert_id($connection);
			if(isset($lastInsertId) && $lastInsertId!==0)
			{
				$response=array('code'=>'201','message'=>'Insert Successfully','result'=>$lastInsertId);return $response;
			}
			else 
			{
				$response=array('code'=>'401','message'=>'Unauthorized Request','result'=>$result);return $response;
			}
			
		}
	}
	
	function put($table,$data,$filterData)
	{	
		$i=1;
		$j=1;
		$field='';
		$filter='';
		$result=array();
		$connection=$this->connection();
		if(isset($connection))
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
				if(isset($query))
				{
						$response=array('code'=>'200','message'=>'Update Successfully','result'=>$result);return $response;
				}
				else
				{
						$response=array('code'=>'401','message'=>'Unauthorized Request','result'=>$result);return $response;
				}
		}
	
	}
	
	function delete($tableName,$filter)
	{
		$i=1;
		$field='';
		$result=array();
		$connection=$this->connection();
		if(isset($connection))
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
			if(isset($query)!== 0)
			{
				$response=array('code'=>'200','message'=>'Delete Successfully','result'=>$result);return $response;
			}
			else 
			{
				$response=array('code'=>'401','message'=>'Unauthorized Request','result'=>$result);return $response;
			}
		}
	}
}
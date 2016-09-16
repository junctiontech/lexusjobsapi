<?php 
include("Sqlfile.php");
class CandidateSearchApi extends sqlfile
{
	private $table="resumepost";
	function search($param)
	{	
		$result=array();
		$connection=Config::getConnection();
		if(isset($connection)&&!empty($connection))
		{
			$filter=str_replace('_',' ',$param);
			$sql="select * from $this->table where $filter";//echo $sql;die;
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
				$response=array('code'=>'400','message'=>'Invalid Id','result'=>mysqli_error($connection));return $response;
			}
		}
		else
		{
			$response=array('code'=>'502','message'=>'Bad Gateway or Connection Failed','result'=>mysqli_error($connection));return $response;
		}
	}
}
if(isset($_SERVER['REQUEST_METHOD']) && !empty($_SERVER['REQUEST_METHOD']))
{
	$instance= new CandidateSearchApi();
	$method=$_SERVER['REQUEST_METHOD'];//echo $method;die;
	if(strcasecmp($method, 'get')==0)
	{	//echo'saffas';//die;
		$param=$_GET['value'];//echo $param;die;
		$response=$instance->search($param);
		echo json_encode($response);
	}
}
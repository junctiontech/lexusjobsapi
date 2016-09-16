<?php
include("Sqlfile.php");
class masterEntryApi extends sqlfile
{
	private $table='masterentry';
	function getApi($param)
	{	
		$filter=array();
		$result=array();
		$result=json_decode($param,true);//print_r($result['filter']);//echo count($result['filter']);die;
		if(isset($result['filter']) && count($result['filter'])>0)
		{
			$filter= $result['filter'];
		}
		$response=$this->get($this->table,$filter);//print_r($response);die;
		return $response;
	}
	
	function postApi($param)
	{	
		//$table= $param['table']['table'];
		$data=$param['data'];
		$response=$this->post($this->table,$data);//print_r($fields);die;
		return $response;
	}
	
	function putApi($param)
	{	
		$var=str_replace("_", " ", $param);
		$result=json_decode($var,true);//return $result;die;
		$data=$result['data'];
		$filter=$result['filter'];
		$response=$this->put($this->table,$data,$filter);
		return $response;
	}
	
	function deleteApi($param)
	{
		$result=json_decode($param,true);
		$filter= $result['filter'];
		$table='masterentry';
		$response=$this->delete($table,$filter);//print_r($response);die;
		return $response;
	}
	
	function search($param)
	{
		
	}
}
//echo 'fdsfds';die;
if(isset($_SERVER['REQUEST_METHOD']) &&!empty($_SERVER['REQUEST_METHOD']))
{	
	$instance= new masterEntryApi();
	$method=$_SERVER['REQUEST_METHOD'];
	if(strcasecmp($method, 'get')==0)
	{	
		$param=$_GET['data'];
		$response=$instance->getApi($param);
		echo json_encode($response);
	}
	elseif(strcasecmp($method, 'post')==0)
	{
		$param=$_POST['data'];
		$response=$instance->postApi($param);
		echo json_encode($response);die;
	}	
	elseif(strcasecmp($method, 'put')==0)
	{
		$param=$_GET['data'];
		$response=$instance->putApi($param);
		echo json_encode($response);
	}
	elseif(strcasecmp($method, 'delete')==0)
	{
		$param=$_GET['data'];
		$response=$instance->deleteApi($param);
		echo json_encode($response);
	}
	else 
	{
		$response=array('code'=>'400','result'=>'unknown method');echo json_encode($response);
	}
}


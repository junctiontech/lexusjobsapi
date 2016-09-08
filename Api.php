<?php
include("Sqlfile.php");
class Api extends sqlfile
{
	function getApi($param)
	{	
		$filter=array();
		$result=array();
		$result=json_decode($param,true);//print_r($result['filter']);//echo count($result['filter']);die;
		if(isset($result['filter']) && count($result['filter'])>0)
		{
			$filter= $result['filter'];
		}
		$table= $result['table']['table'];
		$response=$this->get($table,$filter);//print_r($response);die;
		return $response;
	}
	
	function postApi($param)
	{	
		$table= $param['table']['table'];
		$data=$param['data'];
		$response=$this->post($table,$data);//print_r($fields);die;
		return $response;
	}
	
	function putApi($param)
	{	
		$result=json_decode($param,true);
		$table=$result['table']['table'];
		$data=$result['data'];
		$filter=$result['filter'];
		$response=$this->put($table,$data,$filter);//print_r($response);
		return $response;
	}
	
	function deleteApi($param)
	{
		$result=json_decode($param,true);//print_r($result['filter']);die;
		$filter= $result['filter'];
		$table=$result['table']['table'];
		$response=$this->delete($table,$filter);//print_r($response);die;
		return $response;
	}
}
if(isset($_SERVER['REQUEST_METHOD']) &&!empty($_SERVER['REQUEST_METHOD']))
{	
	$instance= new Api();
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
		echo json_encode($response);
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


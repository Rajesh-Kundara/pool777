<?php
include ('../config.php');
$response=array();
$response['tipsList']=array();
//if(!empty($_POST['userId'])){
	$sql = "SELECT * FROM tips WHERE status='A'";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$data['id']=$row['id'];
				$data['text']=$row['text'];
				$data['imageUrl']=$row['imageUrl'];
				$data['date']=$row['date'];
				$data['imageVisible']=($row['imageStatus']==="A")?"1":"0";
				
				array_push($response["tipsList"],$data);
			}
			$response['success'] =1;
			$response["message"] = "Data list loading successful.";				
	}else{
		$response['success'] =0;
		$response["message"] = "Something went wrong.".$stmt->error();  
	}  
	/*}else{
		$response['success'] =0;
		$response["message"] = "Parameters missing!.";	
	}*/	
	
	//temp
	if(empty($_POST['versionCode'])){
		$response["tipsList"]=array();
		$data['id']="0";
		$data['text']="Please update the app from Play Store to get Tips.";
		$data['imageUrl']="";
		$data['date']=date('Y-m-d H:i:s');
		$data['imageVisible']="0";
		
		array_push($response["tipsList"],$data);
		$response['success'] =1;
		$response["message"] = "New update for CrickExpert tips is available on Play Store.";
	}
	echo json_encode($response);			
?>
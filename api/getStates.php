<?php
include ('../common/config.php');
$response=array();
$response['statesList']=array();
if(!empty($_POST['countryId'])){
	$sql = "SELECT * FROM states WHERE country_id='".$_POST['countryId']."' AND name!=''";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$data=array();
				$data['id']=$row['id'];
				$data['name']=$row['name'];
				
				array_push($response['statesList'],$data);
			} 
			$response['success'] =1;
			$response["message"] = "Data list loading successful.";				
	}else{  
		$response['success'] =0;
		$response["message"] = "Something went wrong.".$stmt->error();  
	} 
	}else{
		$response['success'] =0;
		$response["message"] = "Parameters missing!.";	
	}
		
	echo json_encode($response);			
?>
<?php
include ('../common/config.php');
$response=array();
$response['matchesList']=array();
if(!empty($_POST['week'])){
	$sql = "SELECT * FROM matches WHERE  status='A'";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$data=array();
				$data['id']=$row['id'];
				$data['homeTeam']=$row['homeTeam'];
				$data['awayTeam']=$row['awayTeam'];
				
				array_push($response['matchesList'],$data);
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
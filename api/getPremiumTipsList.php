<?php
include ('../config.php');
$response=array();
$response['tipsList']=array();
//if(!empty($_POST['userId'])){
	$sql = "SELECT * FROM tips_premium WHERE status='A'";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$data['id']=$row['id'];
				$data['text']=$row['text'];
				$data['imageUrl']="";
				$data['date']=$row['date'];
				$data['imageVisible']="0";
				
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
		
	echo json_encode($response);			
?>
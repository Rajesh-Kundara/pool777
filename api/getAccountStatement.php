<?php
include ('../common/config.php');
$response=array();
$response['statementList']=array();
if(!empty($_POST['userId'])){
	$sql = "SELECT * FROM balance WHERE userId=".$_POST['userId']." AND status='A' ORDER BY date DESC";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$data=array();
				$data['id']=$row['id'];
				$data['date']=$row['date'];
				$data['type']=$row['type'];
				$data['description']=($row['description']==null)?"N/A":$row['description'];
				$data['amount']=$row['amount'];
				$data['ref']=$row['ref'];
				
				array_push($response['statementList'],$data);
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
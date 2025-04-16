<?php
include('../common/config.php');
if(!empty($_POST['amount'])){
	$response=array();
	
	if(!empty($_POST['userId'])){
		$userId=$_POST['userId'];
	}else{
		$userId=$_SESSION['id'];
	}
	$amount=$_POST['amount'];
	
	$sql = "INSERT INTO withdraw_requests (userId,amount)
			VALUES('$userId','$amount')";  

	$stmt = $connection->query($sql);  
	if ( $stmt )  
	{  
		$response['success'] = "1";
		$response["message"] = "Your request submitted. We will get back to you very soon.";
	}   
	else{  
		$response['success'] ="0";
		$response["message"] = "Error: ".$stmt->error();
	} 
}else{
	$response['success'] ="0";
	$response["message"] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
<?php
include('../common/config.php');
if(!empty($_POST['userId']) && !empty($_POST['amount'])){
	$response=array();
	
	$userId=$_POST['userId'];
	$amount=$_POST['amount'];
	$remark=$_POST['remark'];
	
	$sql = "INSERT INTO balance (userId,amount,date,insertDate,type,remark)
			VALUES('$userId','$amount',NOW(),NOW(),'M', '$remark')";  
	$stmt = $connection->query($sql);  
	// $insertId = mysql_insert_id();
	if ( $stmt )  
	{
		$response['success']="1";
		$response["message"] = "Data saved succefully.";
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
<?php
include('../common/config.php');
if(!empty($_POST['fullName']) && !empty($_POST['email']) && !empty($_POST['description'])){
	$response=array();
	
	if(!empty($_POST['userId'])){
		$userId=$_POST['userId'];
	}else{
		$userId=$_SESSION['id'];
	}
	$fullName=$_POST['fullName'];
	$email=$_POST['email'];
	$countryCode=$_POST['countryCode'];
	$phone=$countryCode.$_POST['phone'];
	$countryId=$_POST['countryId'];
	$purpose=$_POST['purpose'];
	$description=mysql_escape_string($_POST['description']);
	
	$sql = "INSERT INTO contacts (userId,name,email,phone,country,purpose,description)
			VALUES('$userId','$fullName','$email','$phone','$countryId','$purpose','$description')";  

	$stmt = $connection->query( $sql);  
	if ( $stmt )  
	{  
		$response['success'] = "1";
		$response["message"] = "Thanks for contacting us. We will get back to you very soon.";
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
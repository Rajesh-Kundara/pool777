<?php
include('../config.php');
if(!empty($_POST['name']) && !empty($_POST['description'])){
	$response=array();
	$isUpdate=false;
	if(!empty($_POST['idForUpdate'])){
		$isUpdate=true;
		$idForUpdate=$_POST['idForUpdate'];
	}
	$name=$_POST['name'];
	$description=$_POST['description'];
    $status=$_POST['status'];
	$matchDate=$_POST['matchDate'];
	$closeDate=$_POST['closeDate'];
    $minStack=$_POST['minStack'];
	$minSelectedNo=$_POST['minSelectedNo'];
	//for week (SELECT WEEK('$matchDate',1))
	if($isUpdate){
		$sql = "UPDATE bankers set name='$name', minSelectedNo='$minSelectedNo',openDate='$matchDate',closeDate='$closeDate',minStack='$minStack', description ='$description',status='$status' WHERE id='$idForUpdate'";  
	}else{
		 $sql = "INSERT INTO bankers (name,openDate,closeDate,minStack,minSelectedNo,description,status)
				VALUES('$name','$matchDate','$closeDate','$minStack','$minSelectedNo','$description','$status')";  
	
	}

	$stmt = $connection->query($sql);  
	if ( $stmt )  
	{
     
		$response['success']="1";
		$response["message"] = "Data saved succefully.";
	
		
	}   
	else{  
		$response['success'] ="0";
		$response["message"] = "Error: ".$sql;
	}    
	
}else{
	$response['success'] ="0";
	$response["message"] = "Please all selected fields.";
}

echo json_encode($response);
?>
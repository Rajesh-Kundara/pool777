<?php
include ('../common/config.php');
$response=array();
$response['countryList']=array();
$sql = "SELECT * FROM countries ORDER BY name ASC";
$stmt = $connection->query($sql);

if ( $stmt ){
	while( $row = $stmt->fetch_assoc()()){
		$data=array();
		$data['id']=$row['id'];
		$data['name']=$row['name'];
		
		array_push($response['countryList'],$data);
	} 
	$response['success'] =1;
	$response["message"] = "Data list loading successful.";				
}else{
	$response['success'] =0;
	$response["message"] = "Something went wrong.".$stmt->error();  
} 
	
echo json_encode($response);			
?>
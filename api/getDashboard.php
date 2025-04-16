<?php
include ('../config.php');
$response=array();
$response['dashboardData']=array();
	$sql = "SELECT * FROM greetings order by id desc limit 1";
	$stmt = $connection->query($sql);
	
	$response['greetingText']="Welcome!";
	$response['adImageUrl']="";
	$response['adText']="";
	$response['adRedirectUrl']="";
	//echo mysql_error();
	if ( $stmt ){ 
		while( $row = $stmt->fetch_assoc()){ 
			$response['greetingText']=$row['text'];
		}
	}else{
		$response['error']="Error fetching data".$stmt->error();
	}
	
	$sql = "SELECT * FROM ads order by id desc limit 1";
	$stmt3 = $connection->query($sql);
	
	//echo mysql_error();
	if ( $stmt3 ){ 
		while( $row = $stmt3->fetch_assoc()){ 
			$response['adText']=$row['text'];
			$response['adImageUrl']=$row['imageUrl'];
			$response['adRedirectUrl']=$row['redirectUrl'];
		}
	}
	$response['success']=1;
	$response['message']="Welcome!";	
	echo json_encode($response);			
?>
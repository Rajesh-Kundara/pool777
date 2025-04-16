<?php
include ('../common/config.php');
$response=array();
$response['undersList']=array();
if(!empty($_POST['idForUpdate'])){
	$sql = "SELECT * FROM matches WHERE id=".$_POST['idForUpdate']."";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$response['id']=$row['id'];
				$response['leagueId']=$row['leagueId'];
				$response['league']=$row['league'];
				$response['season']=$row['season'];
				$response['week']=$row['week'];
				$response['homeTeam']=$row['homeTeam'];
				$response['awayTeam']=$row['awayTeam'];
				$response['matchDate']=$row['matchDate'];
			} 
			$response['success'] =1;
			$response["message"] = "Data list loading successful.";				
	}else{  
		$response['success'] =0;
		$response["message"] = "Something went wrong.";  
	} 
	}else{
		$response['success'] =0;
		$response["message"] = "Parameters missing!.";	
	}
		
	echo json_encode($response);			
?>
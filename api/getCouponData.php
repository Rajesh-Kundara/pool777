<?php
include ('../config.php');
$response=array();
$response['drawOdds']=array();
if(!empty($_POST['idForUpdate'])){
	$sql = "SELECT * FROM coupons WHERE id=".$_POST['idForUpdate']." AND status='A'";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$response['id']=$row['id'];
				$response['week']=$row['week'];
				$response['weekInfo']=$row['weekInfo'];
				$response['typeId']=$row['typeId'];
				$response['couponOdds']=$row['couponOdds'];
				$response['minStack']=$row['minStack'];
				$response['minPerLine']=$row['minPerLine'];
				$response['season']=$row['season'];
				$response['closeDate']=$row['closeDate'];
				$response['matchDate']=$row['matchDate'];
				$response['ruleDescription']=$row['ruleDescription'];
				
				$response['under2']=$row['under2'];
				$response['under3']=$row['under3'];
				$response['under4']=$row['under4'];
				$response['under5']=$row['under5'];
				$response['under6']=$row['under6'];
				$response['under7']=$row['under7'];
				$response['under8']=$row['under8'];
				$response['maxUnder2']=$row['maxUnder2'];
				$response['maxUnder3']=$row['maxUnder3'];
				$response['maxUnder4']=$row['maxUnder4'];
				$response['maxUnder5']=$row['maxUnder5'];
				$response['maxUnder6']=$row['maxUnder6'];
				$response['maxUnder7']=$row['maxUnder7'];
				$response['maxUnder8']=$row['maxUnder8'];
				
				$sql2 = "SELECT * FROM couponodds WHERE couponId=".$_POST['idForUpdate']." AND status='A'";
				$stmt2 = $connection->query($sql2);
				 
				if ($stmt2){
					while( $row2 = $stmt2->fetch_assoc()){
						$data=array();
						$data['oId']=$row2['id'];
						$data['from']=$row2['dFrom'];
						$data['to']=$row2['dTo'];
						$data['odds2']=$row2['odds2'];
						$data['odds3']=$row2['odds3'];
						$data['odds4']=$row2['odds4'];
						$data['odds5']=$row2['odds5'];
						$data['odds6']=$row2['odds6'];
						$data['odds7']=$row2['odds7'];
						$data['odds8']=$row2['odds8'];
						array_push($response["drawOdds"],$data);
					}
				}
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
<?php
include ('../common/config.php');
$response=array();
$response['matches']=array();
if(!empty($_POST['stackId']) && !empty($_POST['draws'])){
	$draws=$_POST['draws'];
	$sql = "SELECT id, couponId,(SELECT name from coupontypemaster where id=s.couponTypeId) as name,
			couponTypeId,week,date,under2,under3,under4,under5,under6,under7,under8,stackAmount
			FROM stacks s WHERE id=".$_POST['stackId'];
	$stmt = mysql_query($sql);
	
	if ( $stmt ){
		while( $row = mysql_fetch_array( $stmt)){
				$response['id']=$row['id'];
				$response['couponTypeId']=$row['couponTypeId'];
				$response['couponId']=$row['couponId'];
				$response['name']=$row['name'];
				$response['week']=$row['week'];
				$response['date']=$row['date'];
				$response['stackAmount']=$row['stackAmount'];
				$response['under2']=$row['under2'];
				$response['under3']=$row['under3'];
				$response['under4']=$row['under4'];
				$response['under5']=$row['under5'];
				$response['under6']=$row['under6'];
				$response['under7']=$row['under7'];
				$response['under8']=$row['under8'];
				
				$sql2 = "SELECT * FROM couponodds WHERE $draws>=dFrom AND $draws<=dTo AND couponId=".$row['couponId']." AND status='A'";
				$stmt2 = mysql_query($sql2);
				
				if ( $stmt2 ){
					while( $row2 = mysql_fetch_array( $stmt2)){
						$response['oId']=$row2['oId'];
						$response['dFrom']=$row2['dFrom'];
						$response['dTo']=$row2['dTo'];
						$response['odds2']=$row2['odds2'];
						$response['odds3']=$row2['odds3'];
						$response['odds4']=$row2['odds4'];
						$response['odds5']=$row2['odds5'];
						$response['odds6']=$row2['odds6'];
						$response['odds7']=$row2['odds7'];
						$response['odds8']=$row2['odds8'];
					}
				}
				
				$sql2 = "SELECT s.id,s.winner,m.homeTeam,m.awayTeam,m.homeScore,m.awayScore,m.isResultDeclared
						FROM stackdetail s LEFT JOIN matches m ON m.id=s.matchId
						WHERE s.parentId=".$row['id'];
				$stmt2 = mysql_query($sql2);
				
				if ( $stmt2 ){
					while( $row2 = mysql_fetch_array( $stmt2)){
						$data=array();
						$data['id']=$row2['id'];
						$data['isResultDeclared']=$row2['isResultDeclared'];
						$data['winner']=$row2['winner'];
						$data['homeTeam']=$row2['homeTeam'];
						$data['awayTeam']=$row2['awayTeam'];
						$data['homeScore']=$row2['homeScore'];
						$data['awayScore']=$row2['awayScore'];
						array_push($response["matches"],$data);
					}
				}
			} 
			$response['success'] =1;
			$response["message"] = "Data list loading successful.";				
	}else{  
		$response['success'] =0;
		$response["message"] = "Something went wrong.".mysql_error();  
	} 
	}else{
		$response['success'] =0;
		$response["message"] = "Parameters missing!.";	
	}
		
	echo json_encode($response);			
?>
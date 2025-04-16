<?php
include ('../common/config.php');
function trimDecimal($decimal){
	return (explode(".",$decimal)[1]==0)?explode(".",$decimal)[0]:$decimal;
}
$response=array();
$response['couponsList']=array();

$sql = "SELECT id,typeId,(SELECT name FROM coupontypemaster WHERE id=typeId) as name,
		(SELECT imageUrl FROM coupontypemaster WHERE id=typeId) as imageUrl,minStack,minPerLine,ruleDescription,
		season,matchDate,closeDate,couponId,week,weekInfo,status,
		under2,under3,under4,under5,under6,under7,under8,maxUnder2,maxUnder3,maxUnder4,maxUnder5,maxUnder6,maxUnder7,maxUnder8 FROM coupons WHERE status='A'";
$result = $connection->query($sql);
//echo mysql_error();
if ( $result ){
	while( $row = $result->fetch_assoc()){
		$data=array();
		$data['id']=$row['id'];
		$data['typeId']=$row['typeId'];
		
		$name=explode(" - ",$row['name']);
		$couponTypeName=$row['name'];
		$couponName="";
		if(sizeof($name)>1){
			$couponTypeName=$name[0];
			$couponName=$name[1];
		}
		
		$data['couponTypeName']=$couponTypeName;
		$data['couponName']=$couponName;
		$data['imageUrl']=$row['imageUrl'];
		$data['minStack']=$row['minStack'];
		$data['minPerLine']=$row['minPerLine'];
		$data['ruleDescription']=$row['ruleDescription'];
		$data['season']=$row['season'];
		$data['matchDate']=$row['matchDate'];
		$data['closeDate']=$row['closeDate'];
		$data['couponId']=$row['couponId'];
		$data['week']=$row['week'];
		$data['weekInfo']=$row['weekInfo'];
		$data['status']=$row['status'];
		
		$data['unders']=array();
		if($row['under2']==1){
			$dataU=array();
			$dataU['under']=2;
			$dataU['max']=$row['maxUnder2'];
			array_push($data['unders'],$dataU);
		}
		if($row['under3']==1){
			$dataU=array();
			$dataU['under']=3;
			$dataU['max']=$row['maxUnder3'];
			array_push($data['unders'],$dataU);
		}
		if($row['under4']==1){
			$dataU=array();
			$dataU['under']=4;
			$dataU['max']=$row['maxUnder4'];
			array_push($data['unders'],$dataU);
		}
		if($row['under5']==1){
			$dataU=array();
			$dataU['under']=5;
			$dataU['max']=$row['maxUnder5'];
			array_push($data['unders'],$dataU);
		}
		if($row['under6']==1){
			$dataU=array();
			$dataU['under']=6;
			$dataU['max']=$row['maxUnder6'];
			array_push($data['unders'],$dataU);
		}
		if($row['under7']==1){
			$dataU=array();
			$dataU['under']=7;
			$dataU['max']=$row['maxUnder7'];
			array_push($data['unders'],$dataU);
		}
		if($row['under8']==1){
			$dataU=array();
			$dataU['under']=8;
			$dataU['max']=$row['maxUnder8'];
			array_push($data['unders'],$dataU);
		}
		
		$data['odds']=array();
		$sql2="SELECT * FROM couponodds WHERE couponId=".$row['id']." AND status='A'";
		$result2 = $connection->query($sql2);
		if ( $result2){
			$tr;
			while( $row2 = $result2->fetch_assoc()){
				$dataO=array();
				$dataO['dFrom']=$row2['dFrom'];
				$dataO['dTo']=$row2['dTo'];
				$dataO['odds2']=trimDecimal($row2['odds2']);
				$dataO['odds3']=trimDecimal($row2['odds3']);
				$dataO['odds4']=trimDecimal($row2['odds4']);
				$dataO['odds5']=trimDecimal($row2['odds5']);
				$dataO['odds6']=trimDecimal($row2['odds6']);
				$dataO['odds7']=trimDecimal($row2['odds7']);
				$dataO['odds8']=trimDecimal($row2['odds8']);
				
				array_push($data['odds'],$dataO);
			}
		}
		array_push($response['couponsList'],$data);
	}
	$response['success'] =1;
	$response["message"] = "Data loaded.";
}else{  
	$response['success'] =0;
	$response["message"] = "Something went wrong.".$result->error();  
} 

echo json_encode($response);
?>
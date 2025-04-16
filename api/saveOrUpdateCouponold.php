<?php
include('../common/config.php');
if(!empty($_POST['typeId']) && !empty($_POST['matchDate'])){
	$response=array();
	$isUpdate=false;
	if(!empty($_POST['idForUpdate'])){
		$isUpdate=true;
		$idForUpdate=$_POST['idForUpdate'];
	}
	$week=$_POST['week'];
	$weekInfo=$_POST['weekInfo'];
	$typeId=$_POST['typeId'];
	$minStack=$_POST['minStack'];
	$minPerLine=$_POST['minPerLine'];
	//$season=$_POST['season'];
	$matchDate=$_POST['matchDate'];
	$closeDate=$_POST['closeDate'];
	$ruleDescription=$_POST['ruleDescription'];
	
	$under2=$_POST['under2'];
	$under3=$_POST['under3'];
	$under4=$_POST['under4'];
	$under5=$_POST['under5'];
	$under6=$_POST['under6'];
	$under7=$_POST['under7'];
	$under8=$_POST['under8'];
	$maxUnder2=$_POST['maxUnder2'];
	$maxUnder3=$_POST['maxUnder3'];
	$maxUnder4=$_POST['maxUnder4'];
	$maxUnder5=$_POST['maxUnder5'];
	$maxUnder6=$_POST['maxUnder6'];
	$maxUnder7=$_POST['maxUnder7'];
	$maxUnder8=$_POST['maxUnder8'];
	
	$drawOdds = json_decode($_POST['drawOdds'],true);
	
	//for week (SELECT WEEK('$matchDate',1))
	if($isUpdate){
		$sql = "UPDATE coupons set week='$week',weekInfo='$weekInfo',typeId='$typeId',minStack='$minStack',minPerLine='$minPerLine',
				matchDate='$matchDate',closeDate='$closeDate',ruleDescription='$ruleDescription',
				under2=$under2, under3=$under3,under4=$under4,under5=$under5,under6=$under6,under7=$under7,under8=$under8,
				maxUnder2=$maxUnder2,maxUnder3=$maxUnder3,maxUnder4=$maxUnder4,maxUnder5=$maxUnder5,maxUnder6=$maxUnder6,maxUnder7=$maxUnder7,maxUnder8=$maxUnder8
				WHERE id='$idForUpdate'";  
	}else{
		$sql = "INSERT INTO coupons (week,weekInfo,typeId,minStack,minPerLine,matchDate,closeDate,ruleDescription,
				under2,under3,under4,under5,under6,under7,under8,maxUnder2,maxUnder3,maxUnder4,maxUnder5,maxUnder6,maxUnder7,maxUnder8)
				VALUES('$week','$weekInfo','$typeId','$minStack','$minPerLine','$matchDate','$closeDate','$ruleDescription',
				$under2,$under3,$under4,$under5,$under6,$under7,$under8,$maxUnder2,$maxUnder3,$maxUnder4,$maxUnder5,$maxUnder6,$maxUnder7,$maxUnder8)";  
	
		$idForUpdate = mysql_insert_id();
	}
	$stmt = mysql_query( $sql);  
	if ( $stmt )  
	{
		$response['success']="1";
		$response["message"] = "Data saved succefully.";
		
		if($isUpdate==false){
			$sql = "UPDATE coupons set couponId='".md5($idForUpdate)."' WHERE id='$idForUpdate'";  
			$stmt = mysql_query( $sql);  
		}
		
		$sql = "UPDATE couponodds set status='I' WHERE couponId='$idForUpdate'";
		$stmt = mysql_query( $sql);			
		foreach($drawOdds['drawOdds'] as $data){
			$oId=$data['id'];
			$from=$data['from'];
			$to=$data['to'];
			$odds2=$data['odds2'];
			$odds3=$data['odds3'];
			$odds4=$data['odds4'];
			$odds5=$data['odds5'];
			$odds6=$data['odds6'];
			$odds7=$data['odds7'];
			$odds8=$data['odds8'];
			if($oId==0){
				$sql = "INSERT INTO couponodds (couponId,`from`,`to`,odds2,odds3,odds4,odds5,odds6,odds7,odds8)
				VALUES('".$idForUpdate."','$from','$to','$odds2','$odds3','$odds4','$odds5','$odds6','$odds7','$odds8')"; 
			}else{
				$sql = "UPDATE couponodds set `from`='$from',`to`='$to',odds2='$odds2',odds3='$odds3',
				odds4='$odds4',odds5='$odds5',odds6='$odds6',odds7='$odds7',odds8=$odds8
				WHERE id='$oId'";  
			}
			$stmt = mysql_query( $sql);	
		}
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
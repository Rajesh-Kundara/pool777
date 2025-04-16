<?php
include('../common/config.php');
if(!empty($_POST['week']) && !empty($_POST['couponId']) && !empty($_POST['stackAmount']) && !empty($_POST['matchesSelected'])){
	$response=array();
	
	$balance=0;
	if(!empty($_POST['userId'])){
		$userId=$_POST['userId'];
	}else{
		$userId=$_SESSION['id'];
	}
	$week=$_POST['week'];
	$couponId=$_POST['couponId'];
	$couponTypeId=$_POST['couponTypeId'];
	$stackAmount=$_POST['stackAmount'];
	$matchesSelected=$_POST['matchesSelected'];
	
	$under2=$_POST['under2'];
	$under3=$_POST['under3'];
	$under4=$_POST['under4'];
	$under5=$_POST['under5'];
	$under6=$_POST['under6'];
	$under7=$_POST['under7'];
	$under8=$_POST['under8'];
	
	$sql = "SELECT SUM(amount) as balance from balance WHERE userId=$userId";  
	$result = $connection->query( $sql);  
	if ( $result ){  
		$row = $result->fetch_assoc();
		$balance = $row['balance'];
	}
	if($stackAmount<=$balance){
		$sql = "INSERT INTO stacks (userId,couponId,couponTypeId,week,stackAmount,under2,under3,under4,under5,under6,under7,under8)
				VALUES('$userId','$couponId','$couponTypeId','$week','$stackAmount',$under2,$under3,$under4,$under5,$under6,$under7,$under8)";  

		$stmt = $connection->query( $sql);  
		$parentId = mysql_insert_id();
		if ( $stmt )  
		{  
			$matchesSelected=explode(',',$matchesSelected);
			foreach ($matchesSelected as $matchId) {
				$sql2 = "INSERT INTO stackdetail (parentId,matchId) VALUES('$parentId','$matchId')";  

				$stmt2 = $connection->query( $sql2);  
			}
			$response['success'] = "1";
			$response["message"] = "Stacked successfuly.";
		}   
		else{  
			$response['success'] ="0";
			$response["message"] = "Error: ";
		} 
		
		$sql3 = "INSERT INTO balance (userId,amount,type,ref,date,insertDate)
				VALUES($userId,-$stackAmount,'S','".md5($couponId)."',NOW(),NOW())";  //S=stacked
		$result3 = $connection->query( $sql3);  
	}else{
		$response['success'] ="0";
		$response["message"] = "Stacked amount (".$stackAmount.") is greater than your account balance (".$balance." N)";
	}
}else{
	$response['success'] ="0";
	$response["message"] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
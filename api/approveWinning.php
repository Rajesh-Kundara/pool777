<?php
//ini_set("display_errors","on");
include ('../common/config.php');
require 'paystack/autoload.php';
$response=array();
if(!empty($_POST['stackId']) && !empty($_POST['userId']) && !empty($_POST['winning'])){
		$stackId=$_POST['stackId'];
		$userId=$_POST['userId'];
		$winning=$_POST['winning'];
		
		$remark="Won ".$winning." &#8358; in stack #".$stackId;
		
		$sql = "UPDATE stacks SET winningAmount='$winning' WHERE id='$stackId' AND userId='$userId'"; //CP=credited using paystack 
		$stmt = $connection->query($sql);
		
		if ( $stmt ){
			$sql = "INSERT INTO balance (userId,amount,date,insertDate,type,reference,remark)
					VALUES('$userId','$winning',NOW(),NOW(),'WS','WIN000$stackId','$remark')"; //WS=win in stack
			$stmt = $connection->query($sql);
			
			if ( $stmt ){
				$response['success'] =1;
				$response["message"] = "Approved!";				
			}else{  
				$response['success'] =0;
				$response["message"] = "Already Approved!";  
			} 
		}else{  
			$response['success'] =0;
			$response["message"] = "Something went wrong. Please contact developer support.";  
		} 
	
}else{
	$response['success'] =0;
	$response["message"] = "Invalid request.";	
}
	
echo json_encode($response);			
?>
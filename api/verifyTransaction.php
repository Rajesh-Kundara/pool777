<?php
//ini_set("display_errors","on");
include ('../common/config.php');
require 'paystack/autoload.php';
$response=array();
if(!empty($_POST['reference'])){
	$reference = isset($_POST['reference']) ? $_POST['reference'] : '';
    if(!$reference){
      die('No reference supplied');
    }

    // initiate the Library's Paystack Object
    $paystack = new Yabacon\Paystack($SecretKeyPayStack);
    try
    {
      // verify using the library
      $tranx = $paystack->transaction->verify([
        'reference'=>$reference, // unique to transactions
      ]);
    } catch(\Yabacon\Paystack\Exception\ApiException $e){
      print_r($e->getResponseObject());
      die($e->getMessage());
    }

    if ('success' === $tranx->data->status) {
		if(!empty($tranx->data->metadata->customer)){
			$tmp=json_encode($tranx->data);
			$tmp=json_decode($tmp,true);
			$userId=$tmp['metadata']['customer'][0]['uId'];
		}else{
			$userId=md5($_SESSION['id']);
		}
		//echo json_encode($tranx->data);die;
		$amount=$tranx->data->amount;
		$amount=$amount/100;
		$remark="Added using paystack.";
		
		$sql = "INSERT INTO balance (userId,amount,date,insertDate,type,reference,remark)
				VALUES((SELECT id FROM users WHERE md5(id)='$userId'),'$amount',NOW(),NOW(),'CP','$reference','$remark')"; //CP=credited using paystack 
		$stmt = $connection->query($sql);
		
		if ( $stmt ){
			$response['success'] =1;
			$response["message"] = "Money added.";				
		}else{  
			$response['success'] =0;
			$response["message"] = "Please contact administrator.";  
		} 
	}
	}else{
		$response['success'] =0;
		$response["message"] = "Parameters missing!.";	
	}
		
	echo json_encode($response);			
?>
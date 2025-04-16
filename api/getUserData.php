<?php
include ('../common/config.php');
$response=array();
if(!empty($_POST['userId'])){
	$sql = "SELECT * FROM users WHERE id=".$_POST['userId']." AND status='A'";
	$stmt = $connection->query($sql);
	
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
				$response['f_name']=$row['f_name'];
				$response['m_name']=$row['m_name'];
				$response['l_name']=$row['l_name'];
				$response['company']=$row['company'];
				$response['email']=$row['email'];
				$response['countryCode']=$row['countryCode'];
				$response['phone']=$row['phone'];
				$response['countryCode_gsm']=$row['countryCode_gsm'];
				$response['phone_gsm']=$row['phone_gsm'];
				$response['countryId']=$row['countryId'];
				$response['stateId']=$row['stateId'];
				$response['street']=$row['street'];
				$response['zipcode']=$row['zipcode'];
				$response['prefCurrency']=$row['prefCurrency'];
				$response['bankCountry']=$row['bankCountry'];
				$response['bankName']=$row['bankName'];
				$response['branch']=$row['branch'];
				$response['accountNo']=$row['accountNo'];
				$response['accountName']=$row['accountName'];
				$response['iban']=$row['iban'];
				$response['bankRefCode']=$row['bankRefCode'];
				$response['bankBeneficier']=$row['bankBeneficier'];
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
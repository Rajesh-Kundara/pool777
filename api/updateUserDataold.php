<?php
include('../common/config.php');
if(!empty($_POST['tab'])){
	$response=array();
		
	$tab=$_POST['tab'];
	if(!empty($_POST['userId'])){
		$userId=$_POST['userId'];
	}else{
		$userId=$_SESSION['id'];
	}
	switch($tab){
		case "personal":
			$firstName=$_POST['firstName'];
			$middleName=$_POST['middleName'];
			$lastName=$_POST['lastName'];
			$company=$_POST['company'];
			$email=$_POST['email'];
			$countryCode=$_POST['countryCode'];
			$phone=$_POST['phone'];
			$countryCode_gsm=$_POST['countryCode_gsm'];
			$phone_gsm=$_POST['phone_gsm'];
			$zipcode=$_POST['zipcode'];
			$countryId=$_POST['countryId'];
			$stateId=$_POST['stateId'];
			$street=$_POST['street'];
			
			$sql = "UPDATE users set f_name='$firstName',m_name='$middleName',l_name='$lastName',company='$company', email='$email',countryCode='$countryCode',phone='$phone',
					countryCode_gsm='$countryCode_gsm',phone_gsm='$phone_gsm', zipcode='$zipcode', countryId='$countryId', stateId='$stateId', street='$street' WHERE id='$userId'";  
			break;
		case "account":
			$prefCurrency=$_POST['prefCurrency'];
			$bankCountry=$_POST['bankCountry'];
			$bankName=$_POST['bankName'];
			$branch=$_POST['branch'];
			$accountNo=$_POST['accountNo'];
			$accountName=$_POST['accountName'];
			$iban=$_POST['iban'];
			$bankBeneficier=$_POST['bankBeneficier'];
			
			$sql = "UPDATE users set prefCurrency='$prefCurrency',bankCountry='$bankCountry', bankName='$bankName',
					branch='$branch', accountNo='$accountNo', accountName='$accountName', iban='$iban', 
					bankBeneficier='$bankBeneficier' WHERE id='$userId'";  
			break;
		case "password":
			$oldPassword=$_POST['oldPassword'];
			$newPassword=$_POST['newPassword'];
			
			$sql = "UPDATE users set password='$newPassword' WHERE id='$userId' AND password='$oldPassword'";  
			break;
	}
	
	$stmt = mysql_query( $sql);  
	$affected_rows = mysql_affected_rows();
	if ( $stmt )  
	{  
		if($tab=="password" && $affected_rows==0){
			$response['success']="0";
			$response["message"] = "Wrong old password!";
		}else{
			$response['success']="1";
			$response["message"] = "Detail successfuly updated.";
		}
	}   
	else{  
		$response['success'] ="0";
		$response["message"] = "Error: ".mysql_error();
	}    
	
}else{
	$response['success'] ="0";
	$response["message"] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
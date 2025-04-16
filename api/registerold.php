<?php
include('../common/config.php');
if(!empty($_POST['userName']) && !empty($_POST['password']) /*&& !empty($_POST['firstName']) && !empty($_POST['lastName'])*/){
	$userName=$_POST['userName'];
	$password=$_POST['password'];
	/*$firstName=$_POST['firstName'];
	$middleName=$_POST['middleName'];
	$lastName=$_POST['lastName'];
	$company=$_POST['company'];
	$email=$_POST['email'];*/
	$countryCode=$_POST['countryCode'];
	$phone=$_POST['phone'];
	/*$countryCode_gsm=$_POST['countryCode_gsm'];
	$phone_gsm=$_POST['phone_gsm'];
	$countryId=$_POST['countryId'];
	$stateId=$_POST['stateId'];
	$street=$_POST['street'];
	$prefCurrency=$_POST['prefCurrency'];*/
		
	$sql = "select * from users where userName = '$userName'";
	$result = mysql_query($sql);
	
	if ($result)  
	{
		if(mysql_num_rows($result)==0){
			$sql = "INSERT INTO users (f_name,m_name,l_name,userName,password,company,email,countryCode,phone,
					countryCode_gsm,phone_gsm,countryId,stateId,street,prefCurrency) VALUES ('$firstName',
					'$middleName','$lastName','$userName','$password','$company','$email','$countryCode',
					'$phone','$countryCode_gsm','$phone_gsm','$countryId','$stateId','$street','$prefCurrency')";
			$sql = "INSERT INTO users (userName,password,countryCode,phone) VALUES ('$userName','$password',
					'$countryCode','$phone')";
			$result = mysql_query($sql);
			
			if ($result)  
			{
				$response['success'] ="1";
				$response["message"] = "Registered successfuly!";
			}else{
				$response['success'] ="0";
				$response["message"] = "Error :".mysql_error();
			}
		}else{
			$response['success'] ="0";
			$response["message"] = "Username is taken! Please try different username.";
		}
	}
	
}else{
	$response['success'] ="0";
	$response["message"] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
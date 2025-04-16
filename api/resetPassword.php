<?php
//ini_set("display_errors","off");
include('../common/config.php');
include('handlers/send_email.php');
$emailVerificationUrl=$host.$host.'/reset_password.php?token=';
if(!empty($_POST['userName'])){
	$userName=$_POST['userName'];
		
	$sql = "select * from users where userName = '$userName' OR email='$userName' OR phone='$userName'";
	$result = $connection->query($sql);
	
	$userFound=false;
	if ($result)  
	{
		while( $row = $result->fetch_assoc())  
		{  
			$name = $row['f_name'];
			$to=$row['email'];
			$subject='Pools777 Password reset notification';
			$body="Dear ".$name."<br><br>
					You have requested to reset the password of your Pools777 account.<br><br>
					Click below to reset password.<br><br>
					<a href='".$emailVerificationUrl.md5($to)."'>Click here to reset password</a><br><br>
					
					Thank you";

			$isMailSent=SendEmail($to, $subject, $body);
			$message="Password reset link sent to\n$to";
			/*$fp = fsockopen($mail_host, $mail_port, $errno, $errstr, 5);
			if (!$fp) {
				$message="port is closed or blocked";
			} else {
				$message="port is open and available";
				fclose($fp);
			}*/

			if ($isMailSent)  
			{
				$response['success'] ="1";
				$response["message"] = $message;
			}else{
				$response['success'] ="0";
				$response["message"] = "Sorry, password reset request could not be processed at this time. Please try again later.";
			}
			$userFound=true;
		}
		if($userFound===false){
			$response['success'] ="0";
			$response["message"] = "User not found.";
		}
	}
	
}else if(!empty($_POST['token']) && !empty($_POST['password'])){
	$sql = "UPDATE users as a, (SELECT id FROM users a where md5(a.email) = '".$_POST['token']."') as b 
			SET a.password='".$_POST['password']."' WHERE a.id=b.id";
	$result = $connection->query($sql);
	
	if ($result)  
	{
		$response['success'] ="1";
		$response["message"] = "Your password has been reset.";
	}else{
		$response['success'] ="0";
		$response["message"] = "Sorry, password reset request could not be processed at this time. Please try again later.";
	}
}else{
	$response['success'] ="0";
	$response["message"] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
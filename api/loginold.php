<?php
include('../common/config.php');
if(!empty($_POST['userName']) && !empty($_POST['password'])){
	$userName=$_POST['userName'];
	$password=$_POST['password'];
	$sql = "select * from users where (userName = '$userName' OR phone='$userName') and password = '$password'";
	$result = $connection->query($sql);
	
	$userFound=false;	
	if ( $result )  
	{
	    while( $row = $result->fetch_assoc( ))  
		{  
			$name = $row['f_name'];
			
			$_SESSION['fullname'] = $row['f_name']." ".$row['m_name']." ".$row['l_name'];
			$_SESSION['id'] = $row['id']."";
			$_SESSION['type'] = $row['role'];
		
			$userFound=true;		
			
			$response['fullname'] =$_SESSION['fullname'];
			$response["id"] = $_SESSION['id'];
			$response["type"] = $_SESSION['type'];
			
			// setcookie('fullname', $name, time()+60*60*24*365);
			// setcookie('id', $id, time()+60*60*24*365);
			// setcookie('type', $type, time()+60*60*24*365);
			setcookie('fullname', $_SESSION['fullname'], time()+60*60*24*365);
			setcookie('id', $_SESSION['id'], time()+60*60*24*365);
			setcookie('type', $_SESSION['type'], time()+60*60*24*365);
		}
		
		$response['success'] ="1";
		// $response["message"] = "Welcome ".$_SESSION['name'];
		$response["message"] = "Welcome ".$_SESSION['fullname'];
	}else{
		$response['success'] ="0";
		$response["message"] = "Invalid username or password";
	}
	if(!$userFound){
		$response['success'] ="0";
		$response["message"] = "Wrong username/password!";
	}
}else{
	$response['success'] ="0";
	$response["message"] = "Parameter(s) missing!";
}

echo json_encode($response);
?>
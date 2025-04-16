<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="icon" href="assets/images/logo.png" sizes="16x16">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="login/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="login/css/font-awesome.css" rel="stylesheet"> <!-- Font-Awesome-Icons-CSS -->
<link href="login/css/googleFont.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/login-style.css" />
</head>
<?php 
ini_set("display_errors","off");
include('../common/config.php');
?>
<?php
if(isset($_COOKIE['fullname']) && isset($_COOKIE['id'])){
$fullname = $_COOKIE['fullname'];
$id = $_COOKIE['id'];
}

//if($id == ''){
?>
<?php 
/*if(isset($_GET['action']))
{
	$_COOKIE['fullname']="";
	$_COOKIE['id']="";
}*/
if(isset($_POST['submit']))
{
	$userName=$_POST['userName'];
	$password=$_POST['password'];
	 $sql = "select * from users where userName = '$userName' and password = '$password'";
	$result = $connection->query($sql);
	
	$userFound=false;	
	if ($result->num_rows > 0)  
	{  
	
	    $row = $result->fetch_assoc();
		
			$name = $row['f_name'];
			$userFound=true;		
			
			$_SESSION['fullname'] = $row['f_name']." ".$row['m_name']." ".$row['l_name'];
			// $_SESSION['id'] = $row['id'];

			$_SESSION['id'] = (string)$row['id'];
			$_SESSION['type'] = $row['role'];
			$_SESSION['username'] = $row['userName'];
			//$_SESSION['type'] = $row['type'];
			
			$fullname = $_SESSION['fullname'];
			$id = $row['id'];
			//$type = $row['type'];
			
			setcookie('fullname', $name, time()+60*60*24*365);
			setcookie('id', $id, time()+60*60*24*365);
			//setcookie('type', $type, time()+60*60*24*365);
			// echo "ok";
			$date = date('Y-m-d H:i:s');
			$sql = "update users set lastLogin = '".$date."' where id = '".$row['id']."'";
// 			echo "<pre>Running query: $sql</pre>";

// if ($connection->query($sql) === TRUE) {
//     echo "Login time updated successfully<br>";
// } else {
//     echo "Error updating login time: " . $connection->error . "<br>";
// }
			header('Location: dashboard.php');
			// echo "<script>window.location.href='dashboard.php';</script>";
			// echo "ok1";die;
	}else{
		// echo "ok2";die;
		echo $err = "Invalid username or password";
		echo $userFound;
		
	}
	if(!$userFound){
		echo "<script>window.location.href='index.php?q=error'</script>";
	}
}
?>
<style>
.margin
{
	margin-right: 26%;
}
@media (max-width: 767px)
{
	.margin
	{
		margin-right: 58%;
	}	
}
</style>
<body>
	<div class="main">
		<img align="center" src="../assets/images/logo.png" style="height:120px;widht:120px">
		<h1>Admin Portal</h1>
		<div class="main-w3lsrow">
			<div class="login-form login-form-left"> 
				<div class="agile-row">
					<div class="head">
					</div>					
					<?php if(isset($_GET['q']) && $_GET['q'] == 'error') { ?><span style="color:red;font-size:15px;">Please enter correct details!</span><?php } ?>
					<?php if(isset($_GET['q']) && $_GET['q'] == 'change') { ?><span style="color:green;font-size:15px;">Please login with new password!!!</span><?php } ?>
					<div class="clear"></div>
					<div class="login-agileits-top"> 	
						<form method="post"> 
							<input type="text" class="name" name="userName" Placeholder="Username" required=""/>
							<input type="password" class="password" name="password" Placeholder="Password" required=""/>
							<input type="submit" name="submit" value="Login Now"> 
						</form> 	
					</div> 
					<div class="login-agileits-bottom"> 
						<!--<h6><a href="forgotPass.php">Forgot your password?</a></h6>-->
					</div> 
				</div>  
			</div>  
		</div><br>
		
	</div>	
</body>
<?php //}else{ 
//echo "<script>window.location.href='dashboard.php'</script>";
//} ?>
</html>
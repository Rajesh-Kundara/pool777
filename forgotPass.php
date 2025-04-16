<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="icon" href="assets/images/wtp-logo.png" sizes="16x16">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="login/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="login/css/font-awesome.css" rel="stylesheet"> <!-- Font-Awesome-Icons-CSS -->
<link href="login/css/googleFont.css" rel="stylesheet">
</head>
<?php 
ini_set("display_errors","off");
include('config.php');
include	('handlers/send_email.php');
if(isset($_POST['submit']))
{
	extract($_POST);
	$sql = "select * from users where email = '$email'";
	$result = $connection->query($sql);
	$row = $result->fetch_assoc();
	$name = $row['name'];
	if($name == '')
	{
		echo "<script>window.location.href='forgotPass.php?q=error'</script>";
	}else
	{
		$link = "http://localhost/wtpportal.com/changePass.php?email=$email";
			$to = $email;
			$subject = 'Varify link ';
			$message = "WELCOME!!! <br><br>
								Click the link to varify : ".$link."<br><br>
								Thank You!!";
		SendEmail($to, $subject, $message);
		//echo "<script>window.location.href='forgotPass.php?q=sent'</script>";
	}
}
?>
<body>
	<div class="main">
		<h1></h1>
		<div class="main-w3lsrow">
			<div class="login-form login-form-left"> 
				<div class="agile-row">
					<div class="head">
						<h2>Enter email</h2>
					</div>					
					<?php if($_GET['q'] == 'error') { ?><span style="color:red;font-size:15px;">Please enter correct email!!!</span><?php } ?>
					<?php if($_GET['q'] == 'sent') { ?><span style="color:green;font-size:15px;">Change password link sent your email id!!!</span><?php } ?>
					<div class="clear"></div>
					<div class="login-agileits-top"> 	
						<form method="post"> 
							<input type="text" class="name" name="email" Placeholder="Email" required=""/>
							<input type="submit" name="submit" value="Submit"> 
						</form> 	
					</div> 
					<div class="login-agileits-bottom"> 
					</div> 

				</div>  
			</div>  
		</div>
	</div>	
</body>
</html>
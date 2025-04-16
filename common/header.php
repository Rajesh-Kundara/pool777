
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default navbar-fixed-top px-2">
	<div class="container-fluid"> 
		<div class="navbar-header">
			<!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
				<i class="fa fa-bars"></i>
			</button>-->
			<a class="navbar-brand" href="dashboard.php">
				<img alt="Brand" src="assets/images/logo.png" style="max-height:90px;max-widht:90px">
			</a>
		</div>
		<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbar-menu"
			aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		<div class="collapse navbar-collapse" id="navbar-menu" align="center">
			<ul class="nav nav-tabs navbar-nav mr-auto">
				<li role="presentation"><a class="nav-link" href="index.php">Coupons</a></li>
				<li role="presentation"><a class="nav-link" href="result.php">Results</a></li>
				<li role="presentation" class="active"><a class="nav-link" href="about_us.php">About Us</a></li>
				<li role="presentation"><a class="nav-link" href="contact_us.php">Contact Us</a></li>
			</ul>
			<?php
			if(!empty($_GET['logout'])){
				unset($_SESSION['fullname']);
				unset($_SESSION['id']);
				unset($_SESSION['type']);
				session_destroy();
				// header('index.php');
				echo "<script>window.location.href='index.php'</script>";
			}
			if(!isset($_SESSION['fullname']) ){
			?>
			<div class="dropdown" style="width:250px">
				<button id="dLabel" class="btn btn-danger btn-sm text-white" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Login
				</button>
				<a class="btn btn-sm btn-danger text-white" href="<?=$host;?>/register.php" role="button">Register</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
				  <form class="px-4 py-1">
					<div class="form-group">
					  <label for="userName">Username</label>
					  <input type="text" class="form-control" id="userName" placeholder="userName">
					</div>
					<div class="form-group">
					  <label for="password">Password</label>
					  <input type="password" class="form-control" id="password" placeholder="Password">
					</div>
					<div class="form-check">
					  <input type="checkbox" class="form-check-input" id="dropdownCheck">
					  <label class="form-check-label" for="dropdownCheck">
						Remember me
					  </label>
					</div>
					<button type="button" onClick="login()" class="btn btn-primary">Sign in</button>
					
				  </form>
				  <div id="loginErrorContainer"></div>
				  <a class="dropdown-item" href="<?=$host;?>/reset_password.php">Forgot password</a>
				  <div class="dropdown-divider"></div>
				  <a class="dropdown-item" href="<?=$host;?>/register.php">New around here? Sign up</a>
				  <!--<a class="dropdown-item" href="#">Forgot password?</a>-->
				</div>
			</div>
			<?php
			}else{
				$sql = "SELECT SUM(amount) as balance from balance WHERE userId=".$_SESSION['id'];  
				 
				$result = $connection->query($sql);
				if ( $result ){  
					$row = $result->fetch_assoc();
					$balance = $row['balance'];
				}
			?>
			<div class="badge badge-light" style="width:250px;">
			Welcome <?=$_SESSION['fullname']?> <a href="index.php?logout=rdr">(logout)</a></br></br>
			Balance : <?=$balance?> &#8358;
			</div>
				<div class="">
					<ul class="">
					  <li class="">
						<a class="text-dark" href="account.php">My Account</a>
					  </li>
					  <?php 
					  if($_SESSION['type']=="A"){
						?>
					  <li class="">
						<a class="text-dark" href="<?=$host?>/admin/dashboard.php">Admin Panel</a>
					  </li>
					  <?php } ?>
					</ul>
				</div>
			<?php
			}
			?>
		</div> 
	</div>
	
</nav><!--<span>Welcome <?=$_COOKIE['fullname']?></span>-->

<?php 
	$sql = "SELECT * FROM greetings order by id desc limit 1";
	$result = $connection->query($sql);
	$greetingMessage="";
	//echo mysql_error();
	// if ( $result ){ 
	// 	while( $row3 = mysql_fetch_array($result)){
	// 		$greetingMessage=$row3['text'];
	// 	}
	// }
	if ($result) {
		// Fetch the latest greeting message
		while ($row3 = $result->fetch_assoc()) { 
			$greetingMessage = $row3['text'];
		}
	} else {
		// Handle query failure
		die("Query failed: " . $connection->error);
	}				
?>
<div class="row bg-light text-right py-1 px-0 mx-0">
	<div class="col">
	<marquee direction="left"><?=$greetingMessage?></marquee>
	</div>
</div>

<script>
  
  function login(){
		$("#loginError").alert('close');
	  	var userName= $('#userName').val();
	  	var password= $('#password').val();
	  	
	  	var form_data = new FormData();
	  	form_data.append("userName", userName);
	  	form_data.append("password", password);
		
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/login.php", 
		    processData: false,
		    contentType: false,
		    data: form_data,
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
			    	window.location.href="<?=$host?>";
					// location.reload();
				}else{
					var html='<div id="loginError" class="alert alert-danger fade show" role="alert" style="width:250px;">'+response.message+'</div>';
					$("#loginErrorContainer").html(html);
					//$("#loginError").show('slow');
				}
			},  
		    error: function(e){  
		      alert(e.status);
	           alert(e.responseText);
	           alert(thrownError);
		    }  
		});  
	  	//document.getElementById("saveButton").disabled=true;
	}  
</script>
<!-- Begin of Chaport Live Chat code -->
<script type="text/javascript">
(function(w,d,v3){
w.chaportConfig = { appId : '5d08d78178b3b63a0789ac92' };

if(w.chaport)return;v3=w.chaport={};v3._q=[];v3._l={};v3.q=function(){v3._q.push(arguments)};v3.on=function(e,fn){if(!v3._l[e])v3._l[e]=[];v3._l[e].push(fn)};var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://app.chaport.com/javascripts/insert.js';var ss=d.getElementsByTagName('script')[0];ss.parentNode.insertBefore(s,ss)})(window, document);
</script>
<!-- End of Chaport Live Chat code -->	

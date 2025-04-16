<?php 
include('../common/config.php');
if(!isset($_SESSION['fullname']))
{
	echo "<script>window.location.href='index.php?q=error'</script>";
}
?>

<html class="no-js" lang="en">
<?php 
include('common/head.php');
?>

<?php 
ini_set("display_errors","off");
if(!empty($_POST['saveButton']))
{
	$id="0";
	if(!empty($_POST['idForUpdate'])){
		$id=$_POST['idForUpdate'];
	}
	$message=$_POST['message'];
	
	if($id=="0"){
		$sql = "insert into greetings(text) values('$message')";	
	}else{
		$sql = "update greetings set text='$message' where id=$id";	
	}
	//echo $sql;die;
	$result = $connection->query($sql);
	$idValue = mysql_insert_id();

	echo "<script>window.location.href='dashboard.php'</script>";
}
?>
	
    <body data-spy="scroll" data-target=".navbar-collapse">
        <div class="culmn">
			<?php
			$activePage="dashboard";
			include('common/header.php'); ?>
			<div class="container border my-4">
				<div class="row">
					
				   <div class="col-md-12 py-4">
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4 text-center"><h4><u>Dashboard</u></h4></div>
							<div class="col-md-4"></div>
						</div><br>
						<?php 
							$sql = "SELECT * FROM greetings order by id desc limit 1";
							$stmt3 = $connection->query($sql);
							$text="";
							//echo mysql_error();
							if ( $stmt3 ){ 
								while( $row3 = $stmt3->fetch_assoc()){ 
									$text=$row3['text'];
								}
							}	else{
								echo "no record found.".$stmt3->error();
							}			
						?>
						<form name="form" method="post" action="">
						<div class="row">
							<div class="col-md-1">
							</div>
							<div class="col-md-3 text-center">
								<h5 style="padding:10px 12px 12px 0;display: inline-block;">Greeting message</h5>
							</div>
							<div class="col-md-7">
								<input type="text" class="form-control" name="message" value="<?=$text?>" placeholder="greeting message..." required>
							</div>
							<div class="col-md-1">
							</div>
						</div>
						
						<div class="row">
							<div class="col text-center my-4">
								<input type="submit" name="saveButton" value="Save" class="btn btn-primary">	
							</div>
						</div>
						</form>
					</div>
                </div>
			</div>
        </div>
		<?php include('common/footer.php'); ?>
<!-- JS includes -->

<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>

<script src="../assets/js/vendor/popper.min.js"></script>
<script src="../assets/js/vendor/bootstrap.min.js"></script>

<script src="../js/jquery.dataTables.min.js"></script>
<link href="../css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- material datepicker -->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="../assets/js/vendor/bootstrap-material-datetimepicker.js"></script>

<script src="../assets/js/mdtimepicker.js"></script>
<link href="../assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">
</body>
</html>

<?php 
session_start();
include('config.php');
if($_COOKIE['fullname'] == '')
{
	echo "<script>window.location.href='index.php?q=error'</script>";
}
?>

<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="assets/images/logo.png" sizes="16x16">
	<title>Admin Portal</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="favicon.ico">
	<link href="login/css/googleFont.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/owl.carousel.html"> 
	<link rel="stylesheet" href="assets/css/owl.theme.html"> 
	<link rel="stylesheet" href="assets/css/slick/slick.css"> 
	<link rel="stylesheet" href="assets/css/slick/slick-theme.css">
	<link rel="stylesheet" href="assets/css/animate.css">
	<link rel="stylesheet" href="assets/css/iconfont.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<link rel="stylesheet" href="assets/css/bootsnav.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css" />
	<script src="assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
	<style>
	body{
		background-color:#f5f5f5;
	}
	input[type=text], select, textarea 
	{
		width: 100%;
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 4px;
		resize: vertical;
	}
	input[type=file]
	{
		width: 100%;
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 4px;
		resize: vertical;
	}
	.chosen-drop
	{
		height: 180px;
	}
	.chosen-results
	{
		height: 180px;
	}
	.containerClass
	{
		margin-top:3%;
	}
	@media only screen and (min-device-width : 768px) and (max-device-width : 1024px) 
	{
		.containerClass
		{
			margin-top:10%;
		}
	}
	</style>
<?php 
if($_GET['edit'] == ''){
?>
<?php
ini_set("display_errors","off");
if(!empty($_POST['saveButton']))
{
	$files = $_FILES['file']['name'];
	
	$isImageNull=true;
	$tmpFilePath = $_FILES['file']['tmp_name'];
	  if ($tmpFilePath != ""){
		$newFilePath = "./uploadFiles/" . $_FILES['file']['name'];
		if(move_uploaded_file($tmpFilePath, $newFilePath)) {
		}
		$isImageNull=false;
	}

	$id="0";
	if(!empty($_POST['idForUpdate'])){
		$id=$_POST['idForUpdate'];
	}
	$text=$_POST['text'];
	$redirectUrl=$_POST['redirectUrl'];
	
	if($id=="0"){
		if($isImageNull)
			$sql = "insert into ads(text,redirectUrl) values('$text','$redirectUrl')";	
		else
			$sql = "insert into ads(text,imageUrl,redirectUrl) values('$text','$files','$redirectUrl')";	
	}else{
		if($isImageNull)
			$sql = "update ads set text='$text',redirectUrl='$redirectUrl' where id=$id";	
		else
			$sql = "update ads set text='$text',imageUrl='$files',redirectUrl='$redirectUrl' where id=$id";	
	}
	//echo $sql;die;
	$result = $connection->query($sql);
	$idValue = mysql_insert_id();

	echo "<script>window.location.href='ads.php'</script>";
}
?>	
	
    <body data-spy="scroll" data-target=".navbar-collapse">
        <div class="culmn">
			<?php include('header.php'); ?>


            <!--Test section-->
            <section id="test" class="test roomy-60 fix">
                <div class="container containerClass">
                    <div class="row">                        
                        <div class="main_test fix">
							<div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="test_item fix">
									<form method="post" enctype="multipart/form-data" >
									<div class="row">
										<div class="col-md-4"></div>
										<div class="col-md-4"><h4><u>Ads Manager</u></h4></div>
										<div class="col-md-4"></div>
									</div><br>
									<?php 
										$sql = "SELECT * FROM ads order by id desc limit 1";
										$stmt3 = $connection->query($sql);
										$text="";
										$redirectUrl="";
										//echo mysql_error();
										if ( $stmt3 ){ 
											while( $row3 = $stmt3->fetch_assoc()){ 
												$text=$row3['text'];
												$redirectUrl=$row3['redirectUrl'];
												$imageUrl=$row3['imageUrl'];
											}
										}				
									?>
                                    <div class="row" style="display:none">
										<div class="col-md-3">
											<h5 style="padding:10px 12px 12px 0;display: inline-block;">Description</h5>
										</div>
										<div class="col-md-7">
											<input type="text" name="text" value="<?=$text?>" placeholder="Ad description..." required>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<h5 style="padding:10px 12px 12px 0;display: inline-block;">Redirect Url</h5>
										</div>
										<div class="col-md-7">
											<input type="text" name="redirectUrl" value="<?=$redirectUrl?>" placeholder="redirect url..." required>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<h5 style="padding:10px 12px 12px 0;display: inline-block;">Media</h5>
										</div>
										<div class="col-md-7">
											<input type="file" name="file" id="file">
										</div>
									</div><br>
									<div class="row">
										<div class="col-md-3">
											<h5 style="padding:10px 12px 12px 0;display: inline-block;">Preview</h5>
										</div>
										<div class="col-md-7">
											<img src="uploadFiles/<?=$imageUrl?>" id="imageAd" style="height:100px">
										</div>
									</div><br>
									
									<div class="row">
										<div class="col-md-5"></div>
										<div class="col-md-4">
											<input type="submit" name="saveButton" value="Save" class="btn btn-primary">	
										</div>	
										<div class="col-md-3"></div>
									</div>
									</form>
                                </div>
                            </div>
							<div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </section><!-- End off test section -->

                <div class="main_footer fix bg-mega text-center p-top-40 p-bottom-30 m-top-80">
                    <div class="col-md-12">
                        <p class="wow fadeInRight" data-wow-duration="1s">
                            Admin Portal
                        </p>
                    </div>
                </div>

        </div>

        <!-- JS includes -->

        <script src="assets/js/vendor/jquery-1.11.2.min.js"></script>
        <script src="assets/js/vendor/bootstrap.min.js"></script>
		
        <script src="assets/js/owl.carousel.min.html"></script>
        <script src="assets/js/jquery.magnific-popup.js"></script>
        <script src="assets/js/jquery.easing.1.3.js"></script>
        <script src="assets/css/slick/slick.js"></script>
        <script src="assets/css/slick/slick.min.js"></script>
        <script src="assets/js/jquery.collapse.js"></script>
        <script src="assets/js/bootsnav.js"></script>

        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>
		<link href="assets/css/jquery.multiselect.css" rel="stylesheet" type="text/css">
		<script src="assets/js/jquery.multiselect.js"></script>
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		
		<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
		<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
		<script src="assets/js/mdtimepicker.js"></script>
		<link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">
		
<script>
  $(document).ready(function(){
    $('#timepicker').mdtimepicker(); //Initializes the time picker
  });
  
  function showPreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageAd').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
	    }
	}

	$("#file").change(function(){
		    showPreview(this);
	});
</script>
<script>		
$(function(){
	$( ".datepicker1" ).datepicker({ 
		dateFormat: 'dd-mm-yy',
		minDate: 0		
	}).val();
});
</script>
<script>
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
});
</script>
<script>
$(":radio").change(function(){
	var teamValue = jQuery('input[name=team]:checked').val();
	$.ajax({
	 type : 'post',
	 url : 'memberNameValue.php',
	 data : {teamValue:teamValue},
	success : function(data)
	{
		$('#members').html(data);
	}
	});
});	
</script>
		
		
    </body>
<?php }else{ ?>

<body data-spy="scroll" data-target=".navbar-collapse">
        <div class="culmn">
			<?php include('header.php'); ?>
		
<?php 
$sql = "select * from Tip where id = '".$_GET['edit']."'";
$result = $connection->query($sql);
$row = $result->fetch_assoc();
?>
<?php 
if(isset($_POST['update']))
{
	extract($_POST);
	$sSql = "update Tip set title = '$title' , description = '$description' , datetime = 'now()' where id = '".$_GET['edit']."'";
	$sResult = $connection->query($sSql);

	$rSql = "insert into history(title,description,assignto,media,datetime,assignby,type,status,Tipid)values('$title','$description','".$row['assignto']."','".$row['media']."',now(),'".$_COOKIE['id']."','Tip','Edit','".$_COOKIE['id']."')";
	$rResult = $connection->query($rSql);
	
	echo "<script>window.location.href='dashboard.php'</script>";
}
?>	
            <!--Test section-->
            <section id="test" class="test roomy-60 fix">
                <div class="container" style="margin-top: 3%;">
                    <div class="row">                        
                        <div class="main_test fix">
							<div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="test_item fix">
									<form method="post" >
										<div class="row">
											<div class="col-md-4"></div>
											<div class="col-md-4"><h4><u>Edit Tip</u></h4></div>
											<div class="col-md-4"></div>
										</div><br>
										<div class="row">
											<div class="col-md-3">
												<h5 style="padding:10px 12px 12px 0;display: inline-block;">Tip title</h5>
											</div>
											<div class="col-md-7">
												<input type="text" name="title" placeholder="Title" value="<?php echo $row['title']?>" required>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3">
												<h5 style="padding:10px 12px 12px 0;display: inline-block;">Tip description</h5>
											</div>
											<div class="col-md-7">
												<textarea name="description" placeholder="Description" style="height:116px;" required><?php echo $row['description']?></textarea>
											</div>
										</div><br>
										<!--<div class="row">
											<div class="col-md-3">
												<h5 style="padding:10px 12px 12px 0;display: inline-block;">Media</h5>
											</div>
											<div class="col-md-7">
												<input type="file" name="file[]" multiple="multiple">
											</div>
										</div><br>-->
										<div class="row">
											<div class="col-md-3">
												<h5>Copy to</h5>
											</div>
											<div class="col-md-7">
												<link href="assets/css/jquery.multiselect.css" rel="stylesheet" type="text/css">
												<script src="assets/js/jquery.multiselect.js"></script>
												<select name="copy[]" id="copy" style="padding:5px;" multiple="multiple">
												<?php
													$pSql = "select * from users where type = '2' and id != '".$_COOKIE['id']."'";
													$pResult = $connection->query($pSql);
													while($pRow = $pResult->fetch_assoc()){
												?>
												<option value="<?php echo $pRow['id']?>">  <?php echo $pRow['name'];?>  </option>
												<?php } ?>
												</select>
											</div>
											<script>
											$('#copy').multiselect({
												columns: 1,
												placeholder: 'Select name'
											});
											</script>
										</div><br>
										<div class="row">
											<div class="col-md-5"></div>
											<div class="col-md-4">
												<input type="submit" name="update" value="Update" class="btn btn-primary">	
											</div>	
											<div class="col-md-3"></div>
										</div>
									</form>
                                </div>
                            </div>
							<div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </section><!-- End off test section -->




                <div class="main_footer fix bg-mega text-center p-top-40 p-bottom-30 m-top-80">
                    <div class="col-md-12">
                        <p class="wow fadeInRight" data-wow-duration="1s">
                            CrickExpert Portal
                        </p>
                    </div>
                </div>




        </div>

        <!-- JS includes -->

        <script src="assets/js/vendor/jquery-1.11.2.min.js"></script>
        <script src="assets/js/vendor/bootstrap.min.js"></script>
		
        <script src="assets/js/owl.carousel.min.html"></script>
        <script src="assets/js/jquery.magnific-popup.js"></script>
        <script src="assets/js/jquery.easing.1.3.js"></script>
        <script src="assets/css/slick/slick.js"></script>
        <script src="assets/css/slick/slick.min.js"></script>
        <script src="assets/js/jquery.collapse.js"></script>
        <script src="assets/js/bootsnav.js"></script>



        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>

<?php } ?>
</html>

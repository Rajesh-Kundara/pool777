<?php 
session_start();
include('config.php');
include('send_notification.php');
if($_COOKIE['fullname'] == '')
{
	echo "<script>window.location.href='index.php?q=error'</script>";
}
?>

<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="assets/images/logo.png" sizes="16x16">
	<title>Admin Portal : Tips</title>
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
if(!empty($_POST['saveButton']) || !empty($_POST['updateButton']))
{
	$date = date('Y-m-d H:i:s');
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
	$itemText=$_POST['itemText'];
	
	$title="";
	$message="";
	if($id=="0"){
		if($isImageNull)
			$sql = "insert into tips(text,date) values('$itemText',NOW())";	
		else
			$sql = "insert into tips(text,imageUrl,date) values('$itemText','$files',NOW())";	
				
		$title="New Free Tip added.";
		$message=$itemText;
	}else{
		if($isImageNull)
			$sql = "update tips set text='$itemText',date=NOW() where id=$id";	
		else
			$sql = "update tips set text='$itemText',imageUrl='$files',date=NOW() where id=$id";	
	}
	//echo $sql;die;
	$result = $connection->query($sql);
	$idValue = mysql_insert_id();

	if(strlen($title)>0){
		send_notification($title,$message,"freeTips");
	}
	echo "<script>window.location.href='tips.php'</script>";
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
                            <div class="col-md-12">
                                <div class="test_item fix">
									<form method="post" enctype="multipart/form-data" >
									<div class="row">
										<div class="col-md-4"></div>
										<div class="col-md-4"><h4><u>Free Tips</u></h4></div>
										<div class="col-md-4"></div>
									</div><br>
                                    <div class="row">
										<div class="row content_top">
										<div class="col-lg-12">
											<div class="col-md-12" style='margin-right:-5%'>
												<div class="panel panel-info"> 
													<div class='panel-body'>
														<div class='row'>			
															<div class="col-md-4">
																 <div class="panel panel-info"> 
																	 <div class='panel-body' style='font-size:82%;'>							 
																		<div class="form-group">
																			<label class='control-label col-md-13' for="workingHoursFrom">Premium Tip :</label>
																			<div  class="col-md-13">
																				<label class='control-label col-md-13' id="invetoryItemCode" for="workingHoursFrom"></label>
																				<label class='control-label col-md-13' id="invetoryItemName" for="workingHoursFrom"></label>
																			</div>										                
																		</div>
																	
																		<form method="post"> 
																		<div class="form-group">
																			<label class='control-label col-md-13' for="workingHoursFrom">Tip Text</label>
																			<div  class="col-md-13">
																				<textarea type="text" style="height:200px" class="form-control input-sm" name="itemText" id="itemText" path="code" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9.-_&*()@\s]/g, '')" maxlength="500"></textarea>
																			</div>										                
																		</div>
																		<div class="form-group">
																			<label class='control-label col-md-13' for="workingHoursFrom">Image :</label>
																			<div class="col-md-13">
																				<input type="file" name="file">
																			</div>
																		</div><br>
																		<div class="form-group">
																			<input type='submit'  class="btn btn-success btn-sm" value='Add'	id="saveButton" name="saveButton" style="width:30%">
																			<input type='submit'  class="btn btn-info btn-sm" value='Update'	id="updateButton" name="updateButton" onclick="saveOrUpdate()" disabled style="width:30%">
																			<input type='reset'   class="btn btn-primary btn-sm" value='Reset'	id="resetButton"  onclick="resetData()" style="width:30%">
																			<input type="hidden" id="idForUpdate" name="idForUpdate" value="0">
																		</div>
																		</form>
																	</div>
																</div>
															</div>	
															<div class="col-md-8">
																<div class="panel panel-info"> 
																	<div class='panel-body' id="dataTableGrid" style='font-size:82%;'>	
																	<?php
																	$string ="<table id='DataGrid' align='center' width='100%' border='1' class='table dt-responsive'>
																			<thead>
																		  	<tr  style='color:black'>
																		  	<th width='10%' align='center'><b>S. No.</b></th>
																		  	<th width='50%' ><b align='center'>Tip Text</b></th>
																			<th width='20%' ><b align='center'>Image</b></th>
																		  	<th width='8%' align='center'><b>Status</b></th>
																			<th width='12%' align='center'><b>Action</b></th>
																			</tr>
																		  	</thead>
																		  	<tbody>"; 
																	$sr=0;
																	$idForUpdate=0;

																	$sql = "SELECT * FROM tips";
																	$stmt3 = $connection->query($sql);
																	if ( $stmt3 ){ 
																		while( $row3 = $stmt3->fetch_assoc()){ 
																			$imgStatus=($row3['imageStatus']==="A")?"ic_shown.png":"ic_hidden.png";
																			$imgTitle=($row3['imageStatus']==="A")?"Click to Hide":"Click to Show";
																			$string=$string."<tr style='height:20px;color:black;'>
																				<td id='sr_".$sr."' align='center'>".($sr+1)."</td>
																				<td ><pre id='name_".$sr."' style='max-width:350px;word-wrap:break-word;display:block;'>".$row3['text']."</pre></td>
																				<td id='image_".$sr."' align='center'><img src='uploadFiles/".$row3['imageUrl']."' style='height:100px;'/>
																				<img onClick='deleteItem(".$sr.");' src='images/$imgStatus' border='0' title='$imgTitle' width='20' height='20' style='margin:0 10 0 10'/>
																				<input type='hidden' id='imageStatus_".$sr."' value='".$row3['imageStatus']."'>
																				</td>
																				<td id='status_".$sr."' align='center'>".$row3['status']."</td>
																				<td align='center'>
																				<img onClick='edit(".$sr.");' src='images/editButton.png' border='0' title='Edit' width='16' height='16' />
																				<input type='hidden' id='idForUpdate_".$sr."' value='".$row3['id']."'>
																				</td>
																				</tr>";
																				$sr++;
																		}
																	}	else{
																		echo "no records found.". $stmt3->error();
																	}			
																	$string=$string."</tbody></table>";
																	echo $string;
																	?>
																	</div>
																</div>
															 </div>
														</div>
														<div class='row'>
															<div class="com-md-5">
																<div class="form-group">
																<!-- Error Message Div -->
																	<table border=0 width="80%" align='center'>
																		<tr><td colspan=3><div style="margin-left:10%;margin-right:10%width:95%;height:80px;color:red;overflow:auto;display:none" id="error" class="error"></div></td></tr>
																	</table>
																<!-- Success Message Div -->
																	<table border=0 width="80%" align='center'>
																		<tr><td><div style="margin-left:10%;margin-right:10%width:100%;height:80px;display:none;color:green" id="info" class="success"></div></td></tr>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
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
		
		<script src="js/jquery.dataTables.min.js"></script>
		<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
		
		<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
		<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>
		<script src="assets/js/mdtimepicker.js"></script>
		<link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">
		
<script>
  $(document).ready(function(){
    $('#timepicker').mdtimepicker(); //Initializes the time picker
	
	$('#DataGrid').dataTable({
		"bLengthChange": false,
		"pageLength": 5,
		responsive:true,
	});
	
	/*$(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });*/
  });
  
  function saveOrUpdate() {
	  	var idForUpdate= $('#idForUpdate').val();
	  	
	  	var form_data = new FormData();
	  	form_data.append("stock", $('#stock').html());
	  	form_data.append("purchasePrice", $('#purchasePrice').val());
		form_data.append("idForUpdate", idForUpdate);
		//document.getElementById("addButton").disabled=true;
	  	
		$.ajax({
		    type: "POST",  	
		    url: rootPath+"saveOrUpdateInventoryItem.html",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "pageNumber=" + pageNumber+"&masterId="+masterId+"&code=" + code+"&name=" + name + "&remark=" + remark + "&idForUpdate=" + idForUpdate,  
		    success: function(response){
		      	if(response.status == "Success"){
			    	$('#info').html(response.result);
			    	$('#dataTableGrid').html(response.dataGrid);
			    	//$('#dataTable2').html(response.dataGrid);
			    	resetData();
				    $('#error').hide('slow');
				    $('#info').show('slow');
				    addClassForColor();
				    $('#GeneralMasterDataGrid').dataTable({
				    	"bLengthChange": false,
						"pageLength": 5,
						responsive:true,
					});
				}
				else if(response.status == "Errors"){
			    	errorInfo = "";
			    	for(i =0 ; i < response.result.length ; i++){
						errorInfo += "<br>" + (i + 1) +". " + response.result[i].code;
					}
					$('#error').html("Please correct following errors: " + errorInfo);
					$('#info').hide('slow');
					$('#error').show('slow');
				}	   
		      	else{
					$('#error').html(response.result);
					$('#info').hide('slow');
					$('#error').show('slow');
				}
			},  
		    error: function(e){  
		      alert(e.status);
	           alert(e.responseText);
	           alert(thrownError);
		    }  
		});  
	  	document.getElementById("addButton").disabled=false;
	}  
	
  function edit(formFillForEditId) {
		$('#itemText').val($('#name_'+formFillForEditId).html());
		
	  	document.getElementById("saveButton").disabled=true;
	  	document.getElementById("updateButton").disabled=false;
		
		var idForUpdate=$('#idForUpdate_'+formFillForEditId).val();
		
	  	$('#idForUpdate').val(idForUpdate);
	  	
	}
	
	function deleteItem(sr) {
		//if(confirm('Are you sure you want to delete this Record?')){
			var idForUpdate= $('#idForUpdate_'+sr).val();
			var status = $('#imageStatus_'+sr).val();
			var updatedStatus=(status=="A")?"I":"A";
			//alert(updatedStatus);
			var form_data = new FormData();
			form_data.append("id", idForUpdate);
			form_data.append("status", updatedStatus);
			$.ajax({  
			    type: "POST",  	
			    //url: "/CrickExpert/wservices/updateTipImageStatus.php", 
				url: "/wservices/updateTipImageStatus.php",  
			    //data: "pageNumber=" + pageNumber+"&idForDelete="+idForDelete,
			    processData: false,
			    contentType: false,
			    data: form_data,
			    success: function(response){
			      	window.location.href="?status=success";
				},  
			    error: function(e){  
			      alert('Error: ' + e);  
			    }  
			});  
		 //}
	}
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

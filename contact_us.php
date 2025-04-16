<?php 
include('common/config.php');
if(!isset($_SESSION['fullname']))
{
	//echo "<script>window.location.href='index.php'</script>";
}
?>

<html class="no-js" lang="en">
<?php 
include('common/head.php');

?>

<?php 
ini_set("display_errors","on");
?>	
	
<body data-spy="scroll" data-target=".navbar-collapse">
<?php include('common/header.php'); ?>
<div class="culmn">
	<div class="container px-0">
		<?php 
		if(isset($_SESSION['id'])){
			$sql = "SELECT * FROM users WHERE id='".$_SESSION['id']."'";
			// $sql = "SELECT * FROM users WHERE id='1'";
			$stmt = $connection->query($sql);
			if ( $stmt ){
				while( $row = $stmt->fetch_assoc()){
					$firstName=$row['f_name'];
					echo $middleName=$row['m_name'];
					$lastName=$row['l_name'];
					$fullName=trim($firstName." ".$middleName);
					$fullName=trim($fullName." ".$lastName);
					$email=$row['email'];
					$countryCode=$row['countryCode'];
					$phone=$row['phone'];
					$countryId=$row['countryId'];
				}
			}
		}else{
					$firstName="";
					echo $middleName="";
					$lastName="";
					$fullName="";
					$fullName="";
					$email="";
					$countryCode="";
					$phone="";
					$countryId="";
		}
		
		
		?>
	  <div class="row border border-top-0 mx-0">
		<table width="100%">
			<tr>
				<td align="center">
					<div class="col" style="max-width:380px;">
						<form class="px-2 py-1">
							<div class="card mb-3">
								<div class="card-header bg-primary text-white text-center p-2" >Contact Us</div>
								<div class="card-body p-2">
									<div class="form-group text-left">
									  <label class="text-left" for="userName">Name :</label>
									  <input type="text" class="form-control" id="fullName" placeholder="full name" value="<?=$fullName?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">E-mail :</label>
									  <input type="text" class="form-control" id="email" placeholder="email" value="<?=$email?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Phone :</label>
									  <div class="input-group">
										  <div class="input-group-prepend">
											<input type="text" class="input-group-text" style="width:80px;background-color:#ffffff" id="countryCode" placeholder="code" value="<?=$countryCode?>">
										  </div>
										  <input type="tel" class="form-control" id="phone" placeholder="phone" value="<?=$phone?>">
									  </div>
									</div>
									<div class="form-group text-left">
									  <label for="text">Country :</label>
									  
										<?php
										$sql = "SELECT * FROM countries";
										$result = $connection->query($sql);
										$string="<select id='countries' name='countries' class='form-control'><option value='0'>--select--</option>";
										if ( $result ){
											while( $row = $result->fetch_assoc()){
												$string=$string.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
										}
										$string=$string.'</select>';
										echo $string;
										?>
									</div>
									<div class="form-group text-left">
									  <label for="text">Contact purpose :</label>
									  <select id="purpose" name="purpose" class="form-control">
										<option value="0">User support</option>
										<option value="0">Deposit cash</option>
										<option value="0">General information</option>
										<option value="0">Agency information</option>
										<option value="0">Cashout claim</option>
									</select>
									</div>
									<div class="form-group text-left">
									  <label for="text">Contact description :</label>
									  <textarea type="text" class="form-control" id="description" placeholder="description..."></textarea>
									</div>
									<button type="button" onClick="sendContactDetail()" class="btn btn-info">Send</button>
									
									<div id="errorContainer" class="mt-2"></div>
								</div>
							</div>
							
						</form>
					</div>
				</td>
			</tr>
		</table>
	  </div>
	</div>

<?php include('common/footer.php'); ?>
</div>
 <div id="modalInfo" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalInfoTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalInfoBody"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="javascript:location.reload();">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- JS includes -->

<!--<script src="../assets/js/owl.carousel.min.html"></script>
<script src="../assets/js/jquery.magnific-popup.js"></script>
<script src="../assets/js/jquery.easing.1.3.js"></script>
<script src="../assets/css/slick/slick.js"></script>
<script src="../assets/css/slick/slick.min.js"></script>
<script src="../assets/js/jquery.collapse.js"></script>
<script src="../assets/js/bootsnav.js"></script>-->

<!--<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/main.js"></script>
<link href="../assets/css/jquery.multiselect.css" rel="stylesheet" type="text/css">
<script src="../assets/js/jquery.multiselect.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="../resources/demos/style.css">-->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="../assets/js/vendor/jquery-3.2.1.slim.min.js"></script>-->
<script src="assets/js/vendor/popper.min.js"></script>
<script src="assets/js/vendor/bootstrap.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>
<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- material datepicker -->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
<!--<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>-->
<script src="assets/js/mdtimepicker.js"></script>
<link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">

<script>
	
	function sendContactDetail() {
		$("#error").alert('close');

		var form_data = new FormData();
		var fullName=$("#fullName").val();
		var email=$("#email").val();
		var countryCode=$("#countryCode").val();
		var phone=$("#phone").val();
		var countryId=$("#countries").val();
		var purpose=$("#purpose option:selected").text();
		var description=$("#description").val();
		
		form_data.append("fullName", fullName);
		form_data.append("email", email);
		form_data.append("countryCode", countryCode);
		form_data.append("phone", phone);
		form_data.append("countryId", countryId);
		form_data.append("purpose", purpose);
		form_data.append("description", description);
		
		if(fullName.length==0){
			alert("Please enter full name!"); return;
		}
		if(email.length==0){
			alert("Please enter email!"); return;
		}
		if(description.length==0){
			alert("Please enter description!"); return;
		}
		
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/saveContactUs.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	
				    $('#modalInfo').modal('show');
				}else{
					var html='<div id="error" class="alert alert-danger fade show" role="alert">'+response.message+'</div>';
					$("#errorContainer").html(html);
				}
			},  
		    error: function(e){  
		      alert(e.status);
	           alert(e.responseText);
	           alert(thrownError);
		    }
		});  
	}
</script>
<?php echo "<script>document.getElementById('countries').value=$countryId;</script>"; ?>
    </body>

</html>

<?php 
include('common/config.php');
session_destroy();

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
	<div class="container px-1">
	  <div class="row border my-4 mx-0">
		<table width="100%">
			<tr>
				<td align="center">
					<div class="col" style="max-width:380px;">
						<form class="px-1 py-1">
							<?php
							if(empty($_GET['token'])){
							?>
							<div id="divResetPassword" class="card mb-3">
								<div class="card-header text-center p-1" >Reset Password</div>
								<div class="card-body p-2">
									<div class="form-group text-left">
									  <label for="userName">Enter Username / Email :</label>
									  <input type="text" class="form-control" id="userNameValue" placeholder="username or email">
									</div>
									<button type="button" id="btnSubmit" onClick="resetPassword()" class="btn btn-primary">Reset password</button>
									
									<div id="errorContainer" class="mt-2"></div>
								</div>
							</div>
							<?php }else{ ?>
							<div id="divResetPassword" class="card mb-3">
								<form class="px-4 py-1">
								<div class="card-header text-center p-1" >Reset Password</div>
								<div class="card-body p-2">
									<div class="form-group text-left">
									  <label for="userName">New Password :</label>
									  <input type="password" class="form-control" id="newPassword" placeholder="new password">
									</div>
									<div class="form-group text-left">
									  <label for="userName">Confirm Password :</label>
									  <input type="password" class="form-control" id="confPassword" placeholder="confirm password">
									</div>
									<button type="button" id="btnSubmitNewPassword" onClick="submitNewPassword()" class="btn btn-primary">Submit</button>
									
									<div id="errorContainer" class="mt-2"></div>
								</div>
								</form>
							</div>
							<?php }?>
							<div id="divResetPasswordSuccess" style="display:none" class="card mt-4 mb-3">
								<div class="card-header text-center text-white p-1 bg-success">Success</div>
								<div class="card-body p-2">
									<p class="card-text" id="message"></p>
									<!--<a href="<?=$host;?>" class="btn btn-primary">Login</a>-->
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="javascript:window.location.href='reset_password.php?success=true';">Close</button>
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
$(document).ready(function() {
  $('#userNameValue').keyup(function() {
    //$("#btnSubmit").removeAttr("disabled");
	$("#btnSubmit").prop("disabled",false);
  });
  
  $('#newPassword').keyup(function() {
    //$("#btnSubmit").removeAttr("disabled");
	$("#btnSubmitNewPassword").prop("disabled",false);
  });
  $('#confPassword').keyup(function() {
    //$("#btnSubmit").removeAttr("disabled");
	$("#btnSubmitNewPassword").prop("disabled",false);
  });
});
	function resetPassword() {
		$("#error").alert('close');
		$("#btnSubmit").prop("disabled",true);
		var form_data = new FormData();
		var userName=$("#userNameValue").val();
		
		if(userName.length==0){
			alert("Please enter username/email!"); return;
		}
		form_data.append("userName", userName);
				
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/resetPassword.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					/*$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	
				    $('#modalInfo').modal('show');*/
					
					$("#divResetPassword").attr("style","display:none")
					$('#divResetPasswordSuccess').attr("style","display:block")
					$('#message').html(response.message);
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
	function submitNewPassword(){
		$("#error").alert('close');
		//$("#btnSubmitNewPassword").prop("disabled","disabled");
		$("#btnSubmitNewPassword").prop("disabled",true);
		var form_data = new FormData();
		var password=$('#newPassword').val();
		var confPassword=$("#confPassword").val();
		
		if(password.length==0 || newPassword.length==0){
			alert("Please enter new password!"); return;
		}
		if(password!=confPassword){
			alert("Confirm password doesnot match!"); return;
		}
		form_data.append("token", <?="'".$_GET['token']."'"?>);
		form_data.append("password", password);
				
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/resetPassword.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					/*$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	
				    $('#modalInfo').modal('show');*/
					
					$("#divResetPassword").attr("style","display:none")
					$('#divResetPasswordSuccess').attr("style","display:block")
					$('#message').html(response.message);
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
    </body>

</html>

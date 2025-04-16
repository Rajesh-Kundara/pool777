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
							if(empty($_GET['success'])){
							?>
							<div class="card mb-3">
								<div class="card-header text-center p-1" >Register</div>
								<div class="card-body p-2">
									<div class="form-group text-left">
									  <label for="userName">Username :</label>
									  <input type="text" class="form-control" id="userNameValue" placeholder="username">
									</div>
									<div class="form-group text-left">
									  <label for="text">Password :</label>
									  <input type="password" class="form-control" id="passwordValue" placeholder="password">
									</div>
									<div class="form-group text-left">
									  <label for="text">Re-enter Password :</label>
									  <input type="password" class="form-control" id="rePassword" placeholder="re-enter password">
									</div>
									<!--<div class="form-group text-left">
									  <label class="text-left" for="firstName">First Name :</label>
									  <input type="text" class="form-control" id="firstName" placeholder="first name">
									</div>
									<div class="form-group text-left">
									  <label for="text">Middle Name :</label>
									  <input type="text" class="form-control" id="middleName" placeholder="middle name">
									</div>
									<div class="form-group text-left">
									  <label for="text">Last Name :</label>
									  <input type="text" class="form-control" id="lastName" placeholder="last name">
									</div>
									<div class="form-group text-left">
									  <label for="text">Company :</label>
									  <input type="text" class="form-control" id="company" placeholder="company ">
									</div>
									<div class="form-group text-left">
									  <label for="text">E-mail :</label>
									  <input type="text" class="form-control" id="email" placeholder="email">
									</div>-->
									<div class="form-group text-left">
									  <label for="text">Phone :</label>
									  <div class="input-group">
										  <div class="input-group-prepend">
										  <?php
										$sql = "SELECT * FROM countries";
										$result = $connection->query($sql);
										$string="<select id='countryCode' name='countries' class='form-control' onChange='getStates(0)'><option value='0'>select</option>";
										if ( $result ){
											while( $row = $result->fetch_assoc( )){
												$string=$string.'<option value="'.$row['code'].'">'.$row['code'].'</option>';
											}
										}
										$string=$string.'</select>';
										echo $string;
										?>
											<!-- <input type="text" class="input-group-text" style="width:80px;background-color:#ffffff" id="countryCode" placeholder="code" value="<?=$countryCode?>"> -->
										  </div>
										  <input type="tel" class="form-control" id="phone" placeholder="phone">
									  </div>
									</div>
									<!--<div class="form-group text-left">
									  <label for="text">GSM :</label>
									  <div class="input-group">
										  <div class="input-group-prepend">
											<input type="text" class="input-group-text" style="width:80px;background-color:#ffffff" id="countryCode_gsm" placeholder="code" value="<?=$countryCode_gsm?>">
										  </div>
										  <input type="text" class="form-control" id="phone_gsm" placeholder="gsm">
									  </div>
									</div>
									<div class="form-group text-left">
									  <label for="text">Country :</label>
										<?php
										/*$sql = "SELECT * FROM countries";
										$result = mysql_query($sql);
										$string="<select id='countries' name='countries' class='form-control' onChange='getStates(0)'><option value='0'>--select--</option>";
										if ( $result ){
											while( $row = mysql_fetch_array( $result)){
												$string=$string.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
										}
										$string=$string.'</select>';
										echo $string;*/
										?>
									</div>
									<div class="form-group text-left">
									  <label for="text">State :</label>
									  <select id='states' name='states' class='form-control'>
										<option value="0">--Select--</option>
									  </select>
									</div>
									<div class="form-group text-left">
									  <label for="text">Street :</label>
									  <input type="text" class="form-control" id="street" placeholder="street">
									</div>
									<div class="form-group text-left">
									  <label for="text">Prefered Currency :</label>
									  <select id="prefCurrency" name="typeId" class="form-control">
										<option value="1">Naira</option>
									</select>
									</div>
									<div class="form-group text-left">
									  <label for="text">General Info :</label>
									  <textarea class="form-control" id="generalInfo"></textarea>
									</div>-->
									<button type="button" onClick="register()" class="btn btn-primary">Register</button>
									
									<div id="errorContainer" class="mt-2"></div>
								</div>
							</div>
							<?php 
							}else{ ?>
							<div class="card mt-4 mb-3">
								<div class="card-header text-center text-white p-1 bg-success">Success</div>
								<div class="card-body p-2">
									<p class="card-text">Registered successfuly!</br>Please login now.</p>
									<!--<a href="<?=$host;?>" class="btn btn-primary">Login</a>-->
								</div>
							</div>
							<?php } ?>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="javascript:window.location.href='register.php?success=true';">Close</button>
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
	/*function getStates(selectStateId){
	  	var countryId= $('#countries').val();
	  	
	  	var form_data = new FormData();
	  	form_data.append("countryId", countryId);
		
		$.ajax({
		    type: "POST",
		    url: "<?=$host?>/api/getStates.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					$('#states').html('<option value="0">--Select--</option>');
					$.each(response.statesList,function(index,state){
						$('#states').append('<option value="'+state.id+'">'+state.name+'</option>');
					});
					$('#states').val(selectStateId);
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
	}  */
	function register() {
		$("#error").alert('close');

		var form_data = new FormData();
		var userName=$("#userNameValue").val();
		var password=$("#passwordValue").val();
		var rePassword=$("#rePassword").val();
		var countryCode=$("#countryCode").val();
		var phone=$("#phone").val();
		/*var firstName=$("#firstName").val();
		var middleName=$("#middleName").val();
		var lastName=$("#lastName").val();
		var company=$("#company").val();
		var email=$("#email").val();
		var countryCode_gsm=$("#countryCode_gsm").val();
		var phone_gsm=$("#phone_gsm").val();
		var countryId=$("#countries").val();
		var stateId=$("#states").val();
		var street=$("#street").val();
		var prefCurrency=$("#prefCurrency").val();*/
		
		/*form_data.append("firstName", firstName);
		form_data.append("middleName", middleName);
		form_data.append("lastName", lastName);
		form_data.append("company", company);
		form_data.append("email", email);*/
		form_data.append("countryCode", countryCode);
		form_data.append("phone", phone);
		/*form_data.append("countryCode_gsm", countryCode_gsm);
		form_data.append("phone_gsm", phone_gsm);
		form_data.append("countryId", countryId);
		form_data.append("stateId", stateId);
		form_data.append("street", street);
		form_data.append("prefCurrency", prefCurrency);*/
		
		if(password!=rePassword){
			alert("Confirm password does not match!"); return;
		}
		form_data.append("userName", userName);
		form_data.append("password", password);
				
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/register.php",  
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
    </body>

</html>

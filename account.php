<?php 
include('common/config.php');
if(!isset($_SESSION['fullname']))
{
	echo "<script>window.location.href='index.php'</script>";
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
		$activePage="account";
		include('common/menu.php');
		
		$sql = "SELECT * FROM users WHERE id='".$_SESSION['id']."'";
		$stmt = $connection->query($sql);
		if ( $stmt ){
			while( $row = $stmt->fetch_assoc( )){
				$firstName=$row['f_name'];
				$middleName=$row['m_name'];
				$lastName=$row['l_name'];
				$company=$row['company'];
				$email=$row['email'];
				$countryCode=$row['countryCode'];
				$phone=$row['phone'];
				$countryCode_gsm=$row['countryCode_gsm'];
				$gsm=$row['phone_gsm'];
				$countryId=$row['countryId'];
				$stateId=$row['stateId'];
				$street=$row['street'];
				$zipcode=$row['zipcode'];
				$prefCurrency=$row['prefCurrency'];
				$bankCountry=$row['bankCountry'];
				$bankName=$row['bankName'];
				$branch=$row['branch'];
				$accountNo=$row['accountNo'];
				$accountName=$row['accountName'];
				$iban=$row['iban'];
				$bankRefCode=$row['bankRefCode'];
				$bankBeneficier=$row['bankBeneficier'];
			}
		}
		?>
	  <div class="row border border-top-0 mx-0">
		<table width="100%">
			<tr>
				<td align="center">
					<div class="col" style="max-width:380px;">
						<form class="px-2 py-1">
							<div id="errorContainer" class="mt-2"></div>
							<div class="card mb-3">
								<div class="card-header text-center p-1" >Personal Detail</div>
								<div class="card-body p-2">
									<div class="form-group text-left">
									  <label class="text-left" for="userName">First Name :</label>
									  <input type="text" class="form-control" id="firstName" placeholder="first name" value="<?=$firstName?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Middle Name :</label>
									  <input type="text" class="form-control" id="middleName" placeholder="middle name" value="<?=$middleName?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Last Name :</label>
									  <input type="text" class="form-control" id="lastName" placeholder="last name" value="<?=$lastName?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Company :</label>
									  <input type="text" class="form-control" id="company" placeholder="company " value="<?=$company?>">
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
									  <label for="text">GSM :</label>
									  <div class="input-group">
										  <div class="input-group-prepend">
											<input type="text" class="input-group-text" style="width:80px;background-color:#ffffff" id="countryCode_gsm" placeholder="code" value="<?=$countryCode_gsm?>">
										  </div>
										  <input type="text" class="form-control" id="phone_gsm" placeholder="gsm" value="<?=$gsm?>">
									  </div>
									</div>
									<div class="form-group text-left">
									  <label for="text">Postal Code :</label>
									  <input type="text" class="form-control" id="zipcode" placeholder="zipcode" value="<?=$zipcode?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Country :</label>
									  
										<?php
										$sql = "SELECT * FROM countries";
										$result = $connection->query($sql);
										$string="<select id='countries' name='countries' class='form-control' onChange='getStates(0)'><option value='0'>--select--</option>";
										if ( $result ){
											while( $row = $result->fetch_assoc( )){
												$string=$string.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
										}
										$string=$string.'</select>';
										echo $string;
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
									  <input type="text" class="form-control" id="street" placeholder="street" value="<?=$street?>">
									</div>
									<button type="button" onClick="updateUserData('personal')" class="btn btn-primary">Update Contact Detail</button>
									
									<div id="errorContainerPersonal" class="mt-2"></div>
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-header text-center p-1" >Account Detail</div>
								<div class="card-body p-2">
									<div class="form-group text-left">
									  	<label for="text">Prefered Currency :</label>
									  	<select id="prefCurrency" name="typeId" class="form-control">
											<option value="1">Naira</option>
										</select>
									</div>
									<div class="form-group text-left">
									  <label for="text">Bank Country :</label>
									  <?php
										$sql = "SELECT * FROM countries";
										$result = $connection->query($sql);
										$string="<select id='bankCountries' name='bankCountries' class='form-control' option value='0'>--select--</option>";
										if ( $result ){
											while( $row = $result->fetch_assoc( )){
												$string=$string.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
											}
										}
										$string=$string.'</select>';
										echo $string;
										?>
									</div>
									<div class="form-group text-left">
									  <label for="text">Bank Name :</label>
									  <input type="text" class="form-control" id="bankName" placeholder="bank name" value="<?=$bankName?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Branch :</label>
									  <input type="text" class="form-control" id="branch" placeholder="branch" value="<?=$branch?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Account # :</label>
									  <input type="text" class="form-control" id="accountNo" placeholder="account no." value="<?=$accountNo?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Account Name :</label>
									  <input type="text" class="form-control" id="accountName" placeholder="account name" value="<?=$accountName?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">International Bank Account Number (IBAN) :</label>
									  <input type="text" class="form-control" id="iban" placeholder="IBAN" value="<?=$iban?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Bank Reference Code :</label>
									  <input type="text" class="form-control" disabled id="bankRefCode" value="<?=$bankRefCode?>">
									</div>
									<div class="form-group text-left">
									  <label for="text">Bank Beneficier :</label>
									  <input type="text" class="form-control" id="bankBeneficier" placeholder="bank beneficier" value="<?=$bankBeneficier?>">
									</div>
									<button type="button" onClick="updateUserData('account')" class="btn btn-primary">Update Account Detail</button>
									
									<div id="errorContainerAccount" class="mt-2"></div>
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-header text-center p-1" >Password</div>
								<div class="card-body p-2">					
									<div class="form-group text-left">
									  <label for="text">Old Password :</label>
									  <input type="password" class="form-control" id="oldPassword" placeholder="old password">
									</div>
									<div class="form-group text-left">
									  <label for="text">New Password :</label>
									  <input type="password" class="form-control" id="newPassword" placeholder="new password">
									</div>
									<div class="form-group text-left">
									  <label for="text">Re-Enter New Password :</label>
									  <input type="password" class="form-control" id="reNewPassword" placeholder="re-eneter new password">
									</div>
									<button type="button" onClick="updateUserData('password')" class="proceed-btn">Change Password</button>
									
									<div id="errorContainerPassword" class="mt-2"></div>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="javascript:window.location.href='account.php';">Close</button>
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
	function getStates(selectStateId){
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
	}  
	function updateUserData(str) {
		$("#error").alert('close');

		var form_data = new FormData();
		form_data.append("tab", str);
		switch(str){
			case "personal":
				var firstName=$("#firstName").val();
				var middleName=$("#middleName").val();
				var lastName=$("#lastName").val();
				var company=$("#company").val();
				var email=$("#email").val();
				var countryCode=$("#countryCode").val();
				var phone=$("#phone").val();
				var countryCode_gsm=$("#countryCode_gsm").val();
				var phone_gsm=$("#phone_gsm").val();
				var zipcode=$("#zipcode").val();
				var countryId=$("#countries").val();
				var stateId=$("#states").val();
				var street=$("#street").val();
				
				form_data.append("firstName", firstName);
				form_data.append("middleName", middleName);
				form_data.append("lastName", lastName);
				form_data.append("company", company);
				form_data.append("email", email);
				form_data.append("countryCode", countryCode);
				form_data.append("phone", phone);
				form_data.append("countryCode_gsm", countryCode_gsm);
				form_data.append("phone_gsm", phone_gsm);
				form_data.append("zipcode", zipcode);
				form_data.append("countryId", countryId);
				form_data.append("stateId", stateId);
				form_data.append("street", street);
				break;
			case "account":
				var prefCurrency=$("#prefCurrency").val();
				var bankCountry=$("#bankCountries").val();
				var bankName=$("#bankName").val();
				var branch=$("#branch").val();
				var accountNo=$("#accountNo").val();
				var accountName=$("#accountName").val();
				var iban=$("#iban").val();
				var bankBeneficier=$("#bankBeneficier").val();
				
				form_data.append("prefCurrency", prefCurrency);
				form_data.append("bankCountry", bankCountry);
				form_data.append("bankName", bankName);
				form_data.append("branch", branch);
				form_data.append("accountNo", accountNo);
				form_data.append("accountName", accountName);
				form_data.append("iban", iban);
				form_data.append("bankBeneficier", bankBeneficier);
				break;
			case "password":
				var oldPassword=$("#oldPassword").val();
				var newPassword=$("#newPassword").val();
				var reNewPassword=$("#reNewPassword").val();
				
				if(oldPassword.length==0){
					alert("Please enter old password!"); return;
				}
				if(newPassword.length==0){
					alert("Please enter new password!"); return;
				}
				if(newPassword!=reNewPassword){
					alert("Confirm password does not match!"); return;
				}
				form_data.append("oldPassword", oldPassword);
				form_data.append("newPassword", newPassword);
				break;
		}
		
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/updateUserData.php",  
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
					
					switch(str){
						case "personal": $("#errorContainerPersonal").html(html); break;
						case "account": $("#errorContainerAccount").html(html); break;
						case "password": $("#errorContainerPassword").html(html); break;
					}
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
<?php 
if(!empty($countryId)){
echo "<script>document.getElementById('countries').value=$countryId; getStates($stateId);</script>\n"; 
}
if(!empty($bankCountry)){
	echo "<script>document.getElementById('bankCountries').value=$bankCountry;</script>\n"; 
}
?>
<?php if(!empty($_GET['error'])){
	$message="";
	switch($_GET['error']){
		case "profile": $message="Please add your profile detail first."; break;
		case "account": $message="Please add your account detail first."; break;
	}
	echo '<script> var html=\'<div id="loginError" class="alert alert-danger fade show" role="alert" style="width:100%;">'.$message.'</div>\';
		$("#errorContainer").html(html);</script>';
}
?>
    </body>

</html>

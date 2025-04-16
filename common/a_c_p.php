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




<script src="../assets/js/vendor/popper.min.js"></script>
<script src="../assets/js/vendor/bootstrap.min.js"></script>

<script src="../js/jquery.dataTables.min.js"></script>
<link href="../css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- material datepicker -->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="../assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
<script src="../assets/js/mdtimepicker.js"></script>
<link href="../assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">

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
<?php 
if(!empty($_GET['error'])){
	$message="";
	switch($_GET['error']){
		case "profile": $message="Please add your profile detail first."; break;
		case "account": $message="Please add your account detail first."; break;
	}
	echo '<script> var html=\'<div id="loginError" class="alert alert-danger fade show" role="alert" style="width:100%;">'.$message.'</div>\';
		$("#errorContainer").html(html);</script>';
}
?>
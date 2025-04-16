<?php 
include('../common/config.php');
?>

<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
	<title>Recharge</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<?php 
ini_set("display_errors","on");
?>

<body data-spy="scroll" data-target=".navbar-collapse">

<div class="culmn">
	<div class="container px-0">
		<?php 
		
		$sql = "SELECT * FROM users WHERE md5(id)='".$_GET['userId']."'";
		$stmt = $connection->query($sql);
		if ( $stmt ){
			while( $row = $stmt->fetch_assoc()){
				$firstName=$row['f_name'];
				$middleName=$row['m_name'];
				$lastName=$row['l_name'];
				$email=$row['email'];
				$countryCode=$row['countryCode'];
				$phone=$row['phone'];
				$countryCode_gsm=$row['countryCode_gsm'];
				$prefCurrency=$row['prefCurrency'];
			}
		}
		?>
	  <div class="row border border-top-0 mx-0">
		<table width="100%">
			<tr>
				<td align="center">
					<div class="col" style="max-width:380px;">
						<form class="px-2 py-1">
							<div class="card mb-3">
								<div class="card-header text-center p-1" >Add money</div>
								<div class="card-body p-2">
									<div class="form-group text-left">
									  <label class="text-left" for="userName">Name :</label>
									  <input type="text" class="form-control" id="fullName" placeholder="first name" value="<?=$firstName?>">
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
									  <label for="text">Amount :</label>
									  <input type="text" class="form-control" id="amount" placeholder="amount in naira" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
									</div>
									<div class="form-group text-left">
									  <label for="text">Prefered Currency :</label>
									  <select id="prefCurrency" name="typeId" class="form-control">
										<option value="1">Naira</option>
									</select>
									</div>
									<button type="button" onClick="addMoney()" class="btn btn-primary" id="btnAddMoney">Add Money</button>
									
									<div id="errorContainer" class="mt-2"></div>
								</div><input type="hidden" id="uId" value="<?=$_GET['userId']?>"/>
							</div>
						</form>
					</div>
				</td>
			</tr>
		</table>
	  </div>
	</div>

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

<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>

<script src="../assets/js/vendor/popper.min.js"></script>
<script src="../assets/js/vendor/bootstrap.min.js"></script>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
	function verifyTransaction(reference){
	  	Android.loadingStart();
		
		var html='<div id="loginError" class="alert alert-info fade show" role="alert" style="width:250px;">Verifying transaction...</div>';
		$("#errorContainer").html(html);
	
	  	var form_data = new FormData();
	  	form_data.append("reference", reference);
		
		$.ajax({
		    type: "POST",
		    url: "<?=$host?>/api/verifyTransaction.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    success: function(response){
				Android.loadingEnd();
				response=JSON.parse(response);
		      	if(response.success == "1"){
					Android.nextActivity();
					/*$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	
				    $('#modalInfo').modal('show');*/
				}else{
					Android.showMessage("Failure!",response.message,false);
					/*var html='<div id="loginError" class="alert alert-danger fade show" role="alert" style="width:250px;">'+response.message+'</div>';
					$("#errorContainer").html(html);*/
					//$("#loginError").show('slow');
				}
			},  
		    error: function(e){  
				Android.loadingEnd();
				Android.showMessage("Failure!",e.status,false);
		    }  
		});  
	  	//document.getElementById("saveButton").disabled=true;
	}  
function addMoney(){
	var name=$("#fullName").val();
	var email=$("#email").val();
	var countryCode=$("#countryCode").val();
	var phone=$("#phone").val();
	var amt=$("#amount").val();
	var uId=$("#uId").val();
	if(email.length==0 || amt.length==0){
		Android.showMessage("Required!","Please enter correct values.",false);
		return;
	}
	amt=amt+"00";
	var html='<div id="loginError" class="alert alert-info fade show" role="alert" style="width:250px;">Transaction starting...</div>';
	$("#errorContainer").html(html);
    var handler = PaystackPop.setup({
      key: 'pk_test_c11871750cfbb8d174463e2b7ab12aa65e4d8c39',
      email: email,
      amount: amt,
      currency: "NGN",
      //ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      metadata: {
         customer: [
            {
                name: name,
                email: email,
                uId: uId,
                phone: countryCode+phone
            }
         ]
      },
      callback: function(response){
          //alert('success. transaction ref is ' + response.reference);
		  //alert(response);
		  verifyTransaction(response.reference);
      },
      onClose: function(){
		  $("#loginError").alert('close');
          Android.showMessage("Failure!","Transaction was not successful.",false);
      }
    });
    handler.openIframe();
  }
	
</script>
</body>

</html>

<?php 
include('config.php');
ini_set("display_errors","on");
if(!isset($_SESSION['fullname']))
{
	echo "<script>window.location.href='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Payment Methode</title>
    <!-- Bootstrap 5.3 CSS -->
    <?php 
        include('head.php');

    ?>
     <style>
       
        .proceed-btn img {
            height: 20px;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar-collapse">

    <div class="container max-width " >
        <div class="container pt-3" id="t-first-div">
        <?php
           BackButton();
           ?>
             <!-- Title -->
            <h3 class="mt-3 ms-4 text-white">Deposit</h3>

            
        </div>

        <div class="container" id="t-second-div" style="height:430px">
        <div class="t-profile-card">
        <!-- Amount Section -->
            <div class="amount-box pt-3 px-3">
                <p class="mb-0">Amount:</p>
                <h3>N<?=$_POST['amount']?>.00</h3>
            </div>

            <!-- Payment Methods Section -->
            <p class="px-3 mt-3 fw-bold">Choose One Payment Method:</p>
            
            <button class="proceed-btn" onclick="addMoney()">
                <img src="images/Paystack-Logo.png" alt="Paystack">
                Paystack
            </button>

           
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>
<script src="https://js.paystack.co/v1/inline.js"></script>
  <script>
    function insertAmount(value) {
        document.getElementById("amount").value = value;
    }
    function verifyTransaction(reference){
	  	
	  	var form_data = new FormData();
	  	form_data.append("reference", reference);
		
		$.ajax({
		    type: "POST",
		    url: "<?=$host?>/api/verifyTransaction.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    success: function(response){
				response=JSON.parse(response);
               
		      	if(response.success == "1"){
                   
					$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	
				    $('#modalInfo').modal('show');
                    location.href = "index.php";
                    
				}else{
					var html='<div id="loginError" class="alert alert-danger fade show" role="alert" style="width:250px;">'+response.message+'</div>';
					$("#errorContainer").html(html);
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
    function addMoney(){
        var name = "<?= $_POST['name'] ?? '' ?>"; 
        var email = "<?= $_POST['email'] ?? '' ?>";
        var countryCode = "<?= $_POST['countryCode'] ?? '' ?>";
        var phone = "<?= $_POST['phone'] ?? '' ?>";
        var amt = "<?= $_POST['amount'] ?? '' ?>";
        var uId = "<?= $_POST['uId'] ?? '' ?>";

        if(email.length === 0 || amt.length === 0){
            alert("Please enter correct values!"); 
            return;
        }
        amt = amt + "00";

        var handler = PaystackPop.setup({
            key: 'pk_test_c11871750cfbb8d174463e2b7ab12aa65e4d8c39',
            email: email,
            amount: amt,
            currency: "NGN",
            metadata: {
                customer: [{
                    name: name,
                    email: email,
                    uId: uId,
                    phone: countryCode + phone
                }]
            },
            callback: function(response){
                verifyTransaction(response.reference); 
                        // window.location.href='index.php';
            },
            onClose: function(){
                alert('window closed');
            }
        });

        handler.openIframe();
    }

  </script>
</body>
</html>

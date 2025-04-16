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
    <title>Withdraw</title>
    <!-- Bootstrap 5.3 CSS -->
    <?php 
        include('head.php');

    ?>
     <style>
       
       
    
    </style>
</head>
<body data-spy="scroll" data-target=".navbar-collapse">

    <div class="container max-width " >
        <div class="container pt-3" id="t-first-div">
        <?php
           BackButton();
           ?>
             <!-- Title -->
            <h3 class="mt-3 ms-4 text-white">Withdraw</h3>

            
        </div>

        <div class="container" id="t-second-div" style="height:550px">
            <div class="t-profile-card">
                <!-- Amount Section -->
                <div class="row justify-content-center">
                        <div class="  col-12">
                            <div class="pt-2">
                                <p class="d-flex justify-content-between">
                                    <span class="text-dark">Withdrawable Amount</span>
                                    <strong>N1000.00</strong>
                                </p>
                                <p class="d-flex justify-content-between">
                                    <span class="text-dark">Balance</span>
                                    <strong>N3000.00</strong>
                                </p>
                                <p class="d-flex justify-content-between">
                                    <span class="text-dark">Unplayed Amount</span>
                                    <strong>N2000.00</strong>
                                </p>                               
                            </div>
                        </div>
                </div>

                <!-- Payment Form -->
                <p class="mt-3 fw-bold">Select Bank:</p>
                <select class="form-control py-2">
                    <option>Select Bank</option>
                    <option>Access Bank</option>
                    <option>GTBank</option>
                    <option>Zenith Bank</option>
                </select>

                <p class="mt-3 fw-bold">Enter Account Number:</p>
                <input class="form-control py-2" type="text" placeholder="Enter Account Number">

                <p class="mt-3 fw-bold">Enter Amount:</p>
                <input class="form-control py-2" type="text" id="amount" placeholder="Enter Amount">

                <button class="proceed-btn " onClick="sendRequest()">Proceed</button>

           
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

<script>
	
	function sendRequest() {
		$("#error").alert('close');

		var form_data = new FormData();
		
		var amount=$("#amount").val();
		if(amount.length==0){
			alert("Please enter amount!"); return;
		}
		form_data.append("amount", amount);
		
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/saveWithdrawRequest.php",  
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
</body>
</html>

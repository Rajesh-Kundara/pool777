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
    <title>Deposit</title>
    <!-- Bootstrap 5.3 CSS -->
    <?php 
        include('head.php');

    ?>
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
            <div class="t-profile-card " style="height:300px">
                <div class="p-3">
                <?php
		
		$sql = "SELECT * FROM users WHERE id='".$_SESSION['id']."'";
		$stmt = $connection->query($sql);
		if ( $stmt ){
			while( $row = $stmt->fetch_assoc( )){
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
		if(empty($firstName) || empty($lastName) || empty($email)){
			echo "<script> window.location.href='account.php?error=profile';</script>";
		}
		?>
                    <form class="px-2 py-1">
							
									<div class="d-none">
									  <label class="text-left" for="userName">Name :</label>
									  <input type="text" class="form-control" id="fullName" placeholder="first name" value="<?=$firstName?>">
									</div>
									<div class="d-none">
									  <label for="text">E-mail :</label>
									  <input type="text" class="form-control" id="email" placeholder="email" value="<?=$email?>">
									</div>
									<div class="d-none">
									  <label for="text">Phone :</label>
									  <div class="input-group">
										  <div class="input-group-prepend">
											<input type="text" class="input-group-text" style="width:80px;background-color:#ffffff" id="countryCode" placeholder="code" value="<?=$countryCode?>">
										  </div>
										  <input type="tel" class="form-control" id="phone" placeholder="phone" value="<?=$phone?>">
									  </div>
									</div>
									<div class="mb-3">
                                        <label class="form-label fw-bold">Enter Deposit Amount</label>
                                        <input type="text" class="form-control text-end fw-bold py-2" id="amount" placeholder="₦ Enter Amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    </div>
                                    <div class="d-flex justify-content-between gap-2 mb-3 flex-wrap">
                                        <button type="button" class="btn btn-light border fw-bold flex-grow-1" onclick="insertAmount(500)">
                                            <span class="d-block text-truncate">₦500</span>
                                        </button>
                                        <button type="button" class="btn btn-light border fw-bold flex-grow-1" onclick="insertAmount(1000)">
                                            <span class="d-block text-truncate">₦1,000</span>
                                        </button>
                                        <button type="button" class="btn btn-light border fw-bold flex-grow-1" onclick="insertAmount(2000)">
                                            <span class="d-block text-truncate">₦2,000</span>
                                        </button>
                                        <button type="button" class="btn btn-light border fw-bold flex-grow-1" onclick="insertAmount(3000)">
                                            <span class="d-block text-truncate">₦3,000</span>
                                        </button>
                                    </div>
									<div class="d-none">
									    <label for="text">Prefered Currency :</label>
									    <select id="prefCurrency" name="typeId" class="form-control py-2">
										    <option value="1">Naira</option>
                                        </select>
									</div>
									<button type="button" onClick="next()" class="proceed-btn" id="btnAddMoney">Next</button>

									<div id="errorContainer" class="mt-2"></div>
								    <input type="hidden" id="uId" value="<?=md5($_SESSION['id'])?>"/>
							
                    </form>
                </div>
            </div>



        </div>
      
    </div>

  <script>
    function insertAmount(value) {
        document.getElementById("amount").value = value;
    }
    
    function next() {
        var name = $("#fullName").val();
        var email = $("#email").val();
        var countryCode = $("#countryCode").val();
        var phone = $("#phone").val();
        var amount = $("#amount").val();
        var amt = $("#amount").val();
        var uId = $("#uId").val();

        if (email.length == 0 || amt.length == 0) {
            alert("Please enter correct values!");
            return;
        }

        var amt = amount + "00";

        // Create and submit a hidden form
        var form = $('<form action="depositeConfirm.php" method="POST"></form>');
        form.append('<input type="hidden" name="name" value="' + name + '">');
        form.append('<input type="hidden" name="email" value="' + email + '">');
        form.append('<input type="hidden" name="countryCode" value="' + countryCode + '">');
        form.append('<input type="hidden" name="phone" value="' + phone + '">');
        form.append('<input type="hidden" name="amount" value="' + amount + '">');
        form.append('<input type="hidden" name="amt" value="' + amt + '">');
        form.append('<input type="hidden" name="uId" value="' + uId + '">');

        $('body').append(form);
        form.submit();
    }


  </script>
</body>
</html>

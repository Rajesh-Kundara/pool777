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
    <title>Profile Edit Page</title>
    <!-- Bootstrap 5.3 CSS -->
    <?php 
     include('head.php');

    ?>
</head>
<body data-spy="scroll" data-target=".navbar-collapse">
    <?php 
		$activePage="account";
		
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
    <div class="container max-width " >
        <div class="container pt-3" id="first-div">
        <?php
           BackButton();
           ?>
        </div>

        <div class="container" id="second-div">
            <div class=" profile-card ">
                <!-- Header Section -->
                <div class="row profile-header">
                    <div class="col-12 col-sm-4">

                    <img src="images/profile-image.png" alt="Profile Image" class="profile-image">
                    </div>
                    <div class="col-12 col-sm-8 text-black">
                        <h6 class="mb-1"><span class="fw-bold">Username:</span> <?=$_SESSION['username']?></h6>
                        <label class="mb-0"><span class="fw-bold">User ID:</span> #4252</label>
                    </div>
                        

                        
                    
                </div>

                <!-- Form Section -->
                <div class="p-3">
                    <form>
                        
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Old Password</label>
                            <input type="password" class="form-control py-2" id="oldPassword" placeholder="old password">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">New Password</label>
                            <input type="password" class="form-control py-2" id="newPassword" placeholder="new password">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Re-Enter New Password</label>
                            <input type="password" class="form-control py-2" id="reNewPassword" placeholder="re-eneter new password">
                        </div>
                        <button type="button" onClick="updateUserData('password')" class="proceed-btn">Change Password</button>
                        
                        <div id="errorContainerPassword" class="mt-2"></div>
                    </form>
                </div>
            </div>
        </div>
      
    </div>

    <?php
    include "common/a_c_p.php";
  ?>
</body>
</html>

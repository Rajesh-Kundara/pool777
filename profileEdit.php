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
                <div class="px-3 pb-3">
                    <form>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="userName">First Name</label>
                            <input type="text" class="form-control py-2" id="firstName" placeholder="first name" value="<?=$firstName?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Middle Name</label>
                            <input type="text" class="form-control py-2" id="middleName" placeholder="middle name" value="<?=$middleName?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Last Name</label>
                            <input type="text" class="form-control py-2" id="lastName" placeholder="last name" value="<?=$lastName?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Company</label>
                            <input type="text" class="form-control py-2" id="company" placeholder="company " value="<?=$company?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">E-mail</label>
                            <input type="text" class="form-control py-2" id="email" placeholder="email" value="<?=$email?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Phone</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <input type="text" class="input-group-text py-2" style="width:80px;background-color:#ffffff" id="countryCode" placeholder="code" value="<?=$countryCode?>">
                                </div>
                                <input type="tel" class="form-control py-2" id="phone" placeholder="phone" value="<?=$phone?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">GSM</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <input type="text" class="input-group-text py-2" style="width:80px;background-color:#ffffff" id="countryCode_gsm" placeholder="code" value="<?=$countryCode_gsm?>">
                                </div>
                                <input type="text" class="form-control py-2" id="phone_gsm" placeholder="gsm" value="<?=$gsm?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Postal Code</label>
                            <input type="text" class="form-control py-2" id="zipcode" placeholder="zipcode" value="<?=$zipcode?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Country</label>
                            
                            <?php
                            $sql = "SELECT * FROM countries";
                            $result = $connection->query($sql);
                            $string="<select id='countries' name='countries' class='form-control py-2' onChange='getStates(0)'><option value='0'>--select--</option>";
                            if ( $result ){
                                while( $row = $result->fetch_assoc( )){
                                    $string=$string.'<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                }
                            }
                            $string=$string.'</select>';
                            echo $string;
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">State</label>
                            <select id='states' name='states' class='form-control'>
                            <option value="0">--Select--</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="text " class="form-label fw-bold">Street</label>
                            <input type="text" class="form-control py-2" id="street" placeholder="street" value="<?=$street?>">
                        </div>
                        <button type="button" onClick="updateUserData('personal')" class="proceed-btn">Update Contact Detail</button>
                        
                        <div id="errorContainerPersonal" class="mt-2"></div>
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

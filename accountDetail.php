<?php 
include('config.php');
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
    <title>Account Details Edit Page</title>
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
                            <label for="text" class="form-label fw-bold">Prefered Currency</label>
                            <select id="prefCurrency" name="typeId" class="form-control">
                                <option value="1">Naira</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Bank Country</label>
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
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Bank Name</label>
                            <input type="text" class="form-control py-2" id="bankName" placeholder="bank name" value="<?=$bankName?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Branch</label>
                            <input type="text" class="form-control py-2" id="branch" placeholder="branch" value="<?=$branch?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Account #</label>
                            <input type="text" class="form-control py-2" id="accountNo" placeholder="account no." value="<?=$accountNo?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Account Name</label>
                            <input type="text" class="form-control py-2" id="accountName" placeholder="account name" value="<?=$accountName?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">International Bank Account Number (IBAN)</label>
                            <input type="text" class="form-control py-2" id="iban" placeholder="IBAN" value="<?=$iban?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Bank Reference Code</label>
                            <input type="text" class="form-control py-2" disabled id="bankRefCode" value="<?=$bankRefCode?>">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label fw-bold">Bank Beneficier</label>
                            <input type="text" class="form-control py-2" id="bankBeneficier" placeholder="bank beneficier" value="<?=$bankBeneficier?>">
                        </div>
                        <button type="button" onClick="updateUserData('account')" class="proceed-btn">Update Account Detail</button>
                        
                        <div id="errorContainerAccount" class="mt-2"></div>
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

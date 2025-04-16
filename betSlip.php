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
    <title>BetSlip</title>
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
            <h3 class="mt-3 ms-4 text-white">BetSlip</h3>

            
        </div>

        <div class="container" id="t-second-div" style="min-height: 500px; ">
            <div class="t-profile-card h-100 p-3 bg-white rounded-4 shadow-lg" style="">

                <?php
                $sql = "SELECT * FROM stacks WHERE userId='" . $_SESSION['id'] . "'";
                $stmt = $connection->query($sql);
                if ($stmt) {
                    while ($row = $stmt->fetch_assoc()) {
                ?>
                <div class="d-flex bg-color-3 align-items-center justify-content-between p-2 my-2 rounded-3" 
                     style="">
                    <!-- Left Side (Number & Match Name) -->
                    <div class="d-flex align-items-center">
                        <span class="text-white fw-bold me-2"><?=$row['couponId']?></span>
                        <span class="text-white fw-bold"><?= $row['match_name'] ?? 'Match Name' ?></span>
                    </div>

                    <!-- Right Side (Status Button) -->
                    <div>
                        <span class="btn btn-sm fw-bold  bg-color-2" 
                              style=" border-radius: 8px; padding: 5px 20px;color:#9485f0;">
                            <?= strtoupper($row['status'] ?? 'B') ?>
                        </span>
                    </div>
                </div>
                <?php
                    
                    }
                }
                ?>

            </div>
        </div>

      
    </div>

  <script>
   
    
   


  </script>
</body>
</html>

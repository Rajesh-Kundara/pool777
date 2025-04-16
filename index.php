<?php
include('config.php');
$isLoggedIn = false;
if (isset($_SESSION['fullname'])) {
    //echo "<script>window.location.href='index.php'</script>";
    $isLoggedIn = true;
}
?>

<html class="no-js" lang="en">
<?php
include('head.php');

?>
<style>



   
</style>
<?php

if (!empty($_POST['saveButton']) || !empty($_POST['updateButton'])) {
    $id = "0";
    if (!empty($_POST['idForUpdate'])) {
        $id = $_POST['idForUpdate'];
    }
    $itemText = $_POST['itemText'];

    if ($id == "0") {
        $sql = "insert into rules(text,date) values('$itemText',NOW())";
    } else {
        $sql = "update rules set text='$itemText',date=NOW() where id=$id";
    }
    //echo $sql;die;
    $result = $connection->query($sql);
    $idValue = mysql_insert_id();

    echo "<script>window.location.href='rules.php'</script>";
}


?>

<body data-spy="scroll" data-target=".navbar-collapse">
    <div class="max-width container p-0 h-100" id="mainContent" style="background-color: #e3e6ef;">
        <?php include('header.php'); ?>

        <div class="container max-width p-0" style="">
            <div class="container theme-background " style="height: 95px;position: sticky;">

                <div class="container">
                    <div class="d-flex align-items-center justify-content-between text-white">

                        <h3 class="ms-3" id="week">Games</h3>
                        <!-- <span>sort by <i class="fas fa-arrows-up-down fa-1x"></i></span> -->
                    </div>
                </div>



            </div>

            <div class="container" style=" background-color: #e3e6ef;margin-top: -45px; flex:1">
                <?php
                $sql = "SELECT id, typeId, 
                                            (SELECT name FROM coupontypemaster WHERE id = typeId) as name,
                                            (SELECT imageUrl FROM coupontypemaster WHERE id = typeId) as imageUrl,
                                            minStack, minPerLine, ruleDescription, season, matchDate, closeDate, 
                                            couponId, week, weekInfo, status 
                                    FROM coupons 
                                    WHERE week = (SELECT MAX(week) FROM coupons WHERE status = 'A') 
                                    AND status = 'A'  AND couponId IS NOT NULL";

                $stmt = $connection->query($sql); // Execute the query
                $string = ""; // Initialize $string
                $count = 0; // Initialize $count
                $itemsInRow = 4; // Define number of items in a row

                if ($stmt) {
                    $colors = ['#4635af', '#11975f', '#971159']; // Array of colors
                    $btncolors = ['#26187b', '#177b57', '#7a145e']; // Array of colors
                    while ($row = $stmt->fetch_assoc()) {
                        // Process name
                        $name = explode(" - ", $row['name']);
                        $name1 = $name[0];
                        $name2 = isset($name[1]) ? $name[1] : "";
                        $imageUrl = $row['imageUrl'];
                        if ($count % $itemsInRow == 0) { ?>
                            <div class="" style="">
                            <?php
                        }
                        // Select a color dynamically from the array
                        $bgColor = $colors[$count % count($colors)];
                        $btnbgColor = $btncolors[$count % count($btncolors)];
                            ?>

                            <div class="game-card mx-1 " style="background-color: <?= $bgColor ?>;">
                                <div class="d-flex justify-content-between">
                                    <span class="game-date"><?= gmdate('d-m-y', strtotime($row['closeDate'])) ?></span>
                                    <span class="game-bonus">50% Bonus</span>
                                </div>

                                <div class="game-title"><?= $name1 ?></div>

                                <div class="d-flex justify-content-between mt-2">
                                    <button class="btn text-white  btn-sm" style="background-color: <?= $btnbgColor ?>;">Tickets in Draw: 5</button>
                                    <button class="btn text-white  btn-sm" style="background-color: <?= $btnbgColor ?>;" onClick="window.location.href='game.php?coupon=<?php echo $row['couponId']; ?>';">VIEW GAMES</button>
                                </div>
                                <div class="rounded-pill mt-3" style="background-color:#bbbbe3;">
                                    <?php
                                    date_default_timezone_set('Africa/Lagos'); // Set to Nigerian Time
                                    ?>
                                    <div class="col-10 rounded-pill p-2 text-center" style="background-color:#ffffff;">
                                        <span class="text-dark">Game Closes at <?= date('g:i A', strtotime($row['closeDate'])); ?></span>
                                    </div>
                                    <div class="col-2"></div>
                                </div>

                            </div>
                            <div style="height:10px;"></div>
                    <?php
                        $count++;

                        // Close the row after the last item in the row
                        if ($count % $itemsInRow == 0) {
                            $string .= '</div>';
                        }
                    }

                    // Fill up the last row with empty columns if needed
                    while ($count % $itemsInRow != 0) {
                        $string .= '<div class=""></div>';
                        $count++;
                    }
                    // Close the last row
                    $string .= '</div>';
                } else {
                    die("Query failed: " . $connection->error); // Handle query error
                }
                    ?>
                            </div>

            </div>
        </div>

    </div>
    <?php include('footer.php'); ?>
    </div>
    <?php include('profile-card.php'); ?>
    <!-- slack success model -->




</body>

</html>
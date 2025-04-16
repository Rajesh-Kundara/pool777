<?php
include('config.php');

?>

<html class="no-js" lang="en">
<?php
include('head.php');

?>

<?php


$unders = array();
$undersNumber = array();

if (!empty($_GET['week'])) {
    $week = $_GET['week'];
} else {
    $week = "1";
}
?>

<body data-spy="scroll" data-target=".navbar-collapse">
    <div class="max-width container p-0 h-100" id="mainContent" style="background-color: #e3e6ef;">
        <?php
        // $activePage="result";
        include('header.php');
        ?>
        <div class="container max-width p-0" style="background-color: #e3e6ef;">
            <div class="container theme-background max-width" style="position: sticky;">

                <div class="container">
                    <div class="row mx-0 py-3 text-white">
                        <?php
                        $sql = "SELECT a.id,a.name,b.id as couponId,b.under2,b.under3,b.under4,b.under5,
                                b.under6,b.under7,b.under8 FROM coupontypemaster a
                                LEFT JOIN coupons b ON b.typeId=a.id
                                WHERE b.week=$week AND b.status='A'";
                        $result = $connection->query($sql); // Execute the query
                        if ($result) {
                            while ($row = $result->fetch_assoc()) {
                                $name = explode(" - ", $row['name']);
                                $name1 = $name[0];
                        ?>
                                <div class="col">
                                    <button class="rounded coupen-btn text-white p-2 border-0">
                                        <?= $name1 ?>
                                    </button>

                                </div>
                        <?php
                            }
                        } else {
                            // Handle query failure
                            die("Query failed: " . $connection->error);
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class=" py-2 mx-2 mt-2 ">
                <select class="form-select w-75 font-color-2 fw-normal" name="date-range" id="date-range">
                    <option value="1">13-14 Aug - 13-07-2024 05:00</option>
                    <option value="2">13-15 Aug - 15-07-2024 20:00</option>
                    <option value="3">13-16 Aug - 16-07-2024 21:00</option>
                </select>
            </div>


            <div class="card matchcontainer-card mt-2 mx-2">
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-auto d-flex align-items-center ms-4">
                            <?php
                            $checked = isset($status) && $status ? 'checked' : '';
                            $labelText = isset($status) && $status ? 'View Number Only' : 'View Team Name';
                            ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input fs-4 custom-switch-bg ml-0" type="checkbox" id="toggle" <?= $checked ?> onchange="toggleViewResult()">

                            </div>
                            <label class="text-white ms-2" id="toggleLabel"><?= $labelText; ?></label>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded p-2 mx-2">
                    <span class="ms-3 font-color-1" id="week">4 drows 1,3,2.6</span>
                    <!-- <span class="me-3"></span> -->
                </div>
                <div class="container">


                    <div class="row mt-3" id="matchContainer">
                        <?php
                        $sr = 1;
                        $idForUpdate = 0;

                        $sql = "SELECT * FROM matches WHERE week=" . $week . " AND status='A'";
                        $stmt3 = $connection->query($sql);
                        // echo mysql_error();
                        if ($stmt3) {
                            while ($row3 = $stmt3->fetch_assoc()) {
                                $class = "";
                                if ($row3['isResultDeclared']) {
                                    if (($row3['homeScore'] == $row3['awayScore'])) {
                                        if ($row3['homeScore'] > 0 && $row3['isHomeWinner'] > 0) {
                                            $result = "Score Draw";
                                        } else {
                                            $result = "No Score Draw";
                                        }
                                        $class = "text-secondary";
                                    } else if ($row3['isHomeWinner']) {
                                        $result = "Home";
                                        $class = "text-success";
                                    } else if ($row3['isAwayWinner']) {
                                        $result = "Away";
                                        $class = "text-info";
                                    }
                                } else {
                                    $result = "Not declared";
                                    $class = "text-dark";
                                }
                        ?>
                                <div class="numberList col-auto match-item px-1">
                                    <button class="my-2 rounded-circle match-btn" id="btn_match_<?= $sr; ?>">
                                        <?= $sr ?>
                                    </button>
                                    <span class="match-info <?= ($checked) ? '' : 'd-none'; ?>">
                                        <?= $row3['homeTeam']; ?> vs <?= $row3['awayTeam']; ?>
                                    </span>
                                    <!-- <span class="match-info d-none"><?= $row3['homeTeam']; ?> vs <?= $row3['awayTeam']; ?></span> -->
                                    <input type="hidden" id="matchId_<?= $sr; ?>" value="<?= $row3['id']; ?>">
                                    <input type="checkbox" id="cb_match_<?= $sr; ?>" class="d-none">

                                </div>
                        <?php
                                $sr++;
                            }
                        }
                        ?>
                    </div>

                    <!-- <input type="hidden" id="totalMatches" value="<?= $sr; ?>">
                <div id="countMatchesSelected" class="d-none">0</div> -->
                    <!-- Display selected count -->
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
   
    <?php include('profile-card.php'); ?>

</body>

</html>
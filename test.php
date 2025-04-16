<?php
include('config.php');
ini_set("display_errors", "on");
if (!isset($_SESSION['fullname'])) {
    echo "<script>window.location.href='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <!-- Bootstrap 5.3 CSS -->
    <?php
    include('head.php');

    ?>
    <style>
        .filter-buttons button.active {
            background-color: #fff;
            color: #000;
            border: 1px solid #fff;
        }
    </style>

</head>

<body data-spy="scroll" data-target=".navbar-collapse">

    <div class="container max-width ">
        <div class="container pt-3" id="t-first-div">
            <?php
            BackButton();
            ?>
            <!-- Title -->
            <h5 class="mt-2 ms-4 text-white">Transaction History</h5>

            <!-- Date Selector -->
            <div class=" ms-4 date-filter text-white">

                <span>Select Date</span>
            </div>

            <!-- Date Range Buttons -->
            <?php
            $currentFilter = isset($_GET['date']) ? $_GET['date'] : '';
            ?>
            <div class="filter-buttons mt-3 ms-4">
                <!-- <a href="?date=calendar"> -->
                <!-- Calendar Button -->
                <button type="button" id="matchDatec" class="<?= isset($_GET['date']) && preg_match('/\d{4}-\d{2}-\d{2}/', $_GET['date']) ? 'active' : '' ?>">
                    <i class="fas fa-calendar-alt"></i>
                </button>

                <!-- Hidden date input for triggering the date picker -->
                <input type="date" id="hiddenDatePicker" style="display:none;">

                <!-- </a> -->
                <a href="?date=7D">
                    <button class="<?= $currentFilter === '7D' ? 'active' : '' ?>">7D</button>
                </a>
                <a href="?date=28D">
                    <button class="<?= $currentFilter === '28D' ? 'active' : '' ?>">28D</button>
                </a>
                <a href="?date=3M">
                    <button class="<?= $currentFilter === '3M' ? 'active' : '' ?>">3M</button>
                </a>
                <a href="?date=1Y">
                    <button class="<?= $currentFilter === '1Y' ? 'active' : '' ?>">1Y</button>
                </a>
            </div>



        </div>

        <div class="container" id="t-second-div" style="min-height: 420px;">
            <div class="t-profile-card">
                <div class="py-3">
                    <div class="container">

                        <?php
                        $sr = 1;
                        $sql = "SELECT * FROM balance WHERE userId=" . $_SESSION['id'] . " AND status='A' ";

                        if (isset($_GET['date'])) {
                            $dateFilter = $_GET['date'];
                            $today = date('Y-m-d');
                        
                            switch ($dateFilter) {
                                case '7D':
                                    $fromDate = date('Y-m-d', strtotime('-7 days'));
                                    $sql .= " AND date BETWEEN '$fromDate 00:00:00' AND '$today 23:59:59'";
                                    break;
                        
                                case '28D':
                                    $fromDate = date('Y-m-d', strtotime('-28 days'));
                                    $sql .= " AND date BETWEEN '$fromDate 00:00:00' AND '$today 23:59:59'";
                                    break;
                        
                                case '3M':
                                    $fromDate = date('Y-m-d', strtotime('-3 months'));
                                    $sql .= " AND date BETWEEN '$fromDate 00:00:00' AND '$today 23:59:59'";
                                    break;
                        
                                case '1Y':
                                    $fromDate = date('Y-m-d', strtotime('-1 year'));
                                    $sql .= " AND date BETWEEN '$fromDate 00:00:00' AND '$today 23:59:59'";
                                    break;
                        
                                default:
                                    // Check if it's a specific date in YYYY-MM-DD format
                                   
                                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFilter)) {
                                        $sql .= " AND date BETWEEN '$dateFilter 00:00:00' AND '$dateFilter 23:59:59'";
                                    }
                                    break;
                            }
                        }
                        
                         $sql .= " ORDER BY date DESC";
                        $stmt3 = $connection->query($sql);

                        if ($stmt3) {
                            while ($row3 = $stmt3->fetch_assoc()) {
                                // Determine Type and Background Color
                                $bgColor = '';
                                switch ($row3['type']) {
                                    case "S":
                                        $type = "Bet Placed";
                                        $bgColor = 'bg-lightpurple';
                                        break;
                                    case "CP":
                                    case "CS":
                                    case "CA":
                                    case "M":
                                        $type = "Deposit";
                                        $bgColor = 'bg-lightyellow';
                                        break;
                                    case "W":
                                        $type = "Withdraw";
                                        $bgColor = 'bg-lightpink';
                                        break;
                                    case "WS":
                                        $type = "Won";
                                        $bgColor = 'bg-lightgreen';
                                        break;
                                    default:
                                        $type = "Other";
                                        $bgColor = 'bg-lightgray';
                                }
                        ?>
                                <div class="mb-3 p-3 rounded shadow-sm d-flex flex-wrap justify-content-between align-items-start <?= $bgColor; ?>">
                                    <div class="mb-2 me-auto">
                                        <span class="fw-bold"><?= date("d/m/Y H:i", strtotime($row3['date'])); ?></span><br>
                                        <small>ID: <span class="fw-bold"><?= $row3['userId']; ?></span></small>
                                    </div>
                                    <div class="mb-2 me-auto">
                                        <span class="fw-bold">Type: <?= $type; ?></span>
                                    </div>
                                    <div class="text-end fw-bold ms-auto">
                                        <?= number_format($row3['amount'], 2); ?>
                                    </div>
                                </div>
                        <?php
                                $sr++;
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>

            <!-- Custom CSS -->
            <style>
                .bg-lightpurple {
                    background-color: #d6c9ff;
                }

                .bg-lightpink {
                    background-color: #fcd5eb;
                }

                .bg-lightyellow {
                    background-color: #fff7b2;
                }

                .bg-lightgreen {
                    background-color: #d5ffd5;
                }

                .table tr {
                    border-radius: 10px;
                    margin-bottom: 10px;
                    display: flex;
                }

                .table td {
                    display: block;
                    text-align: left;
                }
            </style>

        </div>

    </div>


</body>
<script src="js/jquery.dataTables.min.js"></script>
<!-- material datepicker -->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
<script src="assets/js/mdtimepicker.js"></script>
<link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">
<script>
    // On button click, open datepicker
    document.getElementById('matchDatec').addEventListener('click', function() {
        document.getElementById('hiddenDatePicker').showPicker?.(); // modern browsers
        document.getElementById('hiddenDatePicker').click(); // fallback
    });

    // On date select, redirect using toUrl()
    document.getElementById('hiddenDatePicker').addEventListener('change', function() {
        toUrl(this.value);
    });

    // Redirect function
    function toUrl(date) {
        if (date) {
            window.location.href = "?date=" + date;
        }
    }


    $(document).ready(function() {
        /*$('#matchDate').bootstrapMaterialDatePicker
        ({
            format: 'dddd DD MMMM YYYY - HH:mm'
        });*/
        $('#matchDate').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });
        $('#closeDate').bootstrapMaterialDatePicker({
            weekStart: 0,
            time: false
        });

        //$('#matchDateTime').mdtimepicker(); //Initializes the time picker

        $('#DataGrid').dataTable({
            "bLengthChange": false,
            "pageLength": 5,
            responsive: true,
        });
    });
</script>

</html>
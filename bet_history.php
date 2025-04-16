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
	<title>Bet History</title>
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
			<h3 class="mt-2 ms-4 text-white">Bet History</h3>

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
				<button type="button" id="matchDate" class="<?= isset($_GET['date']) && preg_match('/\d{4}-\d{2}-\d{2}/', $_GET['date']) ? 'active' : '' ?>" value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : '' ?>">
					<i class="fas fa-calendar-alt"></i>
				</button>

				<!-- <input type="date" id="matchDate" style="display:none;"> -->


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

			<div class="b-profile-card">
				<div class="row mt-4 ms-4">
					<div class="col-md-12 col-sm-12 col-12 justify-content-center d-flex align-items-center gap-3">
						<!-- <span class="status pending">
					<i class="status-circle status-pending-badge" style="background-color:#4e32a8;"></i> Pending
				</span> -->
						<span class="status won">
							<i class="status-circle  status-won-badge"></i> Won
						</span>
						<span class="status pending">
							<i class="status-circle bg-warning status-pending-badge"></i> Pending
						</span>
						<span class="status lost">
							<i class="status-circle  status-lost-badge"></i> Lost
						</span>


					</div>

				</div>
				<div class="py-3 px-1">

					<?php
					include('common/functions.php');
					$sr = 1;
					$idForUpdate = 0;
					$string = "";
					//user stacked values on coupon
					$sql = "SELECT id, couponId,week,under2,under3,under4,under5,under6,under7,under8,stackAmount,date,
                            (SELECT COUNT(id) FROM stackdetail WHERE parentId=s.id) as totalSelected FROM stacks s 
                            WHERE userId=" . $_SESSION['id'] . " AND status='A'";
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
					$sql .= "ORDER BY id DESC";
					$stmt3 = $connection->query($sql);
					// echo mysql_error();
					if ($stmt3) {
						while ($row3 = $stmt3->fetch_assoc()) {
							$status = "";
							$ticketId = $row3['id'];
							$week = $row3['week'];

							$betDay = $row3['date'];
							$betDate = gmdate('d/m/y', strtotime($betDay));
							$betTime = gmdate('H:i', strtotime($betDay));
							$stackAmount = $row3['stackAmount'];
							$totalSelected = $row3['totalSelected'];
							$unders = ($row3['under2']) ? "<span class='px-2'>2</span>" : "";
							$unders = $unders . (($row3['under3']) ? "<span class='px-2'>3</span>" : "");
							$unders = $unders . (($row3['under4']) ? "<span class='px-2'>4</span>" : "");
							$unders = $unders . (($row3['under5']) ? "<span class='px-2'>5</span>" : "");
							$unders = $unders . (($row3['under6']) ? "<span class='px-2'>6</span>" : "");
							$unders = $unders . (($row3['under7']) ? "<span class='px-2'>7</span>" : "");
							$unders = $unders . (($row3['under8']) ? "<span class='px-2'>8</span>" : "");

							//to compare with native coupon
							$sql = "SELECT id,typeId,matchDate,closeDate,(SELECT name FROM coupontypemaster WHERE id=typeId) as name,
													under2,under3,under4,under5,under6,under7,under8
													FROM coupons WHERE id=" . $row3['couponId'];
							$result4 = $connection->query($sql);
							$row4 = $result4->fetch_assoc();

							//------------------
							$matchDate = $row4['matchDate'];
							$closeDate = $row4['closeDate'];
							$winnerType;
							$sql = "SELECT COUNT(id) as count FROM matches";
							$suffix = " Draws";
							$winnerType;
							switch ($row4['typeId']) {
								case 1:
									$sql = $sql . " WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week";
									$suffix = " Draws";
									$winnerType = 0;
									break;
								case 2:
									$sql = $sql . " WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=0 AND week=$week";
									$suffix = " Homes";
									$winnerType = 1;
									break;
								case 3:
									$sql = $sql . " WHERE isResultDeclared=1 AND isHomeWinner=0 AND isAwayWinner=1 AND week=$week";
									$suffix = " Aways";
									$winnerType = 2;
									break;
								case 4:
									$sql = $sql . " WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week";
									$suffix = " General Draws";
									$winnerType = 0;
									break;
								case 5:
									$sql = $sql . " WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=1 AND week=$week";
									$suffix = " Score Draws";
									$winnerType = 0;
									break;
								case 6:
								case 7:
								case 8:
								case 9:
								case 10:
									$sql = $sql . " WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week";
									$suffix = " Draws";
									$winnerType = 0;
									break;
							}
							$result6 = $connection->query($sql);
							$row6 = $result6->fetch_assoc();
							$draws = $row6['count'];

							//getting draw range for coupon
							$sql = "SELECT * FROM couponodds WHERE $draws>=dFrom AND $draws<=dTo AND couponId=" . $row3['couponId'];
							$result7 = $connection->query($sql);
							$row7 = $result7->fetch_assoc();
							// $odds2=$row7['odds2'];
							// $odds3=$row7['odds3'];
							// $odds4=$row7['odds4'];
							// $odds5=$row7['odds5'];
							// $odds6=$row7['odds6'];
							// $odds7=$row7['odds7'];
							// $odds8=$row7['odds8'];
							if ($result7 && $result7->num_rows > 0) {
								$row7 = $result7->fetch_assoc();

								$odds2 = isset($row7['odds2']) ? $row7['odds2'] : null;
								$odds3 = isset($row7['odds3']) ? $row7['odds3'] : null;
								$odds4 = isset($row7['odds4']) ? $row7['odds4'] : null;
								$odds5 = isset($row7['odds5']) ? $row7['odds5'] : null;
								$odds6 = isset($row7['odds6']) ? $row7['odds6'] : null;
								$odds7 = isset($row7['odds7']) ? $row7['odds7'] : null;
								$odds8 = isset($row7['odds8']) ? $row7['odds8'] : null;
							} else {
								// Handle the case where no rows are returned
								error_log("No data found for query: $sql");
								$odds2 = $odds3 = $odds4 = $odds5 = $odds6 = $odds7 = $odds8 = null;
							}
							//------------------

							$sql = "SELECT COUNT(id) as winnerCount FROM stackdetail WHERE parentId=" . $row3['id'] . " AND winner=$winnerType";
							$result5 = $connection->query($sql);
							$row5 = $result5->fetch_assoc();
							$winnerCount = $row5['winnerCount'];

							$totalLines = 0;
							$winningLines = 0;
							$winningAmount = 0;
							if ($row3['under2'] && $row4['under2']) {
								$totalLines = $totalLines + getTotalLines($totalSelected, 2);
							}
							if ($row3['under3'] && $row4['under3']) {
								$totalLines = $totalLines + getTotalLines($totalSelected, 3);
							}
							if ($row3['under4'] && $row4['under4']) {
								$totalLines = $totalLines + getTotalLines($totalSelected, 4);
							}
							if ($row3['under5'] && $row4['under5']) {
								$totalLines = $totalLines + getTotalLines($totalSelected, 5);
							}
							if ($row3['under6'] && $row4['under6']) {
								$totalLines = $totalLines + getTotalLines($totalSelected, 6);
							}
							if ($row3['under7'] && $row4['under7']) {
								$totalLines = $totalLines + getTotalLines($totalSelected, 7);
							}
							if ($row3['under8'] && $row4['under8']) {
								$totalLines = $totalLines + getTotalLines($totalSelected, 8);
							}
							//Stack per line
							$stackPerLine = $stackAmount / $totalLines;

							if ($row3['under2'] && $row4['under2']) {
								if ($totalLines > 0 && $winnerCount >= 2) {
									$winningLines = getWinningLines($winnerCount, 2);
									$winningAmount = ($winningLines * $stackPerLine * $odds2);
								}
							}
							if ($row3['under3'] && $row4['under3']) {
								if ($totalLines > 0 && $winnerCount >= 3) {
									$winningLines = getWinningLines($winnerCount, 3);
									$winningAmount = $winningAmount + ($winningLines * $stackPerLine * $odds3);
								}
							}
							if ($row3['under4'] && $row4['under4']) {
								if ($totalLines > 0 && $winnerCount >= 4) {
									$winningLines = getWinningLines($winnerCount, 4);
									$winningAmount = $winningAmount + ($winningLines * $stackPerLine * $odds4);
								}
							}
							if ($row3['under5'] && $row4['under5']) {
								if ($totalLines > 0 && $winnerCount >= 5) {
									$winningLines = getWinningLines($winnerCount, 5);
									$winningAmount = $winningAmount + ($winningLines * $stackPerLine * $odds5);
								}
							}
							if ($row3['under6'] && $row4['under6']) {
								if ($totalLines > 0 && $winnerCount >= 6) {
									$winningLines = getWinningLines($winnerCount, 6);
									$winningAmount = $winningAmount + ($winningLines * $stackPerLine * $odds6);
								}
							}
							if ($row3['under7'] && $row4['under7']) {
								if ($totalLines > 0 && $winnerCount >= 7) {
									$winningLines = getWinningLines($winnerCount, 7);
									$winningAmount = $winningAmount + ($winningLines * $stackPerLine * $odds7);
								}
							}
							if ($row3['under8'] && $row4['under8']) {
								if ($totalLines > 0 && $winnerCount >= 8) {
									$winningLines = getWinningLines($winnerCount, 8);
									$winningAmount = $winningAmount + ($winningLines * $stackPerLine * $odds8);
								}
							}

							if ($winningAmount > 0) {
								$status = "Won " . $winningAmount . " &#8358;";
							}

							if (strtotime($closeDate) > time()) {
								$winningAmount = 'xxxx';
								$bgcolor = "#ffc107";
							}
							$bgcolor = '#ffc107';
							if (strtotime($closeDate) < time()) {
								if ($winningAmount > 0) {
									
									$bgcolor = '#1f9c00';
									$winningAmount = 'N' . $winningAmount;
								} else {
									$status = "Lost";
									$bgcolor = '#e70000';
								}
							}
							// get stack detail code
							$string = $string . "<div>
                                                                <div class=' ticket-info d-flex justify-content-between  align-items-center px-3 py-2 my-2 rounded-pill' style='background-color:" . $bgcolor . ";'>
                                                                    <span class='text-white'>Ticket ID: $ticketId</span>
                                                                    <span class='text-white'>Week " . $row3['week'] . "</span>
                                                                    <span class='text-white'>" . gmdate('d', strtotime($matchDate)) . '-' . gmdate('d', strtotime($closeDate)) . "</span>
                                                                    <span class='text-white'>" . $betDate . "</span>
                                                                    <span class='text-white'>" . $betTime . "</span>
                                                                </div>";


							$sql = "SELECT id, couponId,(SELECT name from coupontypemaster where id=s.couponTypeId) as name,
                                                                        couponTypeId,week,date,under2,under3,under4,under5,under6,under7,under8,stackAmount
                                                                        FROM stacks s WHERE id=" . $row3['id'];
							$stmt = $connection->query($sql);

							if ($stmt) {
								while ($row = $stmt->fetch_assoc()) {



									$sql2 = "SELECT s.id,s.winner,m.homeTeam,m.awayTeam,m.homeScore,m.awayScore,m.isResultDeclared
                                                                                    FROM stackdetail s LEFT JOIN matches m ON m.id=s.matchId
                                                                                    WHERE s.parentId=" . $row['id'];
									$stmt2 = $connection->query($sql2);

									if ($stmt2) {
										$sr = 1;
										$string = $string . "<div class='row mt-2' >";
										while ($row2 = $stmt2->fetch_assoc()) {

											$bordercontent = "";
											if ($row2['isResultDeclared'] == 1) {
												if($winningAmount > 0 ){
													$bordercontent = "w";
													$bgconcolor = "#1f9c00";
												}else{
													$bordercontent = "x";
													$bgconcolor = "#e70000";
												}
											
											} else {
												$bordercontent = "i";
												$bgconcolor = "#ffc107";
											}
											$string = $string . "<div class='col-auto px-1'>
																					<button class='my-1 rounded-circle number-badge' style=''>
																						" . $sr . "
																						<span style='
																							position: absolute;
																							top: -5px;
																							right: -5px;
																							width: 16px;
																							height: 16px;
																							background: " . $bgconcolor . ";
																							color: white;
																							font-size: 12px;
																							font-weight: bold;
																							text-align: center;
																							line-height: 16px;
																							border-radius: 50%;
																							display: inline-block;'>
																							" . $bordercontent . "
																						</span>
																					</button>
																				</div>";



											$sr++;
										}
										$string = $string . "        </div>";
										$string = $string . "<div class='row mt-2 mx-2 bfs'>
                                                                                                     <div class='col-4'>Stake " . $row3['stackAmount'] . "</div>
                                                                                                     <div class='col-4'>Lines 3 From 11</div>
                                                                                                     <div class='col-4'>Winning " . $winningAmount . "</div>
                                                                                                     </div>";
									}
								}
							}
							$string = $string .  "</div><hr>";
							$sr++;
						}
					} else {
						die("Query failed: " . $connection->error); // Handle query error
					}
					$string = $string . "<tr><td colspan='5'><input type='hidden' id='totalMatches' value='" . $sr . "'></td></tr></tbody></table>";
					echo $string;
					?>
					<div id="errorContainer" class="mt-2"></div>
				</div>
			</div>



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


	$(document).ready(function() {
		/*$('#matchDate').bootstrapMaterialDatePicker
		({
		    format: 'dddd DD MMMM YYYY - HH:mm'
		});*/
		$('#matchDate').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			format: 'YYYY-MM-DD'
		}).on('change', function(e) {
			const selectedDate = $(this).val();
			window.location.href = "?date=" + selectedDate;
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
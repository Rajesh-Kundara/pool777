<?php
include('config.php');
ini_set("display_errors", "on");
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

<?php
function trimDecimal($decimal)
{
	return (explode(".", $decimal)[1] == 0) ? explode(".", $decimal)[0] : $decimal;
}

$unders = array();
$undersNumber = array();

$couponId = "";
if (!empty($_GET['coupon'])) {
	$couponId = $_GET['coupon'];
	$sql = "SELECT id,typeId,(SELECT imageUrl FROM coupontypemaster WHERE id=typeId) as imageUrl,(SELECT name FROM coupontypemaster WHERE id=typeId) as couponType,minStack,minPerLine,ruleDescription,season,matchDate,closeDate,couponId,week,weekInfo,status,
			under2,under3,under4,under5,under6,under7,under8,maxUnder2,maxUnder3,maxUnder4,maxUnder5,maxUnder6,maxUnder7,maxUnder8 FROM coupons WHERE couponId='" . $_GET['coupon'] . "'";
	$stmt = $connection->query($sql);
	if ($stmt) {
		while ($row = $stmt->fetch_assoc()) {
			$couponId = $row['id'];
			$couponTypeId = $row['typeId'];
			$name = explode(" - ", $row['couponType']);
			$couponType = $name[0];
			$imageUrl = $row['imageUrl'];
			$minStack = $row['minStack'];
			$minPerLine = $row['minPerLine'];
			$ruleDescription = $row['ruleDescription'];
			$season = $row['season'];
			$week = $row['week'];
			$weekInfo = $row['weekInfo'];
			$matchDate = $row['matchDate'];
			$closeDate = $row['closeDate'];
			if ($row['under2'] == 1) {
				$data = array();
				$data['under'] = 2;
				$data['max'] = $row['maxUnder2'];
				array_push($unders, $data);
				array_push($undersNumber, 2);
			}
			if ($row['under3'] == 1) {
				$data = array();
				$data['under'] = 3;
				$data['max'] = $row['maxUnder3'];
				array_push($unders, $data);
				array_push($undersNumber, 3);
			}
			if ($row['under4'] == 1) {
				$data = array();
				$data['under'] = 4;
				$data['max'] = $row['maxUnder4'];
				array_push($unders, $data);
				array_push($undersNumber, 4);
			}
			if ($row['under5'] == 1) {
				$data = array();
				$data['under'] = 5;
				$data['max'] = $row['maxUnder5'];
				array_push($unders, $data);
				array_push($undersNumber, 5);
			}
			if ($row['under6'] == 1) {
				$data = array();
				$data['under'] = 6;
				$data['max'] = $row['maxUnder6'];
				array_push($unders, $data);
				array_push($undersNumber, 6);
			}
			if ($row['under7'] == 1) {
				$data = array();
				$data['under'] = 7;
				$data['max'] = $row['maxUnder7'];
				array_push($unders, $data);
				array_push($undersNumber, 7);
			}
			if ($row['under8'] == 1) {
				$data = array();
				$data['under'] = 8;
				$data['max'] = $row['maxUnder8'];
				array_push($unders, $data);
				array_push($undersNumber, 8);
			}
		}
	}
} else {
	echo "Invalid request.";
}
?>

<body data-spy="scroll" data-target=".navbar-collapse">
	<div class="max-width container p-0 h-100" id="mainContent" style="background-color: #e3e6ef;">
		<?php include('header.php'); ?>

		<div class="container max-width p-0">
			<div class="container theme-background max-width">

				<div class="container ">
					<div class="bg-white  rounded p-2 d-flex align-items-center justify-content-between">
						<input type="hidden" id="couponId" value="<?= $couponId ?>" />
						<input type="hidden" id="couponTypeId" value="<?= $couponTypeId ?>" />
						<span class="ms-3 font-color-1 fw-bold" id="week">
							Week <?= $week ?>
							<span class="rounded mx-2" style="background-color:#4838af;">
								<i class="fas fa-volume-up p-1 text-white"></i>
							</span>
							<span class="rounded mx-2 " style="background-color:#4838af;cursor: pointer;" onclick="qopenPopup()">
								<i class="fa-solid fa-question p-1 text-white"></i>
							</span>
						</span>


						<span class="me-3 font-color-1 fw-bold"><?= $couponType ?></span>
					</div>
				</div>


				<div class="container">
					<div class="row mt-2">
						<div class="gap-2 align-items-center">
							<h3 class="text-white ms-4 mt-2">50% BONUS</h3>
							<label class="text-white ms-4 mb-2" style="font-size:12px;">Game Closes at <?= gmdate('l H:i e', strtotime($closeDate)) ?></label>
						</div>
					</div>
				</div>


			</div>
			<div class="container max-width px-3" style=" background-color: #e3e6ef;">
				<!-- <div class="container"> -->
				<div class="row pt-2">
					<div class="d-flex gap-2 align-items-center justify-content-between">
						<button class="rounded date-range-btn text-white ms-3 me-3 p-2 border-0">
							<i class="fa-solid fa-calendar-day"></i>
							<?= gmdate('d', strtotime($matchDate)) . '-' . gmdate('d', strtotime($closeDate)) ?>
						</button>
						<button class="open-odds-btn" onclick="openPopup()">Open Odds</button>
						<!-- <span class="badge bg-primary d-flex align-items-center p-2 rounded-pill"></span> -->
					</div>
				</div>
				<div class="my-3 ms-3 align-items-center">
					<span class="fw-bold font-color-1">Under:</span>
					<!-- <div class="d-flex gap-2"> -->
					<?php for ($i = 0; $i < sizeof($unders); $i++) {
						$data = $unders[$i];
					?>
						<button class="btn-under px-3 py-1  text-white"
							data-id="<?= $data['under']; ?>"
							id="cb_under_<?= $data['under']; ?>"
							onclick="selectUnder(this)">
							<?= $data['under']; ?>
						</button>
					<?php } ?>
					<!-- </div> -->
					<div id="undersSelected" class="d-none"></div> <!-- This will display the selected items -->
				</div>



				<div class="card matchcontainer-card ">
					<div class="card-body " style="margin-bottom:90px">


						<div class="row mt-2 fs-m fs-l">
							<div class="col-8 d-flex align-items-center" style="padding-left:50px;">
								<?php
								$checked = isset($status) && $status ? 'checked' : '';
								$labelText = isset($status) && $status ? 'View Number Only' : 'View Team Name';
								?>
								<div class="form-check form-switch ">
									<input class="form-check-input fs-4 custom-switch-bg ml-0" type="checkbox" id="toggle" <?= $checked ?> onchange="toggleView()" />
								</div>
								<label class="text-white ms-2" id="toggleLabel"><?= $labelText; ?></label>


							</div>

							<div class="col-4 align-items-right text-white">
								<label for=""><i class="fas fa-dice"></i> Lucky Selection</label>
							</div>
						</div>

						<div class="row mt-2">
							<div class="col-md-12 d-flex align-items-center ms-4 ">
								<?php
								$checked = isset($status) && $status ? 'checked' : '';
								$labelText = isset($status) && $status ? 'View Number Only' : 'View Team Name';
								?>
								<div class="text-white ">
									<label class="text-white ms-2 fs-5" id="toggleLabel"><label id="countMatchesSelected" class="countMatchesSelected">0</label> Numbers Selected</label>
								</div>

							</div>
						</div>


						<div class="container">


							<div class="row mt-3 " id="matchContainer">
								<?php
								$sr = 0;
								$sql = "SELECT * FROM matches WHERE status='A'";
								$stmt3 = $connection->query($sql);

								if ($stmt3) {
									while ($row3 = $stmt3->fetch_assoc()) {
								?>
										<div class="numberList col-auto match-item px-1" id="">
											<button class="my-2 rounded-circle match-btn n-btn" id="btn_match_<?= $sr; ?>" onclick="selectMatch(<?= $sr; ?>)">
												<?= ($sr + 1); ?>
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

							<input type="hidden" id="totalMatches" value="<?= $sr; ?>">
							<div class="d-none countMatchesSelected">0</div> <!-- Display selected count -->
						</div>


					</div>
				</div>

				<!-- </div> -->

			</div>

		</div>
		<div class="card footer-slack-card p-2" style="position: fixed;bottom: 65;left: 50%;transform: translateX(-50%);width: 90%;max-width: 525px;
    		border-radius: 20px;padding: 5px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);display: flex;justify-content: space-around;align-items: center;">
			<div class="">
				<button id="openBetslip" href="betSlip.php" class="btn btn-sm text-white px-3 py-2"
					style="background-color: #C51D5A;top: -36px;right: 21px;font-size: 12px;cursor: pointer;position: absolute;"
					onclick="openBetslip()">
					<i class="fas fa-chevron-up"></i> Open Betslip
				</button>
			</div>
			<div class="row g-2 align-items-center justify-content-between  p-2 ">
				<!-- Open Betslip Button -->

				<!-- Left Side: Input and Play Button -->
				<div class="col-auto d-flex align-items-center">
					<input type="text" id="stackAmount" class="form-control form-control-md bg-color-1 text-dark border-0"
						onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Stake" style="width: 120px;">

					<button id="btnStack1" class="btn btn-primary btn-md ms-2 px-4" onclick="stack()">Play</button>
				</div>

				<!-- Right Side: Stake Per Line Details + Info Button -->
				<div class="col-auto  align-items-center text-white fs-m fs-l">
					<div class="row">
						<div class="col-auto">
							<span class="text-secondary small">Stake Per Line: <?= $minStack ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<label id="undersSelected"><span style="color:#d8d8d8"><?php echo implode(" ", $undersNumber); ?></span></label> from <label class="countMatchesSelected">0</label> With Total Staked
						</div>
					</div>


				</div>
				<div class="col-auto  align-items-center text-white">

					<!-- Info Button -->
					<button type="button" class="btn btn-sm ms-3 text-white" data-bs-toggle="modal" data-bs-target="#couponModal">
						<i class="fas fa-info-circle"></i>
					</button>
				</div>
			</div>

		</div>

		<?php include('footer.php'); ?>
	</div>

	<?php include('profile-card.php'); ?>

	<!-- open Betslip -->
	<!-- Full-Screen Menu -->
	<!-- Full-Screen Menu -->
	<div id="fullScreenBetslip" class="d-none">
		<div class="container max-width ">
			<div class="container pt-3" id="t-first-div">
				<span id="closeMenu" onclick="closeBetslip()">&times;</span>
				<!-- Title -->
				<h3 class="mt-3 ms-4 text-white">BetSlip</h3>


			</div>

			<div class="container" id="t-second-div" style="min-height: 500px; ">
				<div class="t-profile-card  p-3 bg-white rounded-4 shadow-lg" style="">

					<div id="betSlipContainer"></div>



				</div>
			</div>


		</div>

	</div>

	<!-- i button popup -->
	<!-- Modal -->
	<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered custom-modal">
			<div class="modal-content bg-color-1">
				<div class="modal-header text-white bg-color-2" style="">
					<h5 class="modal-title" id="couponModalLabel">Coupon Details</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="px-4">
						This coupon type is : <span><?= $couponType ?></span>

					</div>
					<div class="px-4">
						<br>
						<span>Coupon Closes : <?= gmdate('l H:i e', strtotime($closeDate)) ?></span>
					</div>
					<div class="card my-3 shadow">
						<div class="card-header text-center p-1 bg-color-2 text-white">This coupon rules</div>
						<div class="card-body p-2 bg-color-1" style="font-size: 15px;">
							<p class="my-1">Minimum Stake <span id="minStack"><?= $minStack ?></span></p>
							<p class="my-1">Minimum Per Line <span id="minPerLine"><?= $minPerLine ?></span></p>
							<br>
							<?php foreach ($unders as $data) { ?>
								<p class="my-1 text-sm">Max. on <?= $data['under'] ?> General Draws <span id="maxOn_<?= $data['under'] ?>"><?= $data['max'] ?></span> N /line</p>
							<?php } ?>
						</div>
					</div>





				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>



	<!-- slack success model -->
	<!-- Bootstrap 5.3 Success Modal -->
	<div class="modal fade" id="smodalInfo" tabindex="-1" aria-labelledby="smodalInfoTitle" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content text-center p-4">
				<button type="button" class="btn-close position-absolute top-0 start-0 m-3" data-bs-dismiss="modal" aria-label="Close" onclick="resetPage()"></button>

				<div class="d-flex justify-content-center">
					<div class="bg-success text-white rounded-circle p-3">
						<img src="images/icon-check.png" width="100" height="100" alt="success">
					</div>
				</div>

				<h5 class="mt-3 fw-bold" id="smodalInfoTitle"></h5>
				<p id="smodalInfoBody" class="" style="color: #4635af;font-size: 18px;font-weight: bold;"></p>


				<a href="pdf/transactionReceipt.php?id=" target="_blank" class="btn btn-primary d-flex align-items-center justify-content-center mx-auto" id="printTicket" style="background-color: #4635af;border: #4635af;">
					<i class="fas fa-print me-2"></i> Print Ticket
				</a>
			</div>
		</div>
	</div>

	<!-- open odds popup -->


	<!-- Popup Container -->
	<!-- Popup Container -->
	<div id="oddsPopup" class="odds-popup d-none">
		<div class="popup-odds-content">
			<!-- Close Button (Now Positioned Just Above the Popup Box) -->
			<button class="close-odds-btn" onclick="closePopup()">✖</button>

			<div class="popup-odds-content" style="background-color: white;">
				<h2 class="popup-odds-title">ODDS</h2>
				<div class="row py-2 fw-bold">
					<div class="col-6">
						<span>DRAWS</span>
					</div>
					<div class="col-6">
						<span>
							<?php foreach ($unders as $under) { ?>
								<?= $under['under'] ?>
							<?php } ?>
						</span>
					</div>
				</div>
				<?php
				$sql4 = "SELECT * FROM couponodds WHERE couponId=$couponId AND status='A'";
				$result4 = $connection->query($sql4);
				$oddsTable = "";
				if ($result4) {
					$tr = "";
					while ($row4 = $result4->fetch_assoc()) { ?>
						<div class="row odds-list mb-2">
							<div class="odds-item col-6 ">
								<div class="border-end">
									<span class="px-2 "><?= $row4['dFrom'] ?> </span> - <span class="px-2 "><?= $row4['dTo'] ?> </span>

								</div>

							</div>
							<div class="odds-item col-6">
								<?php foreach ($unders as $under) { ?>
									<span class="ms-3"> <?= trimDecimal($row4['odds' . $under['under']]) ?> </span>
								<?php } ?>
							</div>
						</div>
				<?php }
				} ?>
			</div>
		</div>
	</div>


	<!-- Popup Container -->
	<div id="qPopup" class="q-popup d-none">
		<div class="popup-q-content ">
			<!-- Close Button Positioned at the Top -->
			<button class="close-q-btn" onclick="qclosePopup()">✖</button>

			<div class="popup-q-content bg-color-1">
				<div class="card mb-3">
					<div class="card-header text-center p-1 bg-color-2 text-white">Coupon Rule Description</div>
					<div class="card-body p-2 bg-color-1" style="font-size: 15px;">
						<p class="my-1"><?= $ruleDescription ?></p>
					</div>
				</div>
				<div class="card mb-3">
					<div class="card-header text-center p-1 bg-color-2 text-white">
						How to Stake
					</div>
					<div class="card-body p-2 bg-color-1" style="font-size: 15px;">
						<ul class="list-group list-group-flush">
							<li class="list-group-item p-1 bg-color-1">
								<p class="my-1">
									<span class="fw-bold text-dark">1.</span>
									Choose how many draws you want to predict:
									<strong><?php echo implode(", ", $undersNumber); ?></strong>,
									by clicking the box beside the number under "UNDER."
								</p>
							</li>
							<li class="list-group-item p-1 bg-color-1">
								<p class="my-1">
									<span class="fw-bold text-dark">2.</span>
									Make your selection by clicking the box next to the fixture grid.
								</p>
							</li>
							<li class="list-group-item p-1 bg-color-1">
								<p class="my-1">
									<span class="fw-bold text-dark">3.</span>
									Enter the amount you want to stake.
								</p>
							</li>
							<li class="list-group-item p-1 bg-color-1">
								<p class="my-1">
									<span class="fw-bold text-dark">4.</span>
									Click the "STAKE" button to confirm.
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>
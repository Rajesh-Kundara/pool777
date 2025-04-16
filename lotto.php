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
<script>
	function printReceipt() {
		fetch("pdf/transactionReceipt.php")
			.then(response => response.json())
			.then(data => {
				if (data.pdfData) {
					// printJS({ printable: data.pdfData, type: 'pdf', base64: true });
					printJS({
						printable: 'pool777/pdf/transactionReceipt.php',
						type: 'pdf'
					});
				} else {
					alert("Failed to generate PDF.");
				}
			})
			.catch(error => {
				alert("Error printing receipt: " + error);
			});
	}

	// Function to print the PDF
	// function printPDF() {
	//     var printWindow = window.open("pdf/transactionReceipt.php", "_blank");
	//     if (printWindow) {
	//         printWindow.onload = function () {
	//             printWindow.print();
	//             printWindow.onafterprint = function () {
	//                 printWindow.close();
	//             };
	//         };
	//     } else {
	//         alert("Popup blocked! Please allow pop-ups for this site.");
	//     }
	// }
</script>
<?php
function trimDecimal($decimal)
{
	return (explode(".", $decimal)[1] == 0) ? explode(".", $decimal)[0] : $decimal;
}

?>

<body data-spy="scroll" data-target=".navbar-collapse">
	<div class="max-width container p-0 h-100" id="mainContent" style="background-color: #e3e6ef;">
		<?php include('header.php'); ?>

		<div class="container max-width p-0">
			<div class="container theme-background max-width">

				<div class="container ">
					<div class="bg-white  rounded p-2 d-flex align-items-center justify-content-between">

						<span class="ms-3" id="week">
							Week 2
							<span class="rounded mx-2" style="background-color:#4838af;">
								<i class="fas fa-volume-up p-1 text-white"></i>
							</span>
							<span class="rounded mx-2" style="background-color:#4838af;">
								<i class="fa-solid fa-question p-1 text-white"></i>
							</span>
						</span>


						<span class="me-3 ">Premier Gold</span>
					</div>
				</div>


				<div class="container">
					<div class="row mt-2">
						<div class="gap-2 align-items-center">
							<h3 class="text-white ms-4 mt-2">50% BONUS</h3>
							<label class="text-white ms-4 mb-2" style="font-size:12px;">Game Closes at Monday 09:22 UTC</label>
						</div>
					</div>
				</div>


			</div>
			<div class="container max-width px-4" style=" background-color: #e3e6ef;">
				<!-- <div class="container"> -->
				<div class="row pt-2">
					<div class="d-flex gap-2 align-items-center justify-content-between">
						<button class="rounded date-range-btn text-white ms-3 me-3 p-2 border-0">
							<i class="fa-solid fa-calendar-day"></i> 25-31
						</button>
						<!-- <span class="badge bg-primary d-flex align-items-center p-2 rounded-pill"></span> -->
					</div>
				</div>
				<div class="my-3 ms-3 align-items-center">
					<span class="fw-bold">Bankers:</span>
					<!-- <div class="d-flex gap-2"> -->
					<?php
					$sql = "select * from bankers";
					$stmt = $connection->query($sql);
					while ($row = $stmt->fetch_assoc()) {
					?>
						<button class="btn-banker px-3 py-1  text-white"
							data-id="<?= $row['id']; ?>"
							id="cb_under_<?= $row['id']; ?>"
							onclick="selectBanker(this)">
							<?= $row['name']; ?>
						</button>
						<input type="hidden" id="description_<?= $row['id']; ?>" value="<?= $row['description']; ?>">
						<input type="hidden" id="closeDate_<?= $row['id']; ?>" value="<?= $row['closeDate']; ?>">
						<input type="hidden" id="minStack_<?= $row['id']; ?>" value="<?= $row['minStack']; ?>">
						<input type="hidden" id="minSelectedNo_<?= $row['id']; ?>" value="<?= $row['minSelectedNo']; ?>">

					<?php } ?>
					<!-- </div> -->
					<div id="undersSelected" class="d-none"></div> <!-- This will display the selected items -->
				</div>

				<div class="d-none text-dark my-2"><span id='description' class="px-2"></span></div>

				<div class="card matchcontainer-card ">
					<div class="card-body " style="margin-bottom:90px">


						<div class="row mt-2">

							<div class="col-8"></div>
							<div class="col-4 align-items-right text-white">
								<label for=""><i class="fas fa-dice"></i> Lucky Selection</label>
							</div>
						</div>




						<div class="container">


							<div class="row mt-3 " id="matchContainer">
								<?php
								$sr = 1;
								while ($sr <= 90) {
								?>
									<div class="numberList col-auto match-item" id="">
										<button class="m-2 rounded-circle match-btn" id="btn_match_<?= $sr; ?>" onclick="selectMatchLotto(<?= $sr; ?>)">
											<?= ($sr); ?>
										</button>
										<input type="hidden" id="matchId_<?= $sr; ?>" value="<?= $sr; ?>">
										<input type="checkbox" id="cb_match_<?= $sr; ?>" class="d-none">

									</div>
								<?php
									$sr++;
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
		<div id="alert" class="card  py-2 px-3 bg-danger text-white d-none" style="position: fixed;bottom: 160;left: 50%;transform: translateX(-50%);width: 90%;max-width: 525px;
    		border-radius: 20px;padding: 5px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);display: flex;justify-content: space-around;">
			<span></span>

		</div>
		<div class="card footer-slack-card p-2" style="position: fixed;bottom: 56;left: 50%;transform: translateX(-50%);width: 90%;max-width: 525px;
    		border-radius: 20px;padding: 5px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);display: flex;justify-content: space-around;">
			<div class="row g-2 justify-content-between  p-2 ">
				<!-- Open Betslip Button -->

				<!-- Left Side: Input and Play Button -->
				<div class="col-auto d-flex align-items-center">
					<input type="text" id="stackAmount" class="form-control form-control-md bg-light text-dark border-0"
						onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Stake" style="width: 120px;">

					<button id="btnStack1" class="btn btn-primary btn-md ms-2 px-4" onclick="stackLoto()">Play</button>
				</div>

				<!-- Right Side: Stake Per Line Details + Info Button -->
				<div class="col-auto  align-items-center text-white">
					<div class="row">
						<div class="col-auto">
							<span class="text-secondary small">Line: 4</span>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<span class="text-secondary small">Type: <span id='bankerType'></span></span>
							<input type="hidden" id="selectedBankerId">
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<label id="bankersSelected"><span style="color:#d8d8d8">Numbers:<span id="selectedNumbers"></span></span></label>
						</div>
					</div>


				</div>
				<div class="col-auto  align-items-center text-white">

				</div>
			</div>

		</div>
		<?php include('footer.php'); ?>
	</div>
	<script src="js/lotto.js"></script>
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
				<p id="smodalInfoBody" class="text-muted"></p>

				<!-- href="pdf/transactionReceipt.php" target="_blank"  -->

				<button class="btn btn-primary d-flex align-items-center justify-content-center mx-auto" id="printTicket" onclick="printReceipt()">
					<i class="fas fa-print me-2"></i> Print Ticket
				</button>
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
						<p class="my-1">Coupon Closes : <?= gmdate('l H:i e', strtotime($closeDate)) ?></p>
						<p class="my-1">Minimum Stake <span id="minStack"><?= $minStack ?></span></p>
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
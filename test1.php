<?php 
include('common/config.php');
$isLoggedIn=false;
if(isset($_SESSION['fullname']))
{
	//echo "<script>window.location.href='index.php'</script>";
	$isLoggedIn=true;
}
?>

<html class="no-js" lang="en">
<?php 
include('head.php');

?>

<?php 
ini_set("display_errors","on");

$unders=array();
$undersNumber=array();

$couponId="";
if(!empty($_GET['coupon'])){
	$couponId=$_GET['coupon'];
	$sql = "SELECT id,typeId,(SELECT imageUrl FROM coupontypemaster WHERE id=typeId) as imageUrl,(SELECT name FROM coupontypemaster WHERE id=typeId) as couponType,minStack,minPerLine,ruleDescription,season,matchDate,closeDate,couponId,week,weekInfo,status,
			under2,under3,under4,under5,under6,under7,under8,maxUnder2,maxUnder3,maxUnder4,maxUnder5,maxUnder6,maxUnder7,maxUnder8 FROM coupons WHERE couponId='".$_GET['coupon']."'";
	$stmt = $connection->query($sql);
	if ( $stmt ){
		while( $row = $stmt->fetch_assoc()){
			$couponId=$row['id'];
			$couponTypeId=$row['typeId'];
			$couponType=$row['couponType'];
			$imageUrl=$row['imageUrl'];
			$minStack=$row['minStack'];
			$minPerLine=$row['minPerLine'];
			$ruleDescription=$row['ruleDescription'];
			$season=$row['season'];
			$week=$row['week'];
			$weekInfo=$row['weekInfo'];
			$matchDate=$row['matchDate'];
			$closeDate=$row['closeDate'];
			if($row['under2']==1){
				$data=array();
				$data['under']=2;
				$data['max']=$row['maxUnder2'];
				array_push($unders,$data);
				array_push($undersNumber,2);
			}
			if($row['under3']==1){
				$data=array();
				$data['under']=3;
				$data['max']=$row['maxUnder3'];
				array_push($unders,$data);
				array_push($undersNumber,3);
			}
			if($row['under4']==1){
				$data=array();
				$data['under']=4;
				$data['max']=$row['maxUnder4'];
				array_push($unders,$data);
				array_push($undersNumber,4);
			}
			if($row['under5']==1){
				$data=array();
				$data['under']=5;
				$data['max']=$row['maxUnder5'];
				array_push($unders,$data);
				array_push($undersNumber,5);
			}
			if($row['under6']==1){
				$data=array();
				$data['under']=6;
				$data['max']=$row['maxUnder6'];
				array_push($unders,$data);
				array_push($undersNumber,6);
			}
			if($row['under7']==1){
				$data=array();
				$data['under']=7;
				$data['max']=$row['maxUnder7'];
				array_push($unders,$data);
				array_push($undersNumber,7);
			}
			if($row['under8']==1){
				$data=array();
				$data['under']=8;
				$data['max']=$row['maxUnder8'];
				array_push($unders,$data);
				array_push($undersNumber,8);
			}
		}
	}
}else{
	echo "Invalid request.";
}
?>	
	
<body data-spy="scroll" data-target=".navbar-collapse">
	<div class="" style="">
		<?php include('header.php'); ?>

		<div class="container">
			<div class="container theme-background max-width" >
				
				<div class="container">
					<div class="bg-white rounded p-2 d-flex align-items-center justify-content-between"> 
						<input type="hidden" id="couponId" value="<?=$couponId?>"/>
						<input type="hidden" id="couponTypeId" value="<?=$couponTypeId?>"/>
						<span class="ms-3" id="week">Week <?=$week?></span>
						<span class="me-3"><?=$weekInfo?></span>
					</div>
				</div>


				<div class="container">
					<div class="row mt-2">
						<div class="d-flex gap-2 align-items-center">
							<h3 class="text-white ms-4 mt-2">50% BONUS</h3>
							<!-- <span class="badge bg-primary d-flex align-items-center p-2 rounded-pill"></span> -->
						</div>
					</div>
				</div>

				
			</div>
			<div class="container max-width" style=" background-color: #e3e6ef;">
				<div class="container">
					<div class="row pt-2">
						<div class="d-flex gap-2 align-items-center">
							<button class="rounded date-range-btn text-white ms-3 me-3 p-2 border-0">
								<i class="fa-solid fa-calendar-day"></i> 
								<?= gmdate('d', strtotime($matchDate)) .'-'. gmdate('d', strtotime($closeDate))?> 
							</button>
							<!-- <span class="badge bg-primary d-flex align-items-center p-2 rounded-pill"></span> -->
						</div>
					</div>


					

					<div class="mt-3 ms-3 align-items-center">
						<span class="fw-bold">Under:</span>
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



					<div class="card matchcontainer-card mt-2">
						<div class="card-body">
							

							<div class="row mt-2">
								<div class="col-md-12 d-flex align-items-center ms-4">
									<?php 
										$checked = isset($status) && $status ? 'checked' : ''; 
									?>
									<div class="form-check form-switch">
										<input class="form-check-input fs-4 ms-n5" type="checkbox" id="toggle" <?= $checked ?> onchange="toggleView()">
										
									</div><label class="form-check-label text-white ms-2" for="toggle">View Number Only</label>
								</div>
							</div>


							<div class="container">
										

								<div class="row mt-3" id="matchContainer">
									<?php
									$sr = 0;
									$sql = "SELECT * FROM matches WHERE status='A'";
									$stmt3 = $connection->query($sql);

									if ($stmt3) {
										while ($row3 = $stmt3->fetch_assoc()) {
											?>
											<div class="col-auto match-item">
													<button class="m-2 rounded-circle match-btn" id="btn_match_<?=$sr;?>" onclick="selectMatch(<?=$sr;?>)">
														<?= ($sr + 1); ?>
													</button>
													<span class="match-info <?= ($checked) ? '' : 'd-none'; ?>">
														<?=$row3['homeTeam'];?> vs <?=$row3['awayTeam'];?>
													</span>
													<!-- <span class="match-info d-none"><?=$row3['homeTeam'];?> vs <?=$row3['awayTeam'];?></span> -->
													<input type="hidden" id="matchId_<?=$sr;?>" value="<?=$row3['id'];?>">
													<input type="checkbox" id="cb_match_<?=$sr;?>" class="d-none">
												
											</div>
											<?php
											$sr++;
										}
									}
									?>
								</div>

								<input type="hidden" id="totalMatches" value="<?=$sr;?>">
								<div id="countMatchesSelected" class="d-none">0</div> <!-- Display selected count -->
							</div>
							<div class="card footer-slack-card">
								<div class="row align-items-center">
									<div class="col-md-8 offset-md-2 text-center">
										<div class="card mt-4">
											<div class="card-header p-1">
												<label id="undersSelected">
													<span class="text-secondary"><?= implode(" ", $undersNumber); ?></span>
												</label>
												from <label id="countMatchesSelected">0</label> With Total Staked
											</div>
											<div class="card-body p-2" style="font-size: 0.75rem;">
												<div class="input-group">
													<input type="text" id="stackAmount" 
														class="form-control form-control-sm" 
														onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
														placeholder="in NAIRA"/>
													<span class="input-group-text">&#8358;</span>
													<button id="btnStack1" class="btn btn-success btn-sm ms-1" onclick="stack()">Stack</button>
												</div>
											</div>
										</div>
										<div id="errorContainer" class="mt-2"></div>
									</div>
									<div class="col-md-2 text-center">
										<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#couponModal">
											<i class="fas fa-info-circle"></i>
										</button>
									</div>
								</div>
							</div>

						</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
<!-- JS includes -->
	<!-- Offcanvas Side Menu -->
	<div class="offcanvas offcanvas-start" id="profileMenu">
		<?php
		if(!empty($_GET['logout'])){
			unset($_SESSION['fullname']);
			unset($_SESSION['id']);
			unset($_SESSION['type']);
			session_destroy();
			// header('index.php');
			echo "<script>window.location.href='index.php'</script>";
		}
		?>
		<div class="offcanvas-header bg-primary text-white">
			<h5 class="offcanvas-title">Menu</h5>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
		</div>
		<div class="offcanvas-body">
			<div class="text-center">
				<img src="profile.jpg" class="rounded-circle" width="80">
				<h5 class="mt-2">lazy_player1324</h5>
				<p class="text-muted">Adewale Ayuba</p>
			</div>
			<?php
			if(isset($_SESSION['fullname']) ){?>
			<div class="d-flex justify-content-center my-3">
				<a class="btn btn-success me-2" href="deposit.php">Deposit</a>
				<a class="btn btn-light" href="request_withdraw.php">Withdrawal</a>
			</div>
			<?php } ?>
			<!-- Progress Section -->
			<div class="bg-primary text-white p-2 rounded text-center">
				<p class="mb-1">Play 5 More Tickets to get Reward</p>
				<div class="progress">
					<div class="progress-bar bg-white" style="width: 40%;"></div>
				</div>
			</div>

			<!-- Menu Items -->
			<ul class="list-group mt-3">
				<li class="list-group-item">
					<a href="bet_history.php" class="text-dark d-flex justify-content-between text-decoration-none">
						Bet History <i class="fas fa-chevron-right"></i>
					</a>
				</li>
				<li class="list-group-item">
					<a href="transactions.php" class="text-dark d-flex justify-content-between text-decoration-none">
						Transaction History <i class="fas fa-chevron-right"></i>
					</a>
				</li>
				<li class="list-group-item">
					<a href="#" class="text-dark d-flex justify-content-between text-decoration-none">
						Messages <span class="badge bg-danger">4</span>
					</a>
				</li>
				<li class="list-group-item">
					<a href="result.php" class="text-dark d-flex justify-content-between text-decoration-none">
						Results <i class="fas fa-chevron-right"></i>
					</a>
				</li>
				<li class="list-group-item">
					<a href="accountDetail.php" class="text-dark d-flex justify-content-between text-decoration-none">
						Account <i class="fas fa-chevron-right"></i>
					</a>
				</li>
				<li class="list-group-item">
					<a href="changePassword.php" class="text-dark d-flex justify-content-between text-decoration-none">
						Change Password <i class="fas fa-chevron-right"></i>
					</a>
				</li>
			</ul>

			<!-- Logout Button -->
			<div class="text-center mt-4">
			<?php
				if(!empty($_GET['logout'])){
					unset($_SESSION['fullname']);
					unset($_SESSION['id']);
					unset($_SESSION['type']);
					session_destroy();
					// header('index.php');
					echo "<script>window.location.href='index.php'</script>";
				}
				if(!isset($_SESSION['fullname']) ){?>
					<button id="dLabel" class="btn btn-danger btn-sm text-white" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Login
					</button>
					<a class="btn btn-sm btn-danger text-white" href="<?=$host;?>/register.php" role="button">Register</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
					<form class="px-4 py-1">
						<div class="form-group">
						<label for="userName">Username</label>
						<input type="text" class="form-control" id="userName" placeholder="userName">
						</div>
						<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" placeholder="Password">
						</div>
						<div class="form-check">
						<input type="checkbox" class="form-check-input" id="dropdownCheck">
						<label class="form-check-label" for="dropdownCheck">
							Remember me
						</label>
						</div>
						<button type="button" onClick="login()" class="btn btn-primary">Sign in</button>
						
					</form>
					<div id="loginErrorContainer"></div>
					<a class="dropdown-item" href="<?=$host;?>/reset_password.php">Forgot password</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?=$host;?>/register.php">New around here? Sign up</a>
					<!--<a class="dropdown-item" href="#">Forgot password?</a>-->
					</div>
					<?php
				}else{
					$sql = "SELECT SUM(amount) as balance from balance WHERE userId=".$_SESSION['id'];  
						
					$result = $connection->query($sql);
					if ( $result ){  
						$row = $result->fetch_assoc();
						$balance = $row['balance'];
					}?>
					<button id="dLabel" class="btn btn-danger btn-sm text-white " type=""><a class="text-decoration-none text-white" href="profileEdit.php">Edit Profile</a></button>
					<button id="dLabel" class="btn btn-danger btn-sm text-white " type=""><a class="text-decoration-none text-white" href="index.php?logout=rdr">Logout</a></button>
					
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php include('footer.php'); ?>
	<!-- </div> -->
	<div id="modalInfo" class="modal fade bd-example-modal-sm " tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalInfoTitle"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="modalInfoBody"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="javascript:location.reload();">Close</button>
			</div>
			</div>
		</div>
	</div>

	<!-- i button popup -->
 	<!-- Modal -->
	<div class="modal fade " id="couponModal" tabindex="-1" role="dialog" aria-labelledby="couponModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="couponModalLabel">Coupon Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="p-4">
						This coupon type is :</br>
						<span><?=$couponType?></span>
					</div>
					<div class="p-4">
						<br>
						<span>Coupon Closes : <?=gmdate('l H:i e', strtotime($closeDate))?></span>
					</div>
					<div class="card mb-3">
						<div class="card-header text-center p-1">This coupon rules</div>
						<div class="card-body p-2" style="font-size: 0.75rem;">
							<p class="my-1">Minimum Stake <span id="minStack"><?=$minStack?></span></p>
							<p class="my-1">Minimum Per Line <span id="minPerLine"><?=$minPerLine?></span></p>
							<br>
							<?php foreach ($unders as $data) { ?>
								<p class="my-1 text-sm">Max. on <?=$data['under']?> General Draws <span id="maxOn_<?=$data['under']?>"><?=$data['max']?></span> N /line</p>
							<?php } ?>
						</div>
					</div>

					<div class="card mb-3">
						<div class="card-body p-0">
							<?php
							// function trimDecimal($decimal) {
							//     return (explode(".", $decimal)[1] == 0) ? explode(".", $decimal)[0] : $decimal;
							// }
							$sql4 = "SELECT * FROM couponodds WHERE couponId=$couponId AND status='A'";
							$result4 = $connection->query($sql4);
							$oddsTable = "";
							if ($result4) {
								$tr = "";
								while ($row4 = $result4->fetch_assoc()) {
									$tr .= "<tr><td class='border bg-primary text-white'>" . $row4['from'] . "-" . $row4['to'] . "</td>";
									foreach ($unders as $under) {
										$tr .= "<td class='border'>" . trimDecimal($row4['odds' . $under['under']]) . "</td>";
									}
									$tr .= "</tr>";
								}
								$trh = "<tr class='bg-light'><th class='border bg-primary text-white'>Draws</th>";
								foreach ($unders as $under) {
									$trh .= "<th class='border'>{$under['under']}</th>";
								}
								$trh .= "</tr>";
								$oddsTable = "<table class='text-center' width='100%' style='font-size: 0.85rem;'>$trh$tr</table>";
							}
							echo $oddsTable;
							?>
						</div>
					</div>

					<div class="card mb-3">
						<div class="card-header text-center p-1">Coupon Rule Description</div>
						<div class="card-body p-2" style="font-size: 0.75rem;">
							<p class="my-1"><?=$ruleDescription?></p>
						</div>
					</div>

					<div class="card mb-3">
						<div class="card-header text-center p-1">How to Stake</div>
						<div class="card-body p-2 text-center" style="font-size: 0.75rem;">
							<ul class="list-group list-group-flush">
								<li class="list-group-item p-1">
									<h5 class="card-title">1</h5>
									<p class="my-1">
										Choose how many Draws you want to predict: i.e : <?php echo implode(", ",$undersNumber);?>. by clicking the box by the side of the number below UNDER.
									</p>
								</li>
								<li class="list-group-item p-1">
									<h5 class="card-title">2</h5>
									<p class="my-1">
										Make your selection by clicking on the box next to the fixture grid.
									</p>
								</li>
								<li class="list-group-item p-1">
									<h5 class="card-title">3</h5>
									<p class="my-1">
										Enter how much money you want to Stake.
									</p>
								</li>
								<li class="list-group-item p-1">
									<h5 class="card-title">4</h5>
									<p class="my-1">
										To finish press the bottom STAKE.
									</p>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

					<button class="btn btn-primary d-flex align-items-center justify-content-center mx-auto" id="printTicket">
						<i class="fas fa-print me-2"></i> Print Ticket
					</button>
				</div>
			</div>
		</div>

	<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
	<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script src="../assets/js/vendor/jquery-3.2.1.slim.min.js"></script>-->
	<script src="assets/js/vendor/popper.min.js"></script>
	<script src="assets/js/vendor/bootstrap.min.js"></script>

	<script src="js/jquery.dataTables.min.js"></script>
	<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<!-- material datepicker -->
	<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
	<script src="assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
	<!--<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
	<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>-->
	<script src="assets/js/mdtimepicker.js"></script>
	<link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">

	<script>
	$(document).ready(function(){
		/*$('#matchDate').bootstrapMaterialDatePicker
		({
			format: 'dddd DD MMMM YYYY - HH:mm'
		});*/
		$('#matchDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false }); 
		$('#closeDate').bootstrapMaterialDatePicker({ weekStart : 0, time: false }); 
		
		//$('#matchDateTime').mdtimepicker(); //Initializes the time picker
		
		$('#DataGrid').dataTable({
				"bLengthChange": false,
				"pageLength": 5,
				responsive:true,
			});
		});
	
		function login(){
			$("#loginError").alert('close');
			var userName= $('#userName').val();
			var password= $('#password').val();
			
			var form_data = new FormData();
			form_data.append("userName", userName);
			form_data.append("password", password);
			
			$.ajax({
				type: "POST",  	
				url: "<?=$host?>/api/login.php",  
				processData: false,
				contentType: false,
				data: form_data,
				success: function(response){
					response=JSON.parse(response);
					if(response.success == "1"){
						window.location.href="<?=$host?>/";
					}else{
						var html='<div id="loginError" class="alert alert-danger fade show" role="alert" style="width:250px;">'+response.message+'</div>';
						$("#loginErrorContainer").html(html);
						//$("#loginError").show('slow');
					}
				},  
				error: function(e){  
				alert(e.status);
				alert(e.responseText);
				alert(thrownError);
				}  
			});  
			//document.getElementById("saveButton").disabled=true;
		}  
		
		function addNew() {
			$('#couponDetailModel').modal('show');
			//$('#itemText').val($('#name_'+formFillForEditId).html());
			
			//document.getElementById("saveButton").disabled=true;
			//document.getElementById("updateButton").disabled=false;
			
			$('#idForUpdate').val("0");
			
			document.getElementById("saveButton").disabled=false;
			document.getElementById("updateButton").disabled=true;
		}
		
		function selectUnder(button) {
			if (isLoggedIn() === false) return;

			var id = $(button).data("id");
			var isActive = $(button).hasClass("selected");

			// Toggle button active state
			if (isActive) {
				$(button).removeClass("selected");
			} else {
				$(button).addClass("selected");
			}

			// Update the display
			$("#undersSelected").html("");
			$(".btn-under.selected").each(function () {
				var text = $(this).text();
				var html = '<span class="text-dark">' + text + '</span>';
				$("#undersSelected").append(html);
			});

			// If the button is not selected, show it as gray
			$(".btn-under").not(".selected").each(function () {
				var text = $(this).text();
				var html = '<span style="color:#d8d8d8">' + text + '</span>';
				$("#undersSelected").append(html);
			});
		}

		
		function selectMatch(sr) {
			if (isLoggedIn() === false) return;

			var checkbox = $('#cb_match_' + sr);
			var button = $('#btn_match_' + sr);
			var matchInfo = button.siblings('.match-info'); // Get the related match-info span

			// Toggle the checkbox value
			checkbox.prop("checked", !checkbox.prop("checked"));

			// Toggle button styling based on selection
			if (checkbox.prop("checked")) {
				button.addClass('match-btn-b-c text-white');
				matchInfo.addClass('match-btn-b-c text-white');
			} else {
				button.removeClass('match-btn-b-c text-white');
				matchInfo.removeClass('match-btn-b-c text-white');
			}

			// Count selected matches
			var totalMatches = parseInt($("#totalMatches").val());
			var totalMatchesSelected = 0;

			for (var i = 0; i < totalMatches; i++) {
				if ($('#cb_match_' + i).prop("checked")) {
					totalMatchesSelected++;
				}
			}
			
			$('#countMatchesSelected').text(totalMatchesSelected);
		}

		
		function stack() {
			if (isLoggedIn() === false) return;
			$("#error").alert('close');

			let isUnderSelected = false;
			let minMatchToSelect = 2;
			let underSelections = {};

			// Loop through all under buttons and check which ones are active (selected)
			$(".btn-under.selected").each(function () {
				let underValue = $(this).data("id");
				underSelections[`under${underValue}`] = 1; // Store the selected values
				isUnderSelected = true;
				minMatchToSelect = Math.max(minMatchToSelect, parseInt(underValue));
			});

			if (!isUnderSelected) {
				alert("Please select from unders!");
				return;
			}

			let minStack = parseInt($("#minStack").text());
			let stackAmount = parseInt($("#stackAmount").val());

			if (stackAmount < minStack) {
				alert("Minimum stack value is " + minStack + " N.");
				return;
			}

			let couponId = $("#couponId").val();
			let couponTypeId = $("#couponTypeId").val();
			let week = $("#week").text();
			let totalMatches = parseInt($("#totalMatches").val());
			let matchesSelected = [];

			let msCount = 0;
			for (let i = 0; i < totalMatches; i++) {
				if ($(`#cb_match_${i}`).prop("checked")) {
					matchesSelected.push($(`#matchId_${i}`).val());
					msCount++;
				}
			}

			if (msCount < minMatchToSelect) {
				alert("Please select minimum " + minMatchToSelect + " matches");
				return;
			}

			let form_data = new FormData();
			
			// Append selected unders dynamically
			Object.keys(underSelections).forEach(key => form_data.append(key, underSelections[key]));

			form_data.append("stackAmount", stackAmount);
			form_data.append("couponId", couponId);
			form_data.append("couponTypeId", couponTypeId);
			form_data.append("week", week);
			form_data.append("matchesSelected", matchesSelected.join(","));

			$.ajax({
				type: "POST",
				url: "<?=$host?>/api/placeStack.php",
				processData: false,
				contentType: false,
				data: form_data,
				success: function (response) {
					response = JSON.parse(response);
					if (response.success == "1") {
						$('#smodalInfoTitle').html("Success!");
						$('#smodalInfoBody').html(response.message);
						$('#smodalInfo').modal('show');
					} else {
						let html = `<div id="error" class="alert alert-danger fade show" role="alert">${response.message}</div>`;
						$("#errorContainer").html(html);
					}
				},
				error: function (e) {
					alert(e.status);
					alert(e.responseText);
				}
			});
		}

		
		function isLoggedIn(){
			<?php
			if($isLoggedIn){
				echo "return true;";
			}else{
			?>
			$('#modalInfoTitle').html("!");
			$('#modalInfoBody').html("Please login first to proceed.");
			
			$('#modalInfo').modal('show');
			
			return false;
			<?php } ?>
		}

		function resetPage(){
			location.reload();

		}
	</script>

	<script>
		$(":radio").change(function(){
			var teamValue = jQuery('input[name=team]:checked').val();
			$.ajax({
			type : 'post',
			url : 'memberNameValue.php',
			data : {teamValue:teamValue},
			success : function(data)
			{
				$('#members').html(data);
			}
			});
		});	
	</script>
			
		
</body>

</html>

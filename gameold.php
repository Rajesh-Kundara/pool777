<?php 
include('config.php');
ini_set("display_errors","on");
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
			$name= explode(" - ", $row['couponType']);
			$couponType = $name[0];
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
	<div class="max-width container p-0 h-100" id="mainContent" style="background-color: #e3e6ef;">
		<?php include('header.php'); ?>

		<div class="container max-width p-0">
			<div class="container theme-background max-width" >
				
				<div class="container ">
					<div class="bg-white  rounded p-2 d-flex align-items-center justify-content-between"> 
						<input type="hidden" id="couponId" value="<?=$couponId?>"/>
						<input type="hidden" id="couponTypeId" value="<?=$couponTypeId?>"/>
						<span class="ms-3" id="week">
							Week <?=$week?>
							<span class="rounded mx-2" style="background-color:#4838af;">
								<i class="fas fa-volume-up p-1 text-white"></i>
							</span>
							<span class="rounded mx-2" style="background-color:#4838af;">
								<i class="fa-solid fa-question p-1 text-white"></i>
							</span>
						</span>
						
						
						<span class="me-3 "><?=$couponType?></span>
					</div>
				</div>


				<div class="container">
					<div class="row mt-2">
						<div class="gap-2 align-items-center">
							<h3 class="text-white ms-4 mt-2">50% BONUS</h3>
							<label class="text-white ms-4 mb-2" style="font-size:12px;" >Game Closes at <?=gmdate('l H:i e', strtotime($closeDate))?></label>
						</div>
					</div>
				</div>

				
			</div>
			<div class="container max-width px-4" style=" background-color: #e3e6ef;">
				<!-- <div class="container"> -->
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
							<div class="col-8 d-flex align-items-center" style="padding-left:50px;">
								<?php 
									$checked = isset($status) && $status ? 'checked' : ''; 
									$labelText = isset($status) && $status ? 'View Number Only' : 'View Team Name';
								?>
								<div class="form-check form-switch ">
									<input class="form-check-input fs-4 custom-switch-bg ml-0" type="checkbox" id="toggle" <?= $checked ?> onchange="toggleView()"/>
								</div>
								<label class="text-white ms-2"  id="toggleLabel"><?= $labelText; ?></label>
								
								
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
								<label class="text-white ms-2 fs-5"  id="toggleLabel"><label id="countMatchesSelected">0</label> Numbers Selected</label>
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
							<div class="card footer-slack-card p-2">
								<div class="row g-2 align-items-center justify-content-between  p-2 ">
									<!-- Left Side: Input and Play Button -->
									<div class="col-auto d-flex align-items-center">
										<input type="text" id="stackAmount" class="form-control form-control-md bg-light text-dark border-0" 
											onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Stake" style="width: 120px;">

										<button id="btnStack1" class="btn btn-primary btn-md ms-2 px-4" onclick="stack()">Play</button>
									</div>

									<!-- Right Side: Stake Per Line Details + Info Button -->
									<div class="col-auto d-flex align-items-center text-white">
										<span class="text-secondary small">Stake Per Line:</span> 
										<strong class="ms-1 small">3 from 5</strong>  
										<span class="mx-2 small">|</span>  
										<strong class="small">10 Lines</strong>

										<!-- Info Button -->
										<button type="button" class="btn btn-sm ms-3 text-white" data-bs-toggle="modal" data-bs-target="#couponModal">
											<i class="fas fa-info-circle"></i>
										</button>
									</div>
								</div>

							</div>

						</div>
					</div>
					
				<!-- </div> -->
				
			</div>
		</div>
	
		<?php include('footer.php'); ?> 
	</div>

	<?php include('profile-card.php'); ?> 
	
	
	<!-- i button popup -->
 	<!-- Modal -->
	<div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered custom-modal">
			<div class="modal-content" >
				<div class="modal-header text-white" style="background-color: #2b1a93;">
					<h5 class="modal-title" id="couponModalLabel">Coupon Details</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" >
					<div class="px-4">
						This coupon type is :<span><?=$couponType?></span>
						
					</div>
					<div class="px-4">
						<br>
						<span>Coupon Closes : <?=gmdate('l H:i e', strtotime($closeDate))?></span>
					</div>
					<div class="card my-3">
						<div class="card-header text-center p-1">This coupon rules</div>
						<div class="card-body p-2" style="font-size: 13px;">
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
							$sql4 = "SELECT * FROM couponodds WHERE couponId=$couponId AND status='A'";
							$result4 = $connection->query($sql4);
							$oddsTable = "";
							if ($result4) {
								$tr = "";
								while ($row4 = $result4->fetch_assoc()) {
									$tr .= "<tr><td class='border bg-primary text-white' >" . $row4['from'] . "-" . $row4['to'] . "</td>";
									foreach ($unders as $under) {
										$tr .= "<td class='border'>" . trimDecimal($row4['odds' . $under['under']]) . "</td>";
									}
									$tr .= "</tr>";
								}
								$trh = "<tr class='bg-light'><th class='border  text-white' style='background-color: #9586f0;'>Draws</th>";
								foreach ($unders as $under) {
									$trh .= "<th class='border'>{$under['under']}</th>";
								}
								$trh .= "</tr>";
								$oddsTable = "<table class='text-center w-100' style='font-size: 0.85rem;'>$trh$tr</table>";
							}
							echo $oddsTable;
							?>
						</div>
					</div>

					<div class="card mb-3">
						<div class="card-header text-center p-1">Coupon Rule Description</div>
						<div class="card-body p-2" style="font-size: 13px;">
							<p class="my-1"><?=$ruleDescription?></p>
						</div>
					</div>

					<div class="card mb-3">
						<div class="card-header text-center p-1">How to Stake</div>
						<div class="card-body p-2 " style="font-size: 0.75rem;">
							<ul class="list-group list-group-flush">
								<li class="list-group-item p-1">
									
									<p class="my-1"><span class="fw-bold text-dark">1</span>
										Choose how many Draws you want to predict: i.e : <?php echo implode(", ",$undersNumber);?>. by clicking the box by the side of the number below UNDER.
									</p>
								</li>
								<li class="list-group-item p-1">
									<p class="my-1"><span class="fw-bold text-dark">2</span>
										Make your selection by clicking on the box next to the fixture grid.
									</p>
								</li>
								<li class="list-group-item p-1">
									<p class="my-1"><span class="fw-bold text-dark">3</span>
										Enter how much money you want to Stake.
									</p>
								</li>
								<li class="list-group-item p-1">
									<p class="my-1"><span class="fw-bold text-dark">4</span>
										To finish, press the bottom STAKE.
									</p>
								</li>
							</ul>
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
					<p id="smodalInfoBody" class="text-muted"></p>

					<a href="pdf/transactionReceipt.php" target="_blank" class="btn btn-primary d-flex align-items-center justify-content-center mx-auto" id="printTicket">
						<i class="fas fa-print me-2"></i> Print Ticket
					</a>
				</div>
			</div>
		</div>

	

</body>

</html>

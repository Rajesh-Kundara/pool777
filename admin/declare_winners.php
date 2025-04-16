<?php 
include('../common/config.php');
if(!isset($_SESSION['fullname']))
{
	echo "<script>window.location.href='index.php?q=error'</script>";
}
?>

<html class="no-js" lang="en">
<?php 
include('common/head.php');

?>
	
<body data-spy="scroll" data-target=".navbar-collapse">
<?php 
$activePage="declareWinners";
include('common/header.php'); 
?>

<div class="culmn">
	<!--Test section-->
	<section id="test" class="test fix">
		<div class="container">
			<div class="row">                        
				<div class="main_test fix">
					<div class="col-md-12">
						<div class="test_item fix" style="border-top: 0px;">
							<div class="container">
								
								<div class="row my-4">
									<div class="col-md-4"></div>
									<div class="col-md-2 text-center">Week #:</div>
									<div class="col-md-2 text-left">
									<select id="weekNo2" name="weekNo2" onChange="selectWeek();" class="form-control">
										<option value="0">All Weeks</option>
										<?php
											$week=0;
											if(!empty($_GET['week'])){
												$week=$_GET['week'];	
											}
											$str = "SELECT DISTINCT(week) FROM matches ORDER BY week ASC";
											$res = $connection->query($str);
											
											if ( $res ){
												while( $col = $res->fetch_assoc()){
													if(strlen($col['week'])>0 && $week==$col['week']){
														echo '<option selected value="'.$col['week'].'">'.$col['week'].'</option>';
													}else{
														echo '<option value="'.$col['week'].'">'.$col['week'].'</option>';
													}
												}
											}
										?>
									</select>
									</div>
									<div class="col-md-4">
										<div id="errorContainer" class="text-tight" ></div>
									</div>
								</div>
								<?php 
								include('../common/functions.php');
								if($week){
									$str = "SELECT *,(SELECT name FROM coupontypemaster WHERE id=typeId) as couponName FROM coupons WHERE week=$week ORDER BY typeId ASC";
								}else{
									$str = "SELECT *,(SELECT name FROM coupontypemaster WHERE id=typeId) as couponName FROM coupons ORDER BY typeId ASC";
								}
								$res = $connection->query($str);
								
								
								$adminProfitTotal=0;
								$count=0;
								if ( $res ){
									while( $colCoupon = $res->fetch_assoc()){
								 ?>
								<div class="row border my-4 <?=($count%2==0)?"":"bg-light"?>">
									<div class="col">
										<div class="row bg-info">
											<div class="col"><h5 class="pt-2 text-white"><?=$colCoupon['couponName']?></h5></div>
											
										</div>
										<div class="row">
											<div class="col px-0 text-center" style="overflow-x: auto; white-space: nowrap;">
												<?php
												$string ="<table align='center' width='100%' class=' table-hover'>
														
														<tr>
															<th class='px-1 border text-center' width='5%'>#</th>
															<th class='px-4 border' width='15%'>User</th>
															<th class='p-1 border text-center' width='5%'>Week</th>
															<th class='p-1 border text-center' width='15%'>Unders</th>
															<th class='px-4 border text-right' width='15%'>Stacked Amt.</th>
															<th class='px-4 border text-right' width='15%'>Won</th>
															<th class='px-4 border text-center' width='10%'>Action</th>
															<th class='px-4 border text-center' width='15%'>Admin Profit</th>
														</tr>"; 
												$sr=1;
												$idForUpdate=0;

												//user stacked values on coupon
												$sql = "SELECT id, userId,(SELECT CONCAT(f_name,' ',l_name) FROM users WHERE id=userId) as userName, couponId,week,under2,under3,under4,under5,under6,under7,under8,stackAmount,
														(SELECT COUNT(id) FROM stackdetail WHERE parentId=s.id) as totalSelected FROM stacks s 
														WHERE couponId=".$colCoupon['id']." AND status='A' ORDER BY id DESC";
												$stmt3 = $connection->query($sql);
												if ( $stmt3 ){
													while( $row3 = $stmt3->fetch_assoc()){
														$status="";
														$week=$row3['week'];
														$stackAmount=$row3['stackAmount'];
														$totalSelected=$row3['totalSelected'];
														$unders=($row3['under2'])?"<span class='px-2'>2</span>":"";
														$unders=$unders.(($row3['under3'])?"<span class='px-2'>3</span>":"");
														$unders=$unders.(($row3['under4'])?"<span class='px-2'>4</span>":"");
														$unders=$unders.(($row3['under5'])?"<span class='px-2'>5</span>":"");
														$unders=$unders.(($row3['under6'])?"<span class='px-2'>6</span>":"");
														$unders=$unders.(($row3['under7'])?"<span class='px-2'>7</span>":"");
														$unders=$unders.(($row3['under8'])?"<span class='px-2'>8</span>":"");
														
														//to compare with native coupon
														$sql="SELECT id,typeId,(SELECT name FROM coupontypemaster WHERE id=typeId) as name,
																under2,under3,under4,under5,under6,under7,under8
																FROM coupons WHERE id=".$row3['couponId'];
														$result4 = $connection->query($sql);
														$row4 = $result4->fetch_assoc();
														
														//------------------
														$winnerType;
														$sql="SELECT COUNT(id) as count FROM matches";
														$suffix=" Draws";
														$winnerType;
														switch($row4['typeId']){
															case 1: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
															case 2: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=0 AND week=$week"; $suffix=" Homes"; $winnerType=1; break;
															case 3: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=0 AND isAwayWinner=1 AND week=$week"; $suffix=" Aways"; $winnerType=2; break;
															case 4: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" General Draws"; $winnerType=0; break;
															case 5: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=1 AND week=$week"; $suffix=" Score Draws"; $winnerType=0; break;
															case 6: case 7: case 8: case 9: case 10:
																$sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
														}
														$result6 = $connection->query($sql);
														$row6 = $result6->fetch_assoc();
														$draws=$row6['count'];
														
														//getting draw range for coupon
														 $sql="SELECT * FROM couponodds WHERE $draws>=dFrom AND $draws<=dTo AND couponId=".$row3['couponId'];
														$result7 = $connection->query($sql);
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
							
														$sql="SELECT COUNT(id) as winnerCount FROM stackdetail WHERE parentId=".$row3['id']." AND winner=$winnerType";
														$result5 = $connection->query($sql);
														$row5 = $result5->fetch_assoc();
														$winnerCount=$row5['winnerCount'];
														
														$totalLines=0;$winningLines=0;$winningAmount=0;
														if($row3['under2'] && $row4['under2']){
															$totalLines=$totalLines+getTotalLines($totalSelected,2);
														}
														if($row3['under3'] && $row4['under3']){
															$totalLines=$totalLines+getTotalLines($totalSelected,3);
														}
														if($row3['under4'] && $row4['under4']){
															$totalLines=$totalLines+getTotalLines($totalSelected,4);
														}
														if($row3['under5'] && $row4['under5']){
															$totalLines=$totalLines+getTotalLines($totalSelected,5);
														}
														if($row3['under6'] && $row4['under6']){
															$totalLines=$totalLines+getTotalLines($totalSelected,6);
														}
														if($row3['under7'] && $row4['under7']){
															$totalLines=$totalLines+getTotalLines($totalSelected,7);
														}
														if($row3['under8'] && $row4['under8']){
															$totalLines=$totalLines+getTotalLines($totalSelected,8);
														}
														//Stack per line
														$stackPerLine=$stackAmount/$totalLines;
														
														if($row3['under2'] && $row4['under2']){
															if($totalLines>0 && $winnerCount>=2){
																$winningLines=getWinningLines($winnerCount,2);
																$winningAmount=($winningLines*$stackPerLine*$odds2);
															}
														}
														if($row3['under3'] && $row4['under3']){
															if($totalLines>0 && $winnerCount>=3){
																$winningLines=getWinningLines($winnerCount,3);
																$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds3);
															}
														}
														if($row3['under4'] && $row4['under4']){
															if($totalLines>0 && $winnerCount>=4){
																$winningLines=getWinningLines($winnerCount,4);
																$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds4);
															}
														}
														if($row3['under5'] && $row4['under5']){
															if($totalLines>0 && $winnerCount>=5){
																$winningLines=getWinningLines($winnerCount,5);
																$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds5);
															}
														}
														if($row3['under6'] && $row4['under6']){
															if($totalLines>0 && $winnerCount>=6){
																$winningLines=getWinningLines($winnerCount,6);
																$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds6);
															}
														}
														if($row3['under7'] && $row4['under7']){
															if($totalLines>0 && $winnerCount>=7){
																$winningLines=getWinningLines($winnerCount,7);
																$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds7);
															}
														}
														if($row3['under8'] && $row4['under8']){
															if($totalLines>0 && $winnerCount>=8){
																$winningLines=getWinningLines($winnerCount,8);
																$winningAmount=$winningAmount+($winningLines*$stackPerLine*$odds8);
															}
														}
														
														$adminProfit=$row3['stackAmount']-$winningAmount;
														$adminProfitTotal+=$adminProfit;
														if($winningAmount>0){
															//$status="Won ".$winningAmount." &#8358;";
															$status=$winningAmount.".00 &#8358;";
														}else{
															$status="";
														}
														$string=$string."<tr id='tr_".$sr."' class='border'>
															<td class='px-4 border'>".$sr."</td>
															<td class='px-4 border'>".$row3['userName']."</td>
															<td class='p-1 border text-center'>".$colCoupon['week']."</td>
															<td class='p-1 border text-center'>".$unders."</td>
															<td class='px-4 border text-right'>".$row3['stackAmount']." &#8358;</td>
															<td class='px-4 border text-right'>".$status."	
															<input type='hidden' id='stack_".$sr."' value='".$row3['id']."'>
															<input type='hidden' id='userId_".$sr."' value='".$row3['userId']."'>
															<input type='hidden' id='winning_".$sr."' value='".$winningAmount."'>
															</td>
															<td class='p-1 border text-center'>
																<div id='spinner_".$sr."' class='invisible spinner-border spinner-border-sm text-success' role='status'>
																	<span class='sr-only'>Loading...</span>
																</div>
																<input type='button' ".(($winningAmount>0)?'':'disabled')." class='btn btn-sm py-0 ".(($winningAmount>0)?'btn-success':'btn-dark disabled')."' id='btnApprove_".$sr."' onClick='approveWinning(".$sr.")' value='Approve'/>
															</td>
															<td class='px-4 border text-right ".(($adminProfit>=0)?'text-success':'text-warning')." font-weight-bold'>".$adminProfit." &#8358;</td>
															</tr>";
															$sr++;
													}
												}else{
													echo "no records found.".$stmt3->error();
												}				
												
												if($sr==1){
													$string=$string."<tr class='border'><td colspan='8' class='text-center'>No winner!</td></tr></tbody></table>";
												}else{
													$string=$string."</tbody></table>";
												}
												echo $string;
												?>
												
											</div>
										</div>
									</div>
								</div>
							  <?php $count++;
									}
								} ?>
											
								<div class="row font-weight-bold px-2">
									<div class="col-md-4">
									</div>
									<div class="col-md-3">
									</div>
									<div class="col-md-3 text-right">
										<h5>Grand Total (Admin Profit) : </h5>
									</div>
									<div class="col-md-2 text-right">
										<h5 class="text-success"><?=$adminProfitTotal." &#8358;"?> </h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- End off test section -->

<?php include('common/footer.php'); ?>
</div>
<div id="couponDetailModel" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard=false aria-labelledby="myModalLabel" aria-hidden="true">
	
	<div class="modal-dialog modal-lg" role="document" style="width:100%">
   		<div class="modal-content">
   			<div class="modal-header bg-info" >
       			<div class="modal-title" style="color: #196780;">
       				<div class="text-white" >
       					<b>Stacked Coupon Detail</b>
       				</div>
       			</div>  
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      		</div>
   			<div class="modal-body" id="customerServiceRequestModal_body">
	 			<div class="form-horizontal" role="form" >
	 			<table width="100%">
	 			
	 				<tr id="statusMarkCompletedDiv">
	 					<td colspan="3" class="col-md-12">
	 						<div class="col-md-12">
	 						<table width="100%">
	 							<tr>
	 								<td width="20%">&nbsp;</td>
	 								<td width="20%">&nbsp;</td>
	 								<td width="20%">&nbsp;</td>
	 								<td width="20%">&nbsp;</td>
	 								<td width="20%">&nbsp;</td>
	 							</tr>
	 							<tr>
	 								<td colspan="5">
	 									<table width="100%">
		 									<tr>
		 										<td width="100%">
		 										</td>
		 										</tr>
		 										<tr>
		 										<td width="100%">
		 											<table width="100%" class="panel panel-info" style="padding:10px;border-collapse:initial;">
		 												
							 							<tr>
							 								<td width="30%">Coupon Name :</td>
							 								<td width="70%">
																<label id="couponName"></label>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Week No :</td>
							 								<td width="70%">
																<label id="week"></label>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Unders Selected :</td>
							 								<td width="70%">
																<label id="unders"></label>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Stacked Amount :</td>
							 								<td width="70%">
																<label id="stackAmount"></label>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Status :</td>
							 								<td width="70%">
																<label id="status"></label>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Coupon Odds :</td>
							 								<td width="70%">
																<table id="oddsTable" style="font-size:0.70rem;" >
																	
																</table>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Stacked Matches :</td>
							 								<td width="70%">
																<table id="matchesTable" style="font-size:0.75rem;" width="100%">
																	
																</table>
															</td>
							 							</tr>
		 											</table>
		 										</td>
		 									</tr>
		 								</table>
	 								</td>
	 							</tr>
	 						</table>	
	 					</div>
	 					</td>
	 				</tr>
	 							
	 				<tr>
	 					<td colspan="3" align="center">
						<div style="padding-top:2px" class="col-md-6">
							<!--<button  type = "button" class="btn btn-success" id="saveButton" onclick="saveOrUpdateCoupon()">Save</button>
							<button  type='button'  class="btn btn-primary" id="updateButton" name="updateButton" onclick="saveOrUpdateCoupon()" disabled style="width:30%">Update</button>-->
							<button  type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
						</td>
	 				</tr>
	 			</table>
				<div class='row'>
					<div class="com-md-5">
						<div class="form-group">
						<!-- Error Message Div -->
							<table border=0 width="80%" align='center'>
								<tr><td colspan=3><div style="margin-left:10%;margin-right:10%width:95%;height:80px;color:red;overflow:auto;display:none" id="error" class="error"></div></td></tr>
							</table>
						<!-- Success Message Div -->
							<table border=0 width="80%" align='center'>
								<tr><td></td></tr>
							</table>
						</div>
					</div>
				</div>
				<input type="hidden" id="idForUpdate" value="0"/>
  				</div>
   			</div>
     	</div>
     </div>
     <input type="hidden" name="id" id="id">
     
 </div>

 <div id="modalInfo" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
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

<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>

<script src="assets/js/vendor/popper.min.js"></script>
<script src="assets/js/vendor/bootstrap.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>
<link href="css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- material datepicker -->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
<script src="assets/js/mdtimepicker.js"></script>
<link href="assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">

<script>
  $(document).ready(function(){
	
	
  });
  
	function approveWinning(sr){
		$('#spinner_'+sr).removeClass("invisible");
		$('#btnApprove_'+sr).prop("disabled",true);
		$("#errorContainer").html('');
		var stackId=$('#stack_'+sr).val();
		var userId=$('#userId_'+sr).val();
		var winning=$('#winning_'+sr).val();
		
		var form_data = new FormData();
	  	form_data.append("stackId", stackId);
	  	form_data.append("userId", userId);
	  	form_data.append("winning", winning);
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/approveWinning.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				$('#spinner_'+sr).addClass("invisible");
				response=JSON.parse(response);
		      	if(response.success == "1"){
					var html='<div id="error" class="alert py-1 alert-success fade show" role="alert">'+response.message+'</div>';
					$("#errorContainer").html(html);
					$('#btnApprove_'+sr).prop("disabled",true);
				}else{
					var html='<div id="error" class="alert py-1 alert-info fade show" role="alert">'+response.message+'</div>';
					$("#errorContainer").html(html);
					$('#btnApprove_'+sr).prop("disabled",true);
				}
			},  
		    error: function(e){
				$('#btnApprove_'+sr).prop("disabled",false);
				$('#spinner_'+sr).addClass("invisible");
				var html='<div id="error" class="alert py-1 alert-danger fade show" role="alert">Server error!</div>';
				$("#errorContainer").html(html);
		    }  
		});  
	}
	
	function selectWeek(){
		var week=$("#weekNo2").val();
		window.location.href="?week="+week;
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

<?php 
include('../common/config.php');
if(!isset($_SESSION['fullname']))
{
	//echo "<script>window.location.href='index.php?q=error'</script>";
	header('Location: ../index.php');
}
?>

<html class="no-js" lang="en">
<?php 
include('common/head.php');

?>

<?php 
ini_set("display_errors","on");
if(!empty($_POST['saveButton']) || !empty($_POST['updateButton']))
{
	$id="0";
	if(!empty($_POST['idForUpdate'])){
		$id=$_POST['idForUpdate'];
	}
	$itemText=$_POST['itemText'];
	
	if($id=="0"){
		$sql = "insert into rules(text,date) values('$itemText',NOW())";	
	}else{
		$sql = "update rules set text='$itemText',date=NOW() where id=$id";	
	}
	//echo $sql;die;
	$result = $connection->query($sql);
	// $idValue = mysql_insert_id();
	$idValue = $connection->insert_id;

	echo "<script>window.location.href='rules.php'</script>";
}
?>	
	
<body data-spy="scroll" data-target=".navbar-collapse">
<?php 
$activePage="coupons";
include('common/header.php'); 
?>
<div class="culmn">
	
	<div class="container border my-4">
			<div class="row">                        
					<div class="col-md-12">
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-4"><h4 align="center"><u>Coupons</u></h4></div>
								<div class="col-md-4" align="right"><button type="button" class="btn btn-info" aria-hidden="true" onClick="addNew()">Add New</button></div>
							</div>
							<div class="row">
								<div class="col" style="overflow-x: auto; white-space: nowrap;">
									<?php
									$string ="<table id='DataGrid' align='center' width='100%' border='1' class='table dt-responsive'>
											<thead>
											<tr  style='color:black'>
											<th width='5%' align='center'><b>S. No.</b></th>
											<th width='20%' ><b align='center'>Name</b></th>
											
											<th width='15%' ><b align='center'>Match Date</b></th>
											<th width='15%' ><b align='center'>Close Date</b></th>
											<th width='5%' ><b align='center'>Week</b></th>
											<th width='15%' ><b align='center'>Week Info</b></th>
											<th width='10%' ><b align='center'>Min. Stack</b></th>
											<th width='5%' align='center'><b>Status</b></th>
											<th width='10%' align='center'><b>Action</b></th>
											</tr>
											</thead>
											<tbody>"; 
											/*<th width='10%' ><b align='center'>Season</b></th>*/
									$sr=0;
									$idForUpdate=0;

									$sql = "SELECT id,typeId,(SELECT name FROM coupontypemaster WHERE id=typeId) as name,minStack,minPerLine,ruleDescription,season,matchDate,closeDate,couponId,week,weekInfo,status FROM coupons WHERE status='A' ORDER BY week DESC";
									$stmt3 = $connection->query($sql);
									if ( $stmt3 ){
										while( $row3 = $stmt3->fetch_assoc()){ 
											$string=$string."<tr style='height:20px;color:black;'>
												<td id='sr_".$sr."' align='center'>".($sr+1)."</td>
												<td id='name_".$sr."'>".$row3['name']."</td>
												
												<td id='matchDate_".$sr."'>".$row3['matchDate']."</td>
												<td id='closeDate_".$sr."'>".$row3['closeDate']."</td>
												<td id='week_".$sr."'>".$row3['week']."</td>
												<td id='weekInfo_".$sr."'>".$row3['weekInfo']."</td>
												<td id='minStack_".$sr."'>".$row3['minStack']."</td>
												<td id='status_".$sr."' align='center'>".$row3['status']."</td>
												<td align='center'>
												<img onClick='edit(".$sr.");' src='../images/editButton.png' border='0' title='Edit' width='16' height='16' />
												
												<input type='hidden' id='idForUpdate_".$sr."' value='".$row3['id']."'>
												</td>
												</tr>";
												//<img onClick='deleteItem(".$sr.");' src='images/delete_icon.gif' border='0' title='Delete' width='16' height='16' style='margin:0 10 0 10'/>
												$sr++;
												/*<td id='season_".$sr."'>".$row3['season']."</td>*/
										}
									}	else{
										echo "no data found.". $stmt3->error();
									}			
									$string=$string."</tbody></table>";
									echo $string;
									?>
								</div>
						</div>
					<div class="col-md-2"></div>
				</div>
		</div>
</div>
<?php include('common/footer.php'); ?>
</div>
<div id="couponDetailModel" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard=false aria-labelledby="myModalLabel" aria-hidden="true">
	
	<div class="modal-dialog modal-lg" role="document" style="width:100%">
   		<div class="modal-content">
   			<div class="modal-header bg-info" >
       			<div class="modal-title" style="color: #196780;">
       				<div class="text-white" >
       					<b>Add New Coupon Detail</b> <span id="tokenNoSpan1"></span>
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
							 								<td width="30%">Coupon Type :</td>
							 								<td width="70%">
																<select id="typeId" name="typeId" class="form-control">
																	<option value="0">Select</option>
																<?php
																$sql = "SELECT * FROM coupontypemaster WHERE status='A'";
																$result = $connection->query($sql);
																if ( $result ){
																	while( $row = $result->fetch_assoc()){ ?>
																	<option value="<?=$row['id']?>"><?=$row['name']?></option>
																<?php } } ?>
																</select>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Minimum Stack :</td>
							 								<td width="70%">
																<div class="input-group">
																	<input type="text" id="minStack" class="form-control input-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Minimum stack"/>
																	<div class="input-group-append">
																		<span class="input-group-text">&#8358;</span>
																	</div>
																</div></td>
							 							</tr>
														<tr>
							 								<td width="30%">Minimum Per-Line :</td>
							 								<td width="70%">
																<div class="input-group">
																	<input type="text" id="minPerLine" class="form-control input-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Minimum per-line"/>
																	<div class="input-group-append">
																		<span class="input-group-text">&#8358;</span>
																	</div>
																</div></td>
							 							</tr>
							 							<!--<tr>
							 								<td width="30%">Season :</td>
							 								<td width="70%"><input type="text" id="season" class="form-control input-sm" placeholder="Enter season name..."/></td>
							 							</tr>-->
														<tr>
							 								<td colspan="2">Please add week date (any date from Monday to Sunday) in witch coupons will active.</td>
							 							</tr>
														<tr>
							 								<td width="30%">Week Date :</td>
							 								<td width="70%">
																<input type="text" id="matchDate" class="form-control input-sm" placeholder="yyyy-mm-dd"/>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Close Date :</td>
							 								<td width="70%">
																<input type="text" id="closeDate" class="form-control input-sm" placeholder="yyyy-mm-dd hh:mm"/>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Week #:</td>
							 								<td width="70%">
																<input type="text" id="weekNo" class="form-control input-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Week number"/>
																<!--<select id="weekNo" name="weekNo" class="form-control">
																	<option value="0">Select</option>
																	<option value="1">Week 1</option>
																	<option value="2">Week 2</option>
																	<option value="3">Week 3</option>
																	<option value="4">Week 4</option>
																	<option value="5">Week 5</option>
																	<option value="6">Week 6</option>
																	<option value="7">Week 7</option>
																	<option value="8">Week 8</option>
																	<option value="9">Week 9</option>
																	<option value="10">Week 10</option>
																</select>-->
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Week info :</td>
							 								<td width="70%">
																<input type="text" id="weekInfo" class="form-control input-sm" placeholder="Week info..."/>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Unders :</td>
							 								<td width="70%">
															<div class="form-row">
																<div class="form-group col-md-3">
																	<div class="form-check form-check-inline"><input type="checkbox" id="cb_under_2" value="2" class="form-check-input"><label class="form-check-label" for="cb_under_2">2</label></div>
																	<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" id="max_under_2" placeholder="Max. &#8358;">
																</div>
																<div class="form-group col-md-3">
																	<div class="form-check form-check-inline"><input type="checkbox" id="cb_under_3" value="3" class="form-check-input"><label class="form-check-label" for="cb_under_2">3</label></div>
																	<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" id="max_under_3" placeholder="Max. &#8358;">
																</div>
																<div class="form-group col-md-3">
																	<div class="form-check form-check-inline"><input type="checkbox" id="cb_under_4" value="4" class="form-check-input"><label class="form-check-label" for="cb_under_2">4</label></div>
																	<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" id="max_under_4" placeholder="Max. &#8358;">
																</div>
																<div class="form-group col-md-3">
																	<div class="form-check form-check-inline"><input type="checkbox" id="cb_under_5" value="5" class="form-check-input"><label class="form-check-label" for="cb_under_2">5</label></div>
																	<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" id="max_under_5" placeholder="Max. &#8358;">
																</div>
																<div class="form-group col-md-3">
																	<div class="form-check form-check-inline"><input type="checkbox" id="cb_under_6" value="6" class="form-check-input"><label class="form-check-label" for="cb_under_2">6</label></div>
																	<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" id="max_under_6" placeholder="Max. &#8358;">
																</div>
																<div class="form-group col-md-3">
																	<div class="form-check form-check-inline"><input type="checkbox" id="cb_under_7" value="7" class="form-check-input"><label class="form-check-label" for="cb_under_2">7</label></div>
																	<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" id="max_under_7" placeholder="Max. &#8358;">
																</div>
																<div class="form-group col-md-3">
																	<div class="form-check form-check-inline"><input type="checkbox" id="cb_under_8" value="8" class="form-check-input"><label class="form-check-label" for="cb_under_2">8</label></div>
																	<input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control" id="max_under_8" placeholder="Max. &#8358;">
																</div>
																</div>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Coupon Odds :</td>
							 								<td width="70%">
																<table id="oddsTable" style="font-size:0.70rem;" width="100%">
																	
																	<tr id="tr_th_odds">
																		<th style="text-align:center" class="border">Draws range</th>
																		<th style="text-align:center" class="border">Under 2</th>
																		<th style="text-align:center" class="border">Under 3</th>
																		<th style="text-align:center" class="border">Under 4</th>
																		<th style="text-align:center" class="border">Under 5</th>
																		<th style="text-align:center" class="border">Under 6</th>
																		<th style="text-align:center" class="border">Under 7</th>
																		<th style="text-align:center" class="border">Under 8</th>
																		<th class="text-right" style="width:30px"><img src="../images/ic-plus.png" onclick="addOddsRow()" style="width:70%" alt=""/><input type="hidden" id="oddsRowCount" value="0"/></th>
																	</tr>
																	<!--<tr id="tr_odds_0">
																		<td class="border">
																			<div class="input-group" style="width:100%">
																			    <div class="input-group-prepend mx-0" style="width:50%">
																					<input type="text" class="input-group-text px-0" style="width:100%;font-size:0.75rem;background-color:#ffffff" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="drawFrom_0" placeholder="from" value="<?=$countryCode?>">
																			    </div>
																				<div class="input-group-append mx-0" style="width:50%">
																					<input type="text" class="input-group-text px-0" style="width:100%;font-size:0.75rem;background-color:#ffffff" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="drawTo_0" placeholder="to" value="<?=$phone?>">
																				</div>
																			</div>
																		</td>
																		<td class="border"><input type="text" class="form-control form-control-sm u2" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="odds_0_2" placeholder="odds" value="<?=$phone?>"></td>
																		<td class="border"><input type="text" class="form-control form-control-sm u3" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="odds_0_3" placeholder="odds" value="<?=$phone?>"></td>
																		<td class="border"><input type="text" class="form-control form-control-sm u4" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="odds_0_4" placeholder="odds" value="<?=$phone?>"></td>
																		<td class="border"><input type="text" class="form-control form-control-sm u5" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="odds_0_5" placeholder="odds" value="<?=$phone?>"></td>
																		<td class="border"><input type="text" class="form-control form-control-sm u6" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="odds_0_6" placeholder="odds" value="<?=$phone?>"></td>
																		<td class="border"><input type="text" class="form-control form-control-sm u7" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="odds_0_7" placeholder="odds" value="<?=$phone?>"></td>
																		<td class="border"><input type="text" class="form-control form-control-sm u8" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="odds_0_8" placeholder="odds" value="<?=$phone?>"></td>
																		<td><input type="hidden" id="oId_0" value="0"/></td>
																	</tr>-->
																</table>
															</td>
							 							</tr>
							 							<tr>
							 								<td width="30%" style="padding-top:15px">Rule Description :</td>
							 								<td width="70%" style="padding-top:15px"><textarea id="ruleDescription" class="form-control input-sm textarea" style="width:100%" ></textarea></td>
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
							<button  type = "button" class="btn btn-success" id="saveButton" onclick="saveOrUpdateCoupon()">Save</button>
							<button  type='button'  class="btn btn-primary" id="updateButton" name="updateButton" onclick="saveOrUpdateCoupon()" disabled style="width:30%">Update</button>
							<button  type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- JS includes -->

<!--<script src="../assets/js/owl.carousel.min.html"></script>
<script src="../assets/js/jquery.magnific-popup.js"></script>
<script src="../assets/js/jquery.easing.1.3.js"></script>
<script src="../assets/css/slick/slick.js"></script>
<script src="../assets/css/slick/slick.min.js"></script>
<script src="../assets/js/jquery.collapse.js"></script>
<script src="../assets/js/bootsnav.js"></script>-->

<!--<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/main.js"></script>
<link href="../assets/css/jquery.multiselect.css" rel="stylesheet" type="text/css">
<script src="../assets/js/jquery.multiselect.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="../resources/demos/style.css">-->
<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="../assets/js/vendor/jquery-3.2.1.slim.min.js"></script>-->
<script src="../assets/js/vendor/popper.min.js"></script>
<script src="../assets/js/vendor/bootstrap.min.js"></script>

<script src="../js/jquery.dataTables.min.js"></script>
<link href="../css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- material datepicker -->
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="../assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
<!--<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>-->
<script src="../assets/js/mdtimepicker.js"></script>
<link href="../assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">

<script>
  $(document).ready(function(){
	/*$('#matchDate').bootstrapMaterialDatePicker
	({
		format: 'dddd DD MMMM YYYY - HH:mm'
	});*/
	$('#matchDate').bootstrapMaterialDatePicker({ weekStart : 1, time: false }); 
	$('#closeDate').bootstrapMaterialDatePicker({
		format: 'YYYY-MM-DD HH:mm',
		switchOnClick : true,
		weekStart : 1, 
		minDate : new Date(),
		time: true }); 
    
    //$('#matchDateTime').mdtimepicker(); //Initializes the time picker
	
	$('#DataGrid').dataTable({
		"bLengthChange": false,
		"pageLength": 5,
		responsive:true,
	});
  });
  
  function saveOrUpdateCoupon() {
		document.getElementById("saveButton").disabled=true;
	  	document.getElementById("updateButton").disabled=true;
		
	  	var idForUpdate= $('#idForUpdate').val();
	  	var week= $('#weekNo').val();
	  	var weekInfo= $('#weekInfo').val();
	  	var typeId= $('#typeId').val();
	  	var minStack= $('#minStack').val();
	  	var minPerLine= $('#minPerLine').val();
	  	//var season= $('#season').val();
	  	var matchDate= $('#matchDate').val();
	  	var closeDate= $('#closeDate').val();
	  	var ruleDescription= $('#ruleDescription').val();
	  	
		var under2= 0;var under3= 0;var under4= 0;var under5= 0;var under6= 0;var under7= 0;var under8= 0;
		var maxUnder2=0;var maxUnder3=0;var maxUnder4=0;var maxUnder5=0;var maxUnder6=0;var maxUnder7=0;var maxUnder8=0;
		
		if($("#cb_under_2").prop('checked') == true){
			under2=1; maxUnder2=$('#max_under_2').val();
		}
		if($("#cb_under_3").prop('checked') == true){
			under3=1; maxUnder3=$('#max_under_3').val();
		}
		if($("#cb_under_4").prop('checked') == true){
			under4=1; maxUnder4=$('#max_under_4').val();
		}
		if($("#cb_under_5").prop('checked') == true){
			under5=1; maxUnder5=$('#max_under_5').val();
		}
		if($("#cb_under_6").prop('checked') == true){
			under6=1; maxUnder6=$('#max_under_6').val();
		}
		if($("#cb_under_7").prop('checked') == true){
			under7=1; maxUnder7=$('#max_under_7').val();
		}
		if($("#cb_under_8").prop('checked') == true){
			under8=1; maxUnder8=$('#max_under_8').val();
		}
	  	var form_data = new FormData();
	  	form_data.append("idForUpdate", idForUpdate);
	  	form_data.append("week", week);
		form_data.append("weekInfo", weekInfo);
		form_data.append("typeId", typeId);
		form_data.append("minStack", minStack);
		form_data.append("minPerLine", minPerLine);
		//form_data.append("season", season);
		form_data.append("matchDate", matchDate);
		form_data.append("closeDate", closeDate);
		form_data.append("ruleDescription", ruleDescription);
	  	
		form_data.append("under2", under2);
		form_data.append("under3", under3);
		form_data.append("under4", under4);
		form_data.append("under5", under5);
		form_data.append("under6", under6);
		form_data.append("under7", under7);
		form_data.append("under8", under8);
		form_data.append("maxUnder2", maxUnder2);
		// form_data.append("maxUnder2", maxUnder2);
		form_data.append("maxUnder3", maxUnder3);
		form_data.append("maxUnder4", maxUnder4);
		form_data.append("maxUnder5", maxUnder5);
		// form_data.append("maxUnder6", maxUnder6);
		form_data.append("maxUnder6", 3);
		form_data.append("maxUnder7", maxUnder7);
		form_data.append("maxUnder8", maxUnder8);
		var obj = new Object();
		var drawOdds  = [];
		var sr=$("#oddsRowCount").val();
		for(var i=0;i<=sr;i++){
			if($("#tr_odds_"+i).length>0){
				var from=$("#drawFrom_"+i).val();
				var to=$("#drawTo_"+i).val();
				if(from.length>0 && to.length>0){
					from=parseInt(from);
					to=parseInt(to);
					if(from<=to){
						var data= {};
						data['id']=$("#drawId_"+i).val();
						data['from']=$("#drawFrom_"+i).val();
						data['to']=$("#drawTo_"+i).val();
						data['odds2']= $("#odds_"+i+"_2").val();
						data['odds3']= $("#odds_"+i+"_3").val();
						data['odds4']= $("#odds_"+i+"_4").val();
						data['odds5']= $("#odds_"+i+"_5").val();
						data['odds6']= $("#odds_"+i+"_6").val();
						data['odds7']= $("#odds_"+i+"_7").val();
						data['odds8']= $("#odds_"+i+"_8").val();
						
						drawOdds.push(data);
					}else{
						alert('From-to value(s) in draw odds is incorrect.');
						return;
					}
				}
			}
		}
		
		obj.drawOdds=drawOdds;
	    var jsonString= JSON.stringify(obj);
		form_data.append("drawOdds", jsonString);
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/saveOrUpdateCoupon.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "pageNumber=" + pageNumber+"&masterId="+masterId+"&code=" + code+"&name=" + name + "&remark=" + remark + "&idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
			    	$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	//$('#dataTableGrid').html(response.dataGrid);
			    	
			    	//resetData();
				    $('#error').hide('slow');
					$('#couponDetailModel').modal('hide');
				    $('#modalInfo').modal('show');
				    //addClassForColor();
				    $('#GeneralMasterDataGrid').dataTable({
				    	"bLengthChange": false,
						"pageLength": 5,
						responsive:true,
					});
					
					
		      		//resetForm();
				}else{
					$('#error').html(response.result);
					$('#info').hide('slow');
					$('#error').show('slow');
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
	
  function edit(sr) {
	    $('#couponDetailModel').modal('show');
		
	  	document.getElementById("saveButton").disabled=true;
	  	document.getElementById("updateButton").disabled=false;
		
		var idForUpdate=$('#idForUpdate_'+sr).val();
		
	  	$('#idForUpdate').val(idForUpdate);
	  	
		var form_data = new FormData();
	  	form_data.append("idForUpdate", idForUpdate);
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/getCouponData.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					$('#weekNo').val(response.week);
					$('#weekInfo').val(response.weekInfo);
					$('#typeId').val(response.typeId);
					$('#minStack').val(response.minStack);
					$('#minPerLine').val(response.minPerLine);
					//$('#season').val(response.season);
					$('#matchDate').val(response.matchDate);
					$('#closeDate').val(response.closeDate);
					$('#ruleDescription').val(response.ruleDescription);
					
					$('#cb_under_2').prop('checked', response.under2==1);
					$('#cb_under_3').prop('checked', response.under3==1);
					$('#cb_under_4').prop('checked', response.under4==1);
					$('#cb_under_5').prop('checked', response.under5==1);
					$('#cb_under_6').prop('checked', response.under6==1);
					$('#cb_under_7').prop('checked', response.under7==1);
					$('#cb_under_8').prop('checked', response.under8==1);
					$('#max_under_2').val(response.maxUnder2);
					$('#max_under_3').val(response.maxUnder3);
					$('#max_under_4').val(response.maxUnder4);
					$('#max_under_5').val(response.maxUnder5);
					$('#max_under_6').val(response.maxUnder6);
					$('#max_under_7').val(response.maxUnder7);
					$('#max_under_8').val(response.maxUnder8);
					
					emptyOddsTable();
					$.each(response.drawOdds,function(index,data){
						addOddsRow(data.oId,data.from,data.to,data.odds2,data.odds3,data.odds4,data.odds5,data.odds6,data.odds7,data.odds8);
					});
					
					$('#error').hide('slow');
				}else{
					$('#error').html(response.message);
					$('#info').hide('slow');
					$('#error').show('slow');
				}
			},  
		    error: function(e){  
		      alert(e.status);
	           alert(e.responseText);
	           alert(thrownError);
		    }  
		});  
	}
	
	function deleteItem(sr) {
		if(confirm('Are you sure you want to delete this Record?')){
			var idForUpdate= $('#idForUpdate_'+sr).val();
			form_data = new FormData();
			form_data.append("pageNumber", pageNumber);
			form_data.append("idForDelete", idForUpdate);
			$.ajax({  
			    type: "POST",  	
			    url: "<?=$host?>/deleteInventoryItem.html",  
			    //data: "pageNumber=" + pageNumber+"&idForDelete="+idForDelete,
			    processData: false,
			    contentType: false,
			    data: form_data,
			    success: function(response){
			      	if(response.status == "Success"){
			      		$('#info').html(response.result);
			      		$('#dataTableGrid').html(response.dataGrid);
				    	//$('#dataTable2').html(response.dataGrid);
			      		$('#GeneralMasterDataGrid').dataTable({
			      			"bLengthChange": false,
			    			"pageLength": 4,
			    			responsive:true,
			    		});
					}
			      	else{
						$('#error').html(response.result);
						$('#info').hide('slow');
						$('#error').show('slow');
					}
				},  
			    error: function(e){  
			      alert('Error: ' + e);  
			    }  
			});  
		 }
	}
	function addNew() {
	  $('#couponDetailModel').modal('show');
		//$('#itemText').val($('#name_'+formFillForEditId).html());
		
	  	//document.getElementById("saveButton").disabled=true;
	  	//document.getElementById("updateButton").disabled=false;
		emptyOddsTable();
	  	addOddsRow();
	  	$('#idForUpdate').val("0");
		
		document.getElementById("saveButton").disabled=false;
	  	document.getElementById("updateButton").disabled=true;
	}
	function addOddsRow(id,from,to,odds2,odds3,odds4,odds5,odds6,odds7,odds8){
		if(id==null){
			id=''; from=''; to=''; odds2=0; odds3=0; odds4=0; odds5=0; odds6=0; odds7=0; odds8=0;
		}else{
			//$("#oddsTable tr:first").next().remove();
		}
		var sr=$("#oddsRowCount").val();
		sr++;
		$("#oddsRowCount").val(sr);
		var html='<tr id="tr_odds_'+sr+'">';
		html=html+'<td><div class="input-group" style="width:100%"><div class="input-group-prepend mx-0" style="width:50%"><input type="text" id="drawFrom_'+sr+'" class="input-group-text px-0" style="width:100%;font-size:0.75rem;background-color:#ffffff" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="phone" placeholder="from" value="'+from+'"></div><div class="input-group-append mx-0" style="width:50%"><input type="text" id="drawTo_'+sr+'" class="input-group-text px-0" style="width:100%;font-size:0.75rem;background-color:#ffffff" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="'+to+'" placeholder="to"></div></div></td>';
		
		if($("#cb_under_2").prop('checked') == true){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_2" value="'+odds2+'" class="form-control form-control-sm u2" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}else{
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_2" value="'+odds2+'" class="form-control form-control-sm u2" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}
		if($("#cb_under_3").prop('checked') == true){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_3" value="'+odds3+'" class="form-control form-control-sm u3" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}else{
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_3" value="'+odds3+'" class="form-control form-control-sm u3" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}
		if($("#cb_under_4").prop('checked') == true){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_4" value="'+odds4+'" class="form-control form-control-sm u4" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}else{
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_4" value="'+odds4+'" class="form-control form-control-sm u4" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}
		if($("#cb_under_5").prop('checked') == true){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_5" value="'+odds5+'" class="form-control form-control-sm u5" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}else{
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_5" value="'+odds5+'" class="form-control form-control-sm u5" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}
		if($("#cb_under_6").prop('checked') == true){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_6" value="'+odds6+'" class="form-control form-control-sm u6" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}else{
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_6" value="'+odds6+'" class="form-control form-control-sm u6" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}
		if($("#cb_under_7").prop('checked') == true){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_7" value="'+odds7+'" class="form-control form-control-sm u7" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}else{
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_7" value="'+odds7+'" class="form-control form-control-sm u7" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}
		if($("#cb_under_8").prop('checked') == true){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_8" value="'+odds8+'" class="form-control form-control-sm u8" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}else{
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_8" value="'+odds8+'" class="form-control form-control-sm u8" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
		}
		html=html+'<td class="text-right" style="width:30px;cursor:pointer;"><img src="../images/ic-delete.png" onclick="removeOddsRow('+sr+')" style="width:70%" alt=""/><input type="hidden" id="drawId_'+sr+'" value="'+id+'"/></td></tr>';
		$("#tr_th_odds").parent().append(html);
	}
	
	function removeOddsRow(sr){
		$("#tr_odds_"+sr).remove();
	}
	function emptyOddsTable(){
		var sr=$("#oddsRowCount").val();
		for(var i=0;i<=sr;i++){
			$("#tr_odds_"+i).remove();
		}
		$("#oddsRowCount").val("0");
	}
</script>

<script>
$(":checkbox").change(function(){
	if($("#cb_under_2").prop('checked') == true){
		$(".u2").removeAttr('disabled');
		$(".u2").attr('style','background-color:#ffffff');
	}else{
		$(".u2").prop("disabled", true);
		$(".u2").attr('style','background-color:#e9e9e9');
	}
	if($("#cb_under_3").prop('checked') == true){
		$(".u3").removeAttr('disabled');
		$(".u3").attr('style','background-color:#ffffff');
	}else{
		$(".u3").prop("disabled", true);
		$(".u3").attr('style','background-color:#e9e9e9');
	}
	if($("#cb_under_4").prop('checked') == true){
		$(".u4").removeAttr('disabled');
		$(".u4").attr('style','background-color:#ffffff');
	}else{
		$(".u4").prop("disabled", true);
		$(".u4").attr('style','background-color:#e9e9e9');
	}
	if($("#cb_under_5").prop('checked') == true){
		$(".u5").removeAttr('disabled');
		$(".u5").attr('style','background-color:#ffffff');
	}else{
		$(".u5").prop("disabled", true);
		$(".u5").attr('style','background-color:#e9e9e9');
	}
	if($("#cb_under_6").prop('checked') == true){
		$(".u6").removeAttr('disabled');
		$(".u6").attr('style','background-color:#ffffff');
	}else{
		$(".u6").prop("disabled", true);
		$(".u6").attr('style','background-color:#e9e9e9');
	}
	if($("#cb_under_7").prop('checked') == true){
		$(".u7").removeAttr('disabled');
		$(".u7").attr('style','background-color:#ffffff');
	}else{
		$(".u7").prop("disabled", true);
		$(".u7").attr('style','background-color:#e9e9e9');
	}
	if($("#cb_under_8").prop('checked') == true){
		$(".u8").removeAttr('disabled');
		$(".u8").attr('style','background-color:#ffffff');
	}else{
		$(".u8").prop("disabled", true);
		$(".u8").attr('style','background-color:#e9e9e9');
	}
});	
</script>
		
		
    </body>

</html>

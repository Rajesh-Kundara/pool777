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
	$idValue = mysql_insert_id();

	echo "<script>window.location.href='rules.php'</script>";
}
?>	
	
<body data-spy="scroll" data-target=".navbar-collapse">
<?php 
$activePage="matches";
include('common/header.php'); 
?>
<div class="culmn">
	
	<div class="container border my-4">
			<div class="row">                        
					<div class="col-md-12">
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-4"><h4 align="center"><u>Matches</u></h4></div>
								<div class="col-md-4" align="right"><button type="button" class="btn btn-info" aria-hidden="true" onClick="addNew()">Add New</button></div>
							</div>
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
								<div class="col-md-4"></div>
							</div>
							<div class="row" style="padding:2px">
							<div class="col" style="overflow-x: auto; white-space: nowrap;">	
							<?php
							$string ="<table id='DataGrid' align='center' width='100%' border='1' class='table-hover'>
									<thead>
									<tr  style='color:black'>
									<th width='5%' align='center'><b>S. No.</b></th>
									<th width='15%' ><b align='center'>Home Team</b></th>
									<th width='15%' ><b align='center'>Away Team</b></th>
									<th width='7%' ><b align='center'>Week#</b></th>
									<th width='18%' ><b align='center'>Match Date</b></th>
									<th width='35%' ><b align='center'>Result</b></th>
									<th width='5%' align='center'><b>Action</b></th>
									</tr>
									</thead>
									<tbody>"; 
									/*<th width='15%' ><b align='center'>League</b></th>
									<th width='15%' ><b align='center'>Season</b></th>*/
							$sr=0;
							$idForUpdate=0;
							
							$sql = "SELECT * FROM matches WHERE status='A' ORDER BY week DESC";
							if($week>0){
								$sql = "SELECT * FROM matches WHERE week ='$week' AND status='A' ORDER BY week DESC";
							}
							
							$stmt3 = $connection->query($sql);
							
							if ( $stmt3 ){
								while( $row3 = $stmt3->fetch_assoc()){ 
									$class="";
									$resultNotDeclared='checked';
									if($row3['isResultDeclared']){
										$resultNotDeclared='';
										if(($row3['homeScore']==$row3['awayScore'])){
											if($row3['homeScore']>0 && $row3['isHomeWinner']>0){
												$result="Score Draw";
											}else{
												$result="No Score Draw";
											}
											$class="text-secondary";
										}else if($row3['isHomeWinner']){
											$result=$row3['homeTeam']." won";
											$class="text-primary";
										}else if($row3['isAwayWinner']){
											$result=$row3['awayTeam']." won";
											$class="text-info";
										}
									}else{
										$result="Not declared";
										$class="text-dark";
									}
									$class='class="'.$class.'"';
									
									$result='';
									$string=$string."<tr style='height:20px;color:black;'>
										<td id='sr_".$sr."' align='center'>".($sr+1)."</td>
										
										<td id='homeTeam_".$sr."'>".$row3['homeTeam']."</td>
										<td id='awayTeam_".$sr."'>".$row3['awayTeam']."</td>
										<td id='week_".$sr."' align='center'>".$row3['week']."</td>
										<td id='matchDate_".$sr."'>".$row3['matchDate']."</td>
										
										<td id='result_".$sr."' ".$class." style='padding: 2px 5px 2px 5px;'>
											<table style='font-size:0.70rem; width:100%;'>
												<tr>
													<td width='25%'>
														<input type='text' class='form-control form-control-sm' style='width:50px; height:26px' id='homeScore_".$sr."' onkeyup='getWinner(event.charCode,$sr)' placeholder='score' value='".$row3['homeScore']."'>".$row3['homeTeam']."
													</td>
													<td width='25%'>
														<input type='text' class='form-control form-control-sm' style='width:50px; height:26px' id='awayScore_".$sr."' onkeyup='getWinner(event.charCode,$sr)' placeholder='score' value='".$row3['awayScore']."'>".$row3['awayTeam']."
													</td>
													<td width='30%'>
														<div class='form-check form-check-inline'>
															<input class='form-check-input' type='checkbox' $resultNotDeclared name='winnerNotDeclared' id='winnerNotDeclared_".$sr."' value='N'>
															<label class='form-check-label' for='inlineRadio4'>Not Declared</label>
														</div>
													</td>
													<td width='20%'>
														<button type='button' onClick='updateMatchResult($sr)' class='btn btn-primary btn-sm' style='width:50px; height:26px;padding:0px'>Save</button>
													</td>
												</tr>
												<tr style='display:none'>
													<td>
														<div class='form-check form-check-inline'>
														<input class='form-check-input' type='radio' disabled name='radioWinner' id='winnerHome' value='H'>
														<label class='form-check-label' for='inlineRadio1'>Home Team</label>
														</div>
													</td>
													<td>
														<div class='form-check form-check-inline'>
														<input class='form-check-input' type='radio' disabled name='radioWinner' id='winnerAway' value='A'>
														<label class='form-check-label' for='inlineRadio2'>Away Team</label>
														</div>
													</td>
													<td>
														<div class='form-check form-check-inline'>
														<input class='form-check-input' type='radio' disabled name='radioWinner' id='winnerDraw' value='D'>
														<label class='form-check-label' for='inlineRadio3'>Draw</label>
														</div>
													</td>
												</tr>
											</table>
											
										</td>
										
										<td align='center'>
										<img onClick='edit(".$sr.");' src='../images/editButton.png' border='0' title='Edit' width='16' height='16' />
										
										<input type='hidden' id='idForUpdate_".$sr."' value='".$row3['id']."'>
										<input type='hidden' id='winner_".$sr."' value='N'>
										</td>
										</tr>";
										//<img onClick='deleteItem(".$sr.");' src='images/delete_icon.gif' border='0' title='Delete' width='16' height='16' style='margin:0 10 0 10'/>
										$sr++;
										/*<br><span class='btn badge badge-secondary' onClick='ChangeMatchStatus(".$sr.")'>Change</span>*/
										/*<td id='league_".$sr."'>".$row3['league']."</td>
										<td id='season_".$sr."'>".$row3['season']."</td>*/
								}
							}				
							$string=$string."</tbody></table>";
							echo $string;
							?>
							</div>
						</div>
						<?php if($week){ ?>
						<div class="row">
							<div class="col-md-12 text-center p-2">
								<a href="declare_winners.php?week=<?=$week?>"><button type="button" class="btn btn-primary" aria-hidden="true">Declare Winners of week <?=$week?></button></a>
							</div>
						</div>
						<?php } ?>
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
       					<b>Add New Match Detail</b> <span id="tokenNoSpan1"></span>
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
		 												<!--<tr>
							 								<td width="30%">League :</td>
							 								<td width="70%">
																<select id="league" name="league" class="form-control">
																	<option value="0">Select</option>
																	<option value="1">League 1</option>
																	<option value="2">League 2</option>
																	<option value="3">League 3</option>
																	<option value="4">League 4</option>
																</select>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Season :</td>
							 								<td width="70%"><input type="text" id="season" class="form-control input-sm" placeholder="Enter season name..."/></td>
							 							</tr>-->
														<tr>
							 								<td width="30%">Week :</td>
							 								<td width="70%">
																<input type="text" id="weekNo" class="form-control input-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Week number"/>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Home Team :</td>
							 								<td width="70%">
																<input type="text" id="homeTeam" class="form-control input-sm" placeholder="Week info..."/>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Away Team :</td>
							 								<td width="70%">
																<input type="text" id="awayTeam" class="form-control input-sm" placeholder="Week info..."/>
															</td>
							 							</tr>
														<tr>
							 								<td width="30%">Match Date & Time:</td>
							 								<td width="70%">
																<input type="text" id="matchDate" class="form-control input-sm" placeholder="yyyy-mm-dd hh:mm"/>
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
							<button  type = "button" class="btn btn-success" id="saveButton" onclick="saveOrUpdateCoupon()">Save</button>
							<button  type='button'  class="btn btn-primary" id="updateButton" name="updateButton" onclick="saveOrUpdateCoupon()" disabled style="width:30%">Update</button>
							<button  type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						</div>
						</td>
	 				</tr>
	 			</table>
				<div class='row'>
					<div id="errorContainer"></div>
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
<div id="modalChangeMatchStatus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="changeMatchStatusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModalMatchWinner"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formUpdateMatchResult">
          <div class="form-group">
			<div>
				<div class="row">
					<div class="col-4 form-group">
					  <label for="userName">Home Score</label>
					  <input type="text" class="form-control" id="homeScore" onkeyup="getWinner(event.charCode)" placeholder="home score">
					</div>
					<div class="col-4 form-group">
					  <label for="userName">Away Score</label>
					  <input type="text" class="form-control" id="awayScore" onkeyup="getWinner(event.charCode)" placeholder="away score">
					</div>
				</div>
				<label class="col-form-label">Winner :</label>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" disabled name="radioWinner" id="winnerHome" value="H">
				  <label class="form-check-label" for="inlineRadio1">Home Team</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" disabled name="radioWinner" id="winnerAway" value="A">
				  <label class="form-check-label" for="inlineRadio2">Away Team</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" disabled name="radioWinner" id="winnerDraw" value="D">
				  <label class="form-check-label" for="inlineRadio3">Draw</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" name="winnerNotDeclared" id="winnerNotDeclared" value="N">
				  <label class="form-check-label" for="inlineRadio4">Not Declared</label>
				</div>
			</div>
		</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onClick="updateMatchResult()">Update</button>
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
	$('#matchDate').bootstrapMaterialDatePicker({
		format: 'YYYY-MM-DD HH:mm',
		switchOnClick : true,
		weekStart : 1, 
		minDate : new Date(),
		time: true }); 
	$('#closeDate').bootstrapMaterialDatePicker({ weekStart : 0, minDate : new Date(),time: false }); 
    
    //$('#matchDateTime').mdtimepicker(); //Initializes the time picker
	
	/*$('#DataGrid').dataTable({
		"bLengthChange": false,
		"pageLength": 5,
		responsive:true,
	});*/
  });
  
  function saveOrUpdateCoupon() {
		document.getElementById("saveButton").disabled=true;
	  	document.getElementById("updateButton").disabled=true;
		
	  	var idForUpdate= $('#idForUpdate').val();
	  	//var leagueId= $('#league').val();
	  	//var league= $('#league option:selected').text();
	  	//var season= $('#season').val();
	  	var week= $('#weekNo').val();
	  	var homeTeam= $('#homeTeam').val();
	  	var awayTeam= $('#awayTeam').val();
	  	var matchDate= $('#matchDate').val();
	  	
	  	var form_data = new FormData();
	  	form_data.append("idForUpdate", idForUpdate);
	  	//form_data.append("leagueId", leagueId);
		//form_data.append("league", league);
		//form_data.append("season", season);
		form_data.append("week", week);
		form_data.append("homeTeam", homeTeam);
		form_data.append("awayTeam", awayTeam);
		form_data.append("matchDate", matchDate);
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/saveOrUpdateMatch.php",  
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
					var html='<div id="loginError" class="alert alert-danger fade show" role="alert">'+response.message+'</div>';
					$("#errorContainer").html(html);
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
		    url: "<?=$host?>/api/getMatchDetail.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					//$('#league').val(response.leagueId);
					//$('#season').val(response.season);
					$('#weekNo').val(response.week);
					$('#homeTeam').val(response.homeTeam);
					$('#awayTeam').val(response.awayTeam);
					$('#matchDate').val(response.matchDate);
					
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
		
	  	$('#idForUpdate').val("0");
		
		document.getElementById("saveButton").disabled=false;
	  	document.getElementById("updateButton").disabled=true;
	}
	
	function ChangeMatchStatus(sr){
		var title=$('#homeTeam_'+sr).text()+" Vs "+$('#awayTeam_'+sr).text();
		$('#titleModalMatchWinner').text(title);
		$('#modalChangeMatchStatus').modal('show');
		
		var idForUpdate=$('#idForUpdate_'+sr).val();
	  	$('#idForUpdate').val(idForUpdate);
	}
	
	function updateMatchResult(i){
		var idForUpdate=$('#idForUpdate_'+i).val();
		
		var homeScore=$("#homeScore_"+i).val();
		var awayScore=$("#awayScore_"+i).val();
		var winnerNotDeclared=$("#winnerNotDeclared_"+i).prop('checked');
		var winner=$("#winner_"+i).val();
			//alert(winner);return;
		if(winnerNotDeclared==false){
			if(homeScore.length==00 || awayScore.length==0){
				alert("Please fill score!");return;
			}
		}
		
		
	  	var form_data = new FormData();
	  	form_data.append("idForUpdate", idForUpdate);
	  	form_data.append("winner", winner);
	  	form_data.append("homeScore", homeScore);
	  	form_data.append("awayScore", awayScore);
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/updateMatchResult.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
			    	$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	//$('#dataTableGrid').html(response.dataGrid);
			    	
			    	//resetData();
				    $('#error').hide('slow');
					$('#modalChangeMatchStatus').modal('hide');
				    $('#modalInfo').modal('show');
				    //addClassForColor();
				    $('#GeneralMasterDataGrid').dataTable({
				    	"bLengthChange": false,
						"pageLength": 5,
						responsive:true,
					});
					
					
		      		//resetForm();
				}else{
					var html='<div id="loginError" class="alert alert-danger fade show" role="alert">'+response.message+'</div>';
					$("#errorContainer").html(html);
				}
			},  
		    error: function(e){  
		      alert(e.status);
	           alert(e.responseText);
	           alert(thrownError);
		    }  
		});  
	}
	
	function getWinner(charCode,i){
		$("#winnerNotDeclared_"+i).prop('checked',false);
		var homeScore=parseInt($("#homeScore_"+i).val());
		var awayScore=parseInt($("#awayScore_"+i).val());
		var winner='N';
		if(homeScore==awayScore){
			winner='D';
		}else if(homeScore>awayScore){
			winner='H';
		}else if(homeScore<awayScore){
			winner='A';
		}
		$("#winner_"+i).val(winner);
		return charCode >= 48 && charCode <= 57;
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

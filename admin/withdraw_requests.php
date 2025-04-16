<?php 
include('../common/config.php');
if(!isset($_SESSION['fullname']))
{
	echo "<script>window.location.href='index.php'</script>";
}
?>

<html class="no-js" lang="en">
<?php 
include('common/head.php');

ini_set("display_errors","on");
?>	
	
<body data-spy="scroll" data-target=".navbar-collapse">
<?php 
$activePage="withdrawRequests";
include('common/header.php'); ?>
<div class="culmn">
		<div class="container border my-4">
			<div class="row">                        
					<div class="col-md-12">
							<div class="container">
								<div class="row">
									<div class="col-md-4"></div>
									<div class="col-md-4"><h4><u>Withdraw Requests</u></h4></div>
									<div class="col-md-4"></div>
								</div><br>
								<div class="row">
									<div class="col text-center" style="overflow-x: auto; white-space: nowrap;">
									<?php
									//include('common/functions.php');
									$string ="<table id='DataGrid' align='center' width='100%' class='table border dt-responsive table-hover'>
											<thead>
											<tr>
												<th class='px-2 border' width='10%'>S. No.</th>
												<th class='p-1 border' width='30%'>Name</th>
												<th class='p-1 border text-center' width='20%'>Amount</th>
												<th class='p-1 border text-center' width='30%'>Date</th>
												<th class='px-4 border text-right' width='10%'>Status</th>
											</tr></thead><tbody>"; 
									$sr=1;
									$idForUpdate=0;

									//user stacked values on coupon
									$sql = "SELECT id, amount,requestDate,status,
											(SELECT CONCAT(f_name,' ',m_name,' ',l_name) FROM users WHERE id=userId) as name FROM withdraw_requests
											ORDER BY requestDate DESC";
									$stmt3 = $connection->query($sql);
									if ( $stmt3 ){
										while( $row3 = $stmt3->fetch_assoc()){
											$string=$string."<tr id='tr_".$sr."' class='border'>
												<td class='px-4 border'>".$sr."</td>
												<td class='p-1 border'>".$row3['name']."</td>
												<td class='p-1 border text-center'>".$row3['amount']."</td>
												<td class='p-1 border text-center'>".$row3['requestDate']."</td>
												<td class='p-1 border text-center'>".$row3['status']."
												<input type='hidden' id='stack_".$sr."' value='".$row3['id']."'>
												</td>
												</tr>";
												$sr++;
										}
									}	else{
										echo "something went wrong.".$stmt3->error();
									}			
									$string=$string."</tbody></table>";
									echo $string;
									?>
									<div id="errorContainer" class="mt-2"></div>
								</div>
							  </div>
							</div>
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

<script>
  $(document).ready(function(){
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
	
	function selectUnder() {
		$("#undersSelected").html("");
		for(var i=2;i<=8;i++){
			if($('#cb_under_'+i).length>0){
				if($('#cb_under_'+i).prop("checked")){
					var html='<span class="text-dark">'+($("#label_cb_under_"+i).text())+'</span>';
					$("#undersSelected").append(html);
				}else{
					var html='<span style="color:#d8d8d8">'+($("#label_cb_under_"+i).text())+'</span>';
					$("#undersSelected").append(html);
				}
			}
		}
	}
	
	function selectMatch(sr) {
		$('#cb_match_'+sr).prop("checked",!$('#cb_match_'+sr).prop("checked"));
		if($('#cb_match_'+sr).prop("checked")){
			$('#tr_'+sr).addClass('table-primary')
		}else{
			$('#tr_'+sr).removeClass('table-primary')
		}
		
		var totalMatches=parseInt($("#totalMatches").val());
		var totalMatchesSelected=0;
		for(var i=0;i<totalMatches;i++){
			if($('#cb_match_'+i).prop("checked")){
				totalMatchesSelected++;
			}
		}
		$('#countMatchesSelected').text(totalMatchesSelected);
	}
	
	function stack() {
		$("#error").alert('close');
		
		var isUnderSelected=false;
		var under2= 0;var under3= 0;var under4= 0;var under5= 0;var under6= 0;var under7= 0;var under8= 0;
		if($("#cb_under_2").prop('checked') == true){
			under2=1; isUnderSelected=true;
		}
		if($("#cb_under_3").prop('checked') == true){
			under3=1; isUnderSelected=true;
		}
		if($("#cb_under_4").prop('checked') == true){
			under4=1; isUnderSelected=true;
		}
		if($("#cb_under_5").prop('checked') == true){
			under5=1; isUnderSelected=true;
		}
		if($("#cb_under_6").prop('checked') == true){
			under6=1; isUnderSelected=true;
		}
		if($("#cb_under_7").prop('checked') == true){
			under7=1; isUnderSelected=true;
		}
		if($("#cb_under_8").prop('checked') == true){
			under8=1; isUnderSelected=true;
		}
		if(!isUnderSelected){
			alert("Please select from unders!"); return;
		}
		var minStack=parseInt($("#minStack").text());
		var stackAmount=parseInt($("#stackAmount").val());
		
		if(stackAmount<minStack){
			alert("Minimum stack value is "+minStack+" N."); return;
		}
	  	var couponId=$("#couponId").val();
		var week=$("#week").text();
		
		var totalMatches=parseInt($("#totalMatches").val());
		var matchesSelected="";
		
		for(var i=0;i<totalMatches;i++){
			if($('#cb_match_'+i).prop("checked")){
				if(matchesSelected.length==0){
					matchesSelected=$('#matchId_'+i).val();
				}else{
					matchesSelected=matchesSelected+","+$('#matchId_'+i).val();
				}
			}
		}
		
		var form_data = new FormData();
	  	form_data.append("under2", under2);
		form_data.append("under3", under3);
		form_data.append("under4", under4);
		form_data.append("under5", under5);
		form_data.append("under6", under6);
		form_data.append("under7", under7);
		form_data.append("under8", under8);
		form_data.append("stackAmount", stackAmount);
		form_data.append("couponId", couponId);
		form_data.append("week", week);
		form_data.append("matchesSelected", matchesSelected);
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/placeBet.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					$('#modalInfoTitle').html("Success!");
					$('#modalInfoBody').html(response.message);
			    	
				    $('#modalInfo').modal('show');
				}else{
					var html='<div id="error" class="alert alert-danger fade show" role="alert">'+response.message+'</div>';
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
	function getStackDetail(sr){
		$('#couponDetailModel').modal('show');
		
		var stackId=$('#stack_'+sr).val();
		var draws=$('#draws_'+sr).val();
		
		var form_data = new FormData();
	  	form_data.append("stackId", stackId);
	  	form_data.append("draws", draws);
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/getStackDetail.php",  
		    processData: false,
		    contentType: false,
		    data: form_data,
		    //data: "idForUpdate=" + idForUpdate,  
		    success: function(response){
				response=JSON.parse(response);
		      	if(response.success == "1"){
					$('#couponName').text(response.name);
					$('#week').text(response.week);
					$('#stackAmount').text(response.stackAmount+ " N");
					$('#status').text(response.status);
					
					var unders="";
					if(response.under2==1){
						unders=unders+"<span style='padding-right:10px'>2</span>";
					}
					if(response.under3==1){
						unders=unders+"<span style='padding-right:10px'>3</span>";
					}
					if(response.under4==1){
						unders=unders+"<span style='padding-right:10px'>4</span>";
					}
					if(response.under5==1){
						unders=unders+"<span style='padding-right:10px'>5</span>";
					}
					if(response.under6==1){
						unders=unders+"<span style='padding-right:10px'>6</span>";
					}
					if(response.under7==1){
						unders=unders+"<span style='padding-right:10px'>7</span>";
					}
					if(response.under8==1){
						unders=unders+"<span style='padding-right:10px'>8</span>";
					}
					$('#unders').html(unders);
					var data=response;
					emptyOddsTable();
					addOddsRow(data.oId,data.dFrom,data.dTo,data.odds2,data.odds3,data.odds4,data.odds5,data.odds6,data.odds7,data.odds8,data.under2,data.under3,data.under4,data.under5,data.under6,data.under7,data.under8);
					
					emptyMatchesTable();
					$.each(response.matches,function(index,data){
						addMatchRow(data.homeTeam,data.awayTeam,data.homeScore,data.awayScore,data.isResultDeclared,data.winner);
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
	
	function addOddsRow(id,from,to,odds2,odds3,odds4,odds5,odds6,odds7,odds8,under2,under3,under4,under5,under6,under7,under8){
		
		var sr=$("#oddsRowCount").val();
		sr++;
		$("#oddsRowCount").val(sr);
		var html='<tr id="tr_odds_'+sr+'">';
		html=html+'<td class="border bg-primary text-white"><div class="input-group" style="width:100%"><div class="input-group-prepend mx-0" style="width:50%"><input type="text" id="drawFrom_'+sr+'" class="input-group-text px-0" style="width:100%;font-size:0.75rem;" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="phone" placeholder="from" value="'+from+'"></div><div class="input-group-append mx-0" style="width:50%"><input type="text" id="drawTo_'+sr+'" class="input-group-text px-0" style="width:100%;font-size:0.75rem;" disabled onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="'+to+'" placeholder="to"></div></div></td>';
		
		var trh='<tr id="tr_th_odds"><th style="text-align:center;width:60px;" class="border bg-primary text-white">Draws range</th>';
																		
			
		if(under2==1){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_2" value="'+odds2+'" class="form-control form-control-sm u2" style="width:100%;height:100%;background-color:#ffffff" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			trh=trh+'<th style="text-align:center;width:60px;" class="border">Under 2</th>';
		}
		if(under3==1){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_3" value="'+odds3+'" class="form-control form-control-sm u3" style="width:100%;height:100%;background-color:#ffffff" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			trh=trh+'<th style="text-align:center;width:60px;" class="border">Under 3</th>';
		}
		if(under4==1){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_4" value="'+odds4+'" class="form-control form-control-sm u4" style="width:100%;height:100%;background-color:#ffffff" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			trh=trh+'<th style="text-align:center;width:60px;" class="border">Under 4</th>';
		}
		if(under5==1){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_5" value="'+odds5+'" class="form-control form-control-sm u5" style="width:100%;height:100%;background-color:#ffffff" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			trh=trh+'<th style="text-align:center;width:60px;" class="border">Under 5</th>';
		}
		if(under6==1){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_6" value="'+odds6+'" class="form-control form-control-sm u6" style="width:100%;height:100%;background-color:#ffffff" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			trh=trh+'<th style="text-align:center;width:60px;" class="border">Under 6</th>';
		}
		if(under7==1){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_7" value="'+odds7+'" class="form-control form-control-sm u7" style="width:100%;height:100%;background-color:#ffffff" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			trh=trh+'<th style="text-align:center;width:60px;" class="border">Under 7</th>';
		}
		if(under8==1){
			html=html+'<td class="border"><input type="text" id="odds_'+sr+'_8" value="'+odds8+'" class="form-control form-control-sm u8" style="width:100%;height:100%;background-color:#ffffff" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			trh=trh+'<th style="text-align:center;width:60px;" class="border">Under 8<input type="hidden" id="oddsRowCount" value="0"/></th>';
		}
		
		html=html+'<td class="text-right" style="width:30px;cursor:pointer;"><input type="hidden" id="oId_'+sr+'" value="'+id+'"/></td></tr>';
		trh=trh+'</tr>';
		$("#oddsTable").append(trh);
		$("#oddsTable").append(html);
	}
	var matchCount=1;
	function addMatchRow(homeTeam,awayTeam,homeScore,awayScore,isResultDeclared,winner){
		var html;
		if(matchCount==1){
			html="<tr><th class='px-2 border' width='10%'>S. No.</th><th class='p-1 border border-right-0 text-right' width='25%'>Home Team</th><th class='p-1 text-center border border-left-0 border-right-0' width='5%'>&times;</th><th class='p-1 border border-left-0 text-left' width='25%'>Away Team</th><th class='p-1 border text-center' width='25%'>Result</th></tr>";
		}
		var result;
		var cls;
		if(isResultDeclared==1){
			if(winner==3){
				result="Score Draw";
				cls="text-secondary";
			}else if(winner==0){
				result="No Score Draw";
				cls="text-secondary";
			}else if(winner==1){
				result="Home";
				cls="text-success";
			}else if(winner==2){
				result="Away";
				cls="text-info";
			}else{
				result="Not declared";
				cls="text-dark";
			}
		}else{
			result="Not declared";
			cls="text-dark";
		}
		
		html=html+"<tr class='border'><td class='px-3 border'>"+matchCount+"</td>";
		html=html+"<td class='p-1 border border-right-0 text-right'>"+homeTeam+"</td>";
		html=html+"<td class='p-1 text-center'>("+homeScore+")&times;("+awayScore+")</td>";
		html=html+"<td class='p-1 border border-left-0 text-left'>"+awayTeam+"</td>";
		html=html+"<td class='px-2 border text-left "+cls+"'>"+result+"</td> </tr>";
		
		$("#matchesTable").append(html);
		matchCount++;
	}
	function emptyOddsTable(){
		$("#oddsTable").html('');
	}
	function emptyMatchesTable(){
		$("#matchesTable").html('');
		matchCount=1;
	}
</script>
	
    </body>

</html>

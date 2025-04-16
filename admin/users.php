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
        <div class="culmn">
<?php 
$activePage="clients";
include('common/header.php'); 
?>

			<div class="container border my-4">
				<div class="row">                        
				   <div class="col-md-12">
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4"><h4><u>Clients</u></h4></div>
							<div class="col-md-4"></div>
						</div><br>
						<div class="row">
							<div class="col" style="overflow-x: auto; white-space: nowrap;">
								<?php
								$string ="<table id='DataGrid' align='center' width='100%' border='1' class='table dt-responsive'>
										<thead>
										<tr  style='color:black'>
										<th width='5%' class='border' align='center'><b>S. No.</b></th>
										<th width='10%' class='border'><b align='center'>Name</b></th>
										<th width='10%' class='border'><b align='center'>Username</b></th>
										<th width='10%' class='border'><b align='center'>Balance</b></th>
										<th width='10%' class='border'><b align='center'>Company</b></th>
										<th width='15%' class='border'><b align='center'>Address</b></th>
										<th width='10%' class='border'><b align='center'>Phone</b></th>
										<th width='10%' class='border'><b align='center'>Gsm Phone</b></th>
										<th width='10%' class='border' align='center'><b>Status</b></th>
										<th width='10%' class='border' align='center'><b>Action</b></th>
										</tr>
										</thead>
										<tbody>"; 
								$sr=0;
								$idForUpdate=0;

								$sql = "SELECT a.*,(SELECT SUM(amount) from balance WHERE userId=a.id) as balance FROM users a WHERE status='A'";
								$stmt3 = $connection->query($sql);
								if ( $stmt3 ){ 
									while( $row3 = $stmt3->fetch_assoc()){ 
										$name=trim($row3['f_name']." ".$row3['m_name']);
										$name=trim($name." ".$row3['l_name']);
										$string=$string."<tr style='height:20px;color:black;'>
											<td id='sr_".$sr."' align='center' class='border'>".($sr+1)."</td>
											<td id='name_".$sr."' class='border'>".$name."</td>
											<td id='username_".$sr."' class='border'>".$row3['userName']."</td>
											<td id='balance_".$sr."' class='border'>".$row3['balance']."</td>
											<td id='company_".$sr."' class='border'>".$row3['company']."</td>
											<td id='address_".$sr."' class='border'>"."-"."</td>
											<td id='phone_".$sr."' class='border'>+".$row3['countryCode']." ".$row3['phone']."</td>
											<td id='gsmphone_".$sr."' class='border'>+".$row3['countryCode_gsm']." ".$row3['phone_gsm']."</td>
											<td id='status_".$sr."' align='center' class='border'>".$row3['status']."</td>
											<td align='center' class='border'>
											<img onClick='edit(".$sr.");' src='../images/editButton.png' border='0' title='Edit' width='16' height='16' />
											
											<input type='hidden' id='idForUpdate_".$sr."' value='".$row3['id']."'>
											</td>
											</tr>";
											//<img onClick='deleteItem(".$sr.");' src='images/delete_icon.gif' border='0' title='Delete' width='16' height='16' style='margin:0 10 0 10'/>
											$sr++;
									}
								}	else{
									echo "No records found".$stmt3->error();
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
							 								<td width="30%">Add fund :</td>
							 								<td width="70%">
																<div class="input-group">
																	<input type="text" id="amount" class="form-control input-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Enter Amount"/>
																	<div class="input-group-append">
																		<span class="input-group-text">&#8358;</span>
																	</div>
																</div></td>
							 							</tr>
														<tr>
							 								<td width="30%">Remark :</td>
							 								<td width="70%">
																<div class="input-group">
																	<input type="text" id="remark" class="form-control input-sm" placeholder="Remarks..."/>
																</div></td>
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
							<button  type = "button" class="btn btn-success" id="saveButton" onclick="save()">Save</button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="javascript:location.reload();">Close</button>
      </div>
    </div>
  </div>
</div>

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
    $('#timepicker').mdtimepicker(); //Initializes the time picker
	
	$('#DataGrid').dataTable({
		"bLengthChange": false,
		"pageLength": 5,
		responsive:true,
	});
  });
  
  function save() {
	  	var parentId= $('#idForUpdate').val();
	  	var amount= $('#amount').val();
	  	var remark= $('#remark').val();
	  	
		if(amount.length==0){
			alert("Please enter amount!");
			return;
		}
		document.getElementById("saveButton").disabled=true;
	  	var form_data = new FormData();
	  	form_data.append("userId", parentId);
	  	form_data.append("amount", amount);
		form_data.append("remark", remark);
		
		$.ajax({
		    type: "POST",  	
		    url: "<?=$host?>/api/addBalance.php",  
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
		
	  	document.getElementById("saveButton").disabled=false;
	  	
		var idForUpdate=$('#idForUpdate_'+sr).val();
		
	  	$('#idForUpdate').val(idForUpdate);
	  	 
	}
</script>
<script>		
$(function(){
	$( ".datepicker1" ).datepicker({ 
		dateFormat: 'dd-mm-yy',
		minDate: 0		
	}).val();
});
</script>
<script>
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
});
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

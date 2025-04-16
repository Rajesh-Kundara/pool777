<?php 
include('common/config.php');

?>

<html class="no-js" lang="en">
<?php 
include('common/head.php');

?>

<?php 
ini_set("display_errors","on");

$unders=array();
$undersNumber=array();

if(!empty($_GET['week'])){
	$week=$_GET['week'];
}else{
	$week="1";
}
?>	
	
<body data-spy="scroll" data-target=".navbar-collapse">
<?php
$activePage="result";
include('common/header.php'); 
?>
<div class="culmn">
	<div class="container px-0 py-3" style="max-width:900px">
		<div class="row border mx-0 py-3">
			<div class="col text-center" style="overflow-x: auto; white-space: nowrap;">
				<?php
				$string ="<table align='center' width='100%' class=' table-hover'>
						<tr>
							<th class='px-2 border' width='10%'>S. No.</th>
							<th class='p-1 border border-right-0 text-right' width='25%'>Home Team</th>
							<th class='p-1 text-center border border-left-0 border-right-0' width='5%'>&times;</th>
							<th class='p-1 border border-left-0 text-left' width='25%'>Away Team</th>
							<th class='p-1 border text-center' width='25%'>Result</th>
							<th class='px-4 border' width='10%'>Status</th>
						</tr>"; 
				$sr=1;
				$idForUpdate=0;

				$sql = "SELECT * FROM matches WHERE week=".$week." AND status='A'";
				$stmt3 = $connection->query($sql);
				// echo mysql_error();
				if ( $stmt3 ){
					while( $row3 = $stmt3->fetch_assoc() ){
						$class="";
						if($row3['isResultDeclared']){
							if(($row3['homeScore']==$row3['awayScore'])){
								if($row3['homeScore']>0 && $row3['isHomeWinner']>0){
									$result="Score Draw";
								}else{
									$result="No Score Draw";
								}
								$class="text-secondary";
							}else if($row3['isHomeWinner']){
								$result="Home";
								$class="text-success";
							}else if($row3['isAwayWinner']){
								$result="Away";
								$class="text-info";
							}
						}else{
							$result="Not declared";
							$class="text-dark";
						}
						//$class='class="'.$class.'"';
						
						$string=$string."<tr id='tr_".$sr."' class='border'>
							<td class='px-4 border'>".$sr."</td>
							<td class='p-1 border border-right-0 text-right'>".$row3['homeTeam']."</td>
							<td class='p-1 text-center'>(".$row3['homeScore'].")&times;(".$row3['awayScore'].")</td>
							<td class='p-1 border border-left-0 text-left'>".$row3['awayTeam']."</td>
							<td class='px-4 border text-left $class'>".$result."</td>
							<td class='p-1 border'>FT</td>
							</tr>";
							$sr++;
					}
				}				
				$string=$string."<tr><td colspan='5'><input type='hidden' id='totalMatches' value='".$sr."'></td></tr></tbody></table>";
				echo $string;
				?>
			</div>
		</div>
		
		<?php
		$sql = "SELECT a.id,a.name,b.id as couponId,b.under2,b.under3,b.under4,b.under5,
				b.under6,b.under7,b.under8 FROM coupontypemaster a
				LEFT JOIN coupons b ON b.typeId=a.id
				WHERE b.week=$week AND b.status='A'";
		$result = $connection->query($sql); // Execute the query
		if ( $result ){
			while( $row = $result->fetch_assoc()){
				$couponTypeId=$row['id'];
				$couponId=$row['couponId'];
				$under2=$row['under2'];
				$under3=$row['under3'];
				$under4=$row['under4'];
				$under5=$row['under5'];
				$under6=$row['under6'];
				$under7=$row['under7'];
				$under8=$row['under8'];
		?>
		<div class="row border mx-0 py-3">
			<div class="col-sm-2">
				<?=$row['name']?>
			</div>
			<div class="col-sm-2">
				<?php
				$sql="SELECT COUNT(id) as count FROM matches";
				$suffix=" Draws";
				$winnerType;
				switch($couponTypeId){
					case 1: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
					case 2: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=0 AND week=$week"; $suffix=" Homes"; $winnerType=1; break;
					case 3: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=0 AND isAwayWinner=1 AND week=$week"; $suffix=" Aways"; $winnerType=2; break;
					case 4: $sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" General Draws"; $winnerType=0; break;
					case 5: $sql=$sql." WHERE isResultDeclared=1 AND isHomeWinner=1 AND isAwayWinner=1 AND week=$week"; $suffix=" Score Draws"; $winnerType=0; break;
					case 6: case 7: case 8: case 9: case 10:
						$sql=$sql." WHERE isResultDeclared=1 AND ((isHomeWinner=1 AND isAwayWinner=1) OR (isHomeWinner=0 AND isAwayWinner=0)) AND week=$week"; $suffix=" Draws"; $winnerType=0; break;
				}
				$result2 = $connection->query($sql); // Execute the query
				$row2 = $result2->fetch_assoc();
				$draws=$row2['count'];
				echo $draws.$suffix;
				
				//getting draw range for coupon
				$sql="SELECT * FROM couponodds WHERE couponId=$couponId";
				$result2 = $connection->query($sql); // Execute the query
				// $row2 = mysql_fetch_assoc($result2);
				// $row2 = $result2->fetch_assoc();
				// $dFrom=$row2['dFrom'];
				// $dTo=$row2['dTo'];
				// Initialize variables to avoid warnings
				$dFrom = null;
				$dTo = null;

				if ($result2 && $result2->num_rows > 0) {
					// Fetch the result
					$row2 = $result2->fetch_assoc();
					$dFrom = $row2['dFrom'];
					$dTo = $row2['dTo'];
				} else {
					// Handle the case when no rows are returned
					echo "No data found for couponId: $couponId";
				}
				?>
			</div>
			<div class="col-sm-8" style="overflow-x: auto; white-space: nowrap;">
				<?php
				$trh="<tr class='bg-light'><th class='border bg-primary text-white' style='width:100px'>$suffix</th>";
				
				if($under2) $trh=$trh."<th class='border'>Under 2</th>";
				if($under3) $trh=$trh."<th class='border'>Under 3</th>";
				if($under4) $trh=$trh."<th class='border'>Under 4</th>";
				if($under5) $trh=$trh."<th class='border'>Under 5</th>";
				if($under6) $trh=$trh."<th class='border'>Under 6</th>";
				if($under7) $trh=$trh."<th class='border'>Under 7</th>";
				if($under8) $trh=$trh."<th class='border'>Under 8</th>";
					
				$trh=$trh."</tr>";
				
				$winnerU2=0;$winnerU3=0;$winnerU4=0;$winnerU5=0;$winnerU6=0;$winnerU7=0;$winnerU8=0;
				$tr="<tr><th class='border bg-primary text-white' style='width:100px'>$dFrom - $dTo</th>";
				
				$sql="SELECT * FROM stacks WHERE couponId=$couponId";
				$result3 = $connection->query($sql); // Execute the query
				if($result3){
					while( $row3 = $result3->fetch_assoc()){
						$sql="SELECT COUNT(id) as winnerTeamCount FROM stackdetail WHERE parentId=".$row3['id']." AND winner=$winnerType";
						
						$result4 = $connection->query($sql); // Execute the query
						// $row4 = mysql_fetch_assoc($result4);
						$row4 = $result4->fetch_assoc();
						$winnerTeamCount=$row4['winnerTeamCount'];
						if($row3['under2'] && $winnerTeamCount>=2){
							$winnerU2++;
						}
						if($row3['under3'] && $winnerTeamCount>=3){
							$winnerU3++;
						}
						if($row3['under4'] && $winnerTeamCount>=4){
							$winnerU4++;
						}
						if($row3['under5'] && $winnerTeamCount>=5){
							$winnerU5++;
						}
						if($row3['under6'] && $winnerTeamCount>=6){
							$winnerU6++;
						}
						if($row3['under7'] && $winnerTeamCount>=7){
							$winnerU7++;
						}
						if($row3['under8'] && $winnerTeamCount>=8){
							$winnerU8++;
						}
					}
				}
				if($under2) $tr=$tr."<th class='border'>$winnerU2</th>";
				if($under3) $tr=$tr."<th class='border'>$winnerU3</th>";
				if($under4) $tr=$tr."<th class='border'>$winnerU4</th>";
				if($under5) $tr=$tr."<th class='border'>$winnerU5</th>";
				if($under6) $tr=$tr."<th class='border'>$winnerU6</th>";
				if($under7) $tr=$tr."<th class='border'>$winnerU7</th>";
				if($under8) $tr=$tr."<th class='border'>$winnerU8</th>";
					
				$tr=$tr."</tr>";
				
				$winnersTable="<table class='border mx-0 py-3 text-center' width='100%' style='font-size: 0.85rem;'>".$trh.$tr."</table>";
				
				echo $winnersTable;
				?>
			</div>
		</div>
		<?php } } else {
    // Handle query failure
    die("Query failed: " . $connection->error);
} ?>
	</div>

<?php include('common/footer.php'); ?>
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

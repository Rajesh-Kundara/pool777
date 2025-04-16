<?php 
include('common/config.php');
?>

<html class="no-js" lang="en">
<?php 
include('common/head.php');

?>

<?php 
ini_set("display_errors","on");

?>	
	
<body data-spy="scroll" data-target=".navbar-collapse">
<?php include('common/header.php'); ?>
<div class="culmn">
	<!--Test section-->
	<section id="test" class="test roomy-60 fix">
		<div class="container containerClass">
			<div class="row">                        
				<div class="main_test fix">
					<div class="col-md-12">
						<div class="test_item fix">
							<div class="container">
							  <div class="row">
								<div class="col col-lg-3">
								  <div>
									<h5><span class="badge badge-primary" id="week">Welcome To Pools777</span></h5>
									RC No: 88 99 66</br>
									Pools Promoters License: 3322
								  </div>
								</div>
								<div class="col text-center">
									<div class="card mt-0 text-center" >
										<div class="card-header p-1 bg-primary text-white" ><span >Pools777 - Football Betting Website | Football Pools Betting | Football Forecast</span></div>
										<div class="card-body p-3">
											<span class="card-title">REGISTER NOW FOR A LIFE CHANGING EXPERIENCE IN POOLS.</span>
											<p class="my-1 text-left">The pools777.com website, the first Nigerian website on football pools betting and indeed AFRICAN, is a service offered by Pools777 Limited to provide an exciting avenue for football pools stakers from any part of the world, to take part in pools betting based on the weekly fixtures as published by the Pools Promoters Association in London.</p>
											<p class="my-1 text-left">Over the years we have built a solid reputation based on our transparent reliability. We remain very proud to have played great roles in turning around the lives and fortunes of so many people, ever since we started. And we still look forward to the important part we shall play in the making of many more people. For a variety of fixed odd coupons and TC coupons, classified football pools results as soon as they are confirmed, www.pools777.com is the one stop website.</p>
										</div>
									</div>
									<div id="errorContainer" class="mt-2"></div>
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

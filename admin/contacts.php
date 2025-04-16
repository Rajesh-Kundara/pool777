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
$activePage="contacts";
include('common/header.php'); ?>
			<div class="container border my-4">
				<div class="row">                        
				   <div class="col-md-12">
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4"><h4><u>Contacts</u></h4></div>
							<div class="col-md-4"></div>
						</div><br>
						<div class="row">
							<div class="col" style="overflow-x: auto; white-space: nowrap;">
							<?php
								$string ="<table id='DataGrid' width='100%' class='table border dt-responsive'>
										<thead>
										<tr  style='color:black' class='border'>
										<th width='5%' class='border'><b>S. No.</b></th>
										<th width='10%' class='border'><b>Date</b></th>
										<th width='10%' class='border'><b>Name</b></th>
										<th width='10%' class='border'><b>Username</b></th>
										<th width='10%' class='border'><b>Country</b></th>
										<th width='10%' class='border'><b>Phone</b></th>
										<th width='15%' class='border'><b>Email</b></th>
										<th width='20%' class='border'><b>Purpose</b></th>
										<th width='10%' class='border'><b>Description</b></th>
										</tr>
										</thead>
										<tbody>"; 
								$sr=0;
								$idForUpdate=0;

								// echo $sql = "SELECT a.*,name,(SELECT userName from users WHERE id=a.userId) as userName, 
								// 		(SELECT name from countries WHERE id=a.country) as country
								// 		FROM contacts a WHERE status='A'";
								$sql = "SELECT  a.*, u.userName, u.f_name ,u.m_name, u.l_name ,c.name AS country 
										FROM contacts a LEFT JOIN users u ON a.userId = u.id 
										LEFT JOIN countries c ON a.country = c.id WHERE a.status = 'A'";
								$stmt3 = $connection->query($sql);
								if ( $stmt3 ){ 
									while( $row3 = $stmt3->fetch_assoc()){ 
										$name=trim($row3['f_name']." ".$row3['m_name']);
										$name=trim($name." ".$row3['l_name']);
										$string=$string."<tr style='height:20px;color:black;'>
											<td id='sr_".$sr."' class='border'>".($sr+1)."</td>
											<td id='date_".$sr."' class='border'>".$row3['date']."</td>
											<td id='name_".$sr."' class='border'>".$row3['name']."</td>
											<td id='username_".$sr."' class='border'>".$row3['userName']."</td>
											<td id='country_".$sr."' class='border'>".$row3['country']."</td>
											<td id='phone_".$sr."' class='border'>".$row3['phone']."</td>
											<td id='email_".$sr."' class='border'>".$row3['email']."</td>
											<td id='purpose_".$sr."' class='border'>".$row3['purpose']."
											<input type='hidden' id='description_".$sr."' value='".$row3['description']."'/></td>
											<td id='purpose_".$sr."' class='border'>
											<input type='button' id='btnView_".$sr."' class='btn btn-primary' onClick='viewDetail(".$sr.")' value='View'/></td>
											</tr>";
											//<img onClick='deleteItem(".$sr.");' src='images/delete_icon.gif' border='0' title='Delete' width='16' height='16' style='margin:0 10 0 10'/>
											$sr++;
									}
								}	else{
									echo "No records found" .$stmt3->error;
								}			
								$string=$string."</tbody></table>";
								echo $string;
								?>
							</div>
						</div>
					</div>
				</div>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
  
  function viewDetail(sr) {
	  	var name= $('#name_'+sr).text();
	  	var description= $('#description_'+sr).val();
	  	
		$('#modalInfoTitle').html(name);
		$('#modalInfoBody').html("Description : "+description);
		
		$('#modalInfo').modal('show');
	}  
	
</script>

    </body>

</html>

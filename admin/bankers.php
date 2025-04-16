<?php
include('../config.php');
if (!isset($_SESSION['fullname'])) {
	echo "<script>window.location.href='index.php?q=error'</script>";
}
?>

<html class="no-js" lang="en">
<?php
include('common/head.php');

?>

<?php
ini_set("display_errors", "on");
if (!empty($_POST['saveButton']) || !empty($_POST['updateButton'])) {
	$id = "0";
	if (!empty($_POST['idForUpdate'])) {
		$id = $_POST['idForUpdate'];
	}
	$itemText = $_POST['itemText'];

	if ($id == "0") {
		$sql = "insert into rules(text,date) values('$itemText',NOW())";
	} else {
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
	$activePage = "coupons";
	include('common/header.php');
	?>
	<div class="culmn">

		<div class="container border my-4">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<h4 align="center"><u>Bankers</u></h4>
						</div>
						<div class="col-md-4" align="right"><button type="button" class="btn btn-info" aria-hidden="true" onClick="addNewBanker()">Add New</button></div>
					</div>
					<div class="row">
						<div class="col" style="overflow-x: auto; white-space: nowrap;">
							<?php
							$string = "<table id='DataGrid' align='center' width='100%' border='1' class='table dt-responsive'>
											<thead>
											<tr  style='color:black'>
											<th width='5%' align='center'><b>S. No.</b></th>
											<th width='15%' ><b align='center'>Name</b></th>
											<th width='15%' ><b align='center'>Match Date</b></th>
											<th width='15%' ><b align='center'>Close Date</b></th>
											<th width='15%' ><b align='center'>Min Stack</b></th>
											<th width='10%' ><b align='center'>Min Selected No</b></th>
                                            <th width='15%' ><b align='center'>Description</b></th>
											<th width='5%' align='center'><b>Status</b></th>
											<th width='5%' align='center'><b>Action</b></th>
											</tr>
											</thead>
											<tbody>";
							/*<th width='10%' ><b align='center'>Season</b></th>*/
							$sr = 0;
							$idForUpdate = 0;

							$sql = "SELECT * from bankers";
							$stmt3 = $connection->query($sql);
							if ($stmt3) {
								while ($row3 = $stmt3->fetch_assoc()) {
									$status = $row3['status']?"Active":"InActive";
									$string = $string . "<tr style='height:20px;color:black;'>
												<td id='sr_" . $sr . "' align='center'>" . ($sr + 1) . "</td>
												<td id='name_" . $sr . "'>" . $row3['name'] . "</td>
												<td id='matchDate_" . $sr . "'>" . $row3['openDate'] . "</td>
												<td id='closeDate_" . $sr . "'>" . $row3['closeDate'] . "</td>
												<td id='minStack_" . $sr . "'>" . $row3['minStack'] . "</td>
												<td id='minSelectedNo_" . $sr . "'>" . $row3['minSelectedNo'] . "</td>
												<td id='description_" . $sr . "'>" . $row3['description'] . "</td>
												<td id='status_" . $sr . "' align='center'>" . $status . "</td>
												<td align='center'>
												<img onClick='edit(" . $sr . ");' src='../images/editButton.png' border='0' title='Edit' width='16' height='16' />
												
												<input type='hidden' id='idForUpdate_" . $sr . "' value='" . $row3['id'] . "'>
												</td>
												</tr>";
									//<img onClick='deleteItem(".$sr.");' src='images/delete_icon.gif' border='0' title='Delete' width='16' height='16' style='margin:0 10 0 10'/>
									$sr++;
									/*<td id='season_".$sr."'>".$row3['season']."</td>*/
								}
							} else {
								echo "no data found." . $stmt3->error();
							}
							$string = $string . "</tbody></table>";
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
	<div id="bankerDetailModel" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard=false aria-labelledby="myModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-lg" role="document" style="width:100%">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<div class="modal-title" style="color: #196780;">
						<div class="text-white">
							<b>Add New Banker Detail</b> <span id="tokenNoSpan1"></span>
						</div>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" id="customerServiceRequestModal_body">
					<div class="form-horizontal" role="form">
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
																		<td width="30%">Name :</td>
																		<td width="70%">
																			<div class="input-group">
																				<input type="text" id="name" class="form-control input-sm" placeholder="Name" />
																				<div class="input-group-append">
																					<span class="input-group-text">&#8358;</span>
																				</div>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td width="30%" style="padding-top:15px">Open Date :</td>
																		<td width="70%">
																			<input type="text" id="matchDate" class="form-control input-sm" placeholder="yyyy-mm-dd hh:mm" />
																		</td>
																	</tr>
																	<tr>
																		<td width="30%" style="padding-top:15px">Close Date :</td>
																		<td width="70%">
																			<input type="text" id="closeDate" class="form-control input-sm" placeholder="yyyy-mm-dd hh:mm" />
																		</td>
																	</tr>
																	<tr>
																		<td width="30%" style="padding-top:15px">Min Stack :</td>
																		<td width="70%">
																			<div class="input-group">
																				<input type="text" id="minStack" class="form-control input-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Minimum Stack" />
																				<div class="input-group-append">
																					<span class="input-group-text">&#8358;</span>
																				</div>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td width="30%" style="padding-top:15px">Min Stack :</td>
																		<td width="70%">
																			<div class="input-group">
																				<input type="text" id="minSelectedNo" class="form-control input-sm" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Minimum Selected Number" />
																				<div class="input-group-append">
																					<span class="input-group-text">&#8358;</span>
																				</div>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td width="30%" style="padding-top:15px">Description :</td>
																		<td width="70%" style="padding-top:15px"><textarea id="description" class="form-control input-sm textarea" style="width:100%"></textarea></td>
																	</tr>
																	<tr>
																		<td width="30%" style="padding-top:15px">status :</td>
																		<td width="70%" style="padding-top:15px">
																			<select id="status" class="form-control input-sm" style="width:100%">
																				<option value="1">true</option>
																				<option value="0">false</option>
																			</select>
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
										<button type="button" class="btn btn-success" id="saveButton" onclick="saveOrUpdateBanker()">Save</button>
										<button type='button' class="btn btn-primary" id="updateButton" name="updateButton" onclick="saveOrUpdateBanker()" disabled style="width:30%">Update</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
									</div>
								</td>
							</tr>
						</table>
						<div class='row'>
							<div class="com-md-5">
								<div class="form-group">
									<!-- Error Message Div -->
									<table border=0 width="80%" align='center'>
										<tr>
											<td colspan=3>
												<div style="margin-left:10%;margin-right:10%width:95%;height:80px;color:red;overflow:auto;display:none" id="error" class="error"></div>
											</td>
										</tr>
									</table>
									<!-- Success Message Div -->
									<table border=0 width="80%" align='center'>
										<tr>
											<td></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<input type="hidden" id="idForUpdate" value="0" />
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

	<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
	<script src="../assets/js/vendor/popper.min.js"></script>
	<script src="../assets/js/vendor/bootstrap.min.js"></script>

	<script src="../js/jquery.dataTables.min.js"></script>
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<!-- material datepicker -->
	<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
	<script src="../assets/js/vendor/bootstrap-material-datetimepicker.js"></script>
	<script src="../assets/js/mdtimepicker.js"></script>
	<link href="../assets/css/mdtimepicker.css" rel="stylesheet" type="text/css">

	<script>
		$(document).ready(function() {
			/*$('#matchDate').bootstrapMaterialDatePicker
			({
				format: 'dddd DD MMMM YYYY - HH:mm'
			});*/
			$('#matchDate').bootstrapMaterialDatePicker({
				weekStart: 1,
				time: false
			});
			$('#closeDate').bootstrapMaterialDatePicker({
				format: 'YYYY-MM-DD HH:mm',
				switchOnClick: true,
				weekStart: 1,
				minDate: new Date(),
				time: true
			});

			//$('#matchDateTime').mdtimepicker(); //Initializes the time picker

			$('#DataGrid').dataTable({
				"bLengthChange": false,
				"pageLength": 5,
				responsive: true,
			});
		});

		function saveOrUpdateBanker() {
			document.getElementById("saveButton").disabled = true;
			document.getElementById("updateButton").disabled = true;

			var idForUpdate = $('#idForUpdate').val();
			var name = $('#name').val();
			var description = $('#description').val();
			var status = $('#status').val();
			var matchDate = $('#matchDate').val();
			var closeDate = $('#closeDate').val();
			var minStack = $('#minStack').val();
			var minSelectedNo = $('#minSelectedNo').val();

			var form_data = new FormData();
			form_data.append("idForUpdate", idForUpdate);
			form_data.append("name", name);
			form_data.append("description", description);
			form_data.append("status", status);
			form_data.append("matchDate", matchDate);
			form_data.append("closeDate", closeDate);
			form_data.append("minStack", minStack);
			form_data.append("minSelectedNo", minSelectedNo);

			$.ajax({
				type: "POST",
				url: "<?= $host ?>/api/saveOrUpdateBanker.php",
				processData: false,
				contentType: false,
				data: form_data,
				//data: "pageNumber=" + pageNumber+"&masterId="+masterId+"&code=" + code+"&name=" + name + "&remark=" + remark + "&idForUpdate=" + idForUpdate,  
				success: function(response) {
					response = JSON.parse(response);
					if (response.success == "1") {
						$('#modalInfoTitle').html("Success!");
						$('#modalInfoBody').html(response.message);
						//$('#dataTableGrid').html(response.dataGrid);

						//resetData();
						$('#error').hide('slow');
						$('#bankerDetailModel').modal('hide');
						$('#modalInfo').modal('show');
						//addClassForColor();
						$('#GeneralMasterDataGrid').dataTable({
							"bLengthChange": false,
							"pageLength": 5,
							responsive: true,
						});
						location.reload();

						//resetForm();
					} else {
						$('#error').html(response.result);
						$('#info').hide('slow');
						$('#error').show('slow');
					}
				},
				error: function(e) {
					alert(e.status);
					alert(e.responseText);
					alert(thrownError);
				}
			});
			//document.getElementById("saveButton").disabled=true;
		}

		function edit(sr) {
			$('#bankerDetailModel').modal('show');

			document.getElementById("saveButton").disabled = true;
			document.getElementById("updateButton").disabled = false;

			var idForUpdate = $('#idForUpdate_' + sr).val();
			var name = $('#name_' + sr).text();
			var description = $('#description_' + sr).text();
			var status = $('#status_' + sr).text();
			var matchDate = $('#matchDate_' + sr).text();
			var closeDate = $('#closeDate_' + sr).text();
			var minStack = $('#minStack_' + sr).text();
			var minSelectedNo = $('#minSelectedNo_' + sr).text();

			$('#idForUpdate').val(idForUpdate);
			$('#name').val(name);
			$('#description').val(description);
			$('#status').val(status);
			$('#matchDate').val(matchDate);
			$('#closeDate').val(closeDate);
			$('#minStack').val(minStack);
			$('#minSelectedNo').val(minSelectedNo);
		}

		function deleteItem(sr) {
			if (confirm('Are you sure you want to delete this Record?')) {
				var idForUpdate = $('#idForUpdate_' + sr).val();
				form_data = new FormData();
				form_data.append("pageNumber", pageNumber);
				form_data.append("idForDelete", idForUpdate);
				$.ajax({
					type: "POST",
					url: "<?= $host ?>/deleteInventoryItem.html",
					//data: "pageNumber=" + pageNumber+"&idForDelete="+idForDelete,
					processData: false,
					contentType: false,
					data: form_data,
					success: function(response) {
						if (response.status == "Success") {
							$('#info').html(response.result);
							$('#dataTableGrid').html(response.dataGrid);
							//$('#dataTable2').html(response.dataGrid);
							$('#GeneralMasterDataGrid').dataTable({
								"bLengthChange": false,
								"pageLength": 4,
								responsive: true,
							});
						} else {
							$('#error').html(response.result);
							$('#info').hide('slow');
							$('#error').show('slow');
						}
					},
					error: function(e) {
						alert('Error: ' + e);
					}
				});
			}
		}

		function addNewBanker() {
			$('#bankerDetailModel').modal('show');
			//$('#itemText').val($('#name_'+formFillForEditId).html());

			//document.getElementById("saveButton").disabled=true;
			//document.getElementById("updateButton").disabled=false;
			emptyOddsTable();
			addOddsRow();
			$('#idForUpdate').val("0");

			document.getElementById("saveButton").disabled = false;
			document.getElementById("updateButton").disabled = true;
		}

		function addOddsRow(id, from, to, odds2, odds3, odds4, odds5, odds6, odds7, odds8) {
			if (id == null) {
				id = '';
				from = '';
				to = '';
				odds2 = 0;
				odds3 = 0;
				odds4 = 0;
				odds5 = 0;
				odds6 = 0;
				odds7 = 0;
				odds8 = 0;
			} else {
				//$("#oddsTable tr:first").next().remove();
			}
			var sr = $("#oddsRowCount").val();
			sr++;
			$("#oddsRowCount").val(sr);
			var html = '<tr id="tr_odds_' + sr + '">';
			html = html + '<td><div class="input-group" style="width:100%"><div class="input-group-prepend mx-0" style="width:50%"><input type="text" id="drawFrom_' + sr + '" class="input-group-text px-0" style="width:100%;font-size:0.75rem;background-color:#ffffff" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="phone" placeholder="from" value="' + from + '"></div><div class="input-group-append mx-0" style="width:50%"><input type="text" id="drawTo_' + sr + '" class="input-group-text px-0" style="width:100%;font-size:0.75rem;background-color:#ffffff" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="' + to + '" placeholder="to"></div></div></td>';

			if ($("#cb_under_2").prop('checked') == true) {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_2" value="' + odds2 + '" class="form-control form-control-sm u2" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			} else {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_2" value="' + odds2 + '" class="form-control form-control-sm u2" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			}
			if ($("#cb_under_3").prop('checked') == true) {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_3" value="' + odds3 + '" class="form-control form-control-sm u3" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			} else {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_3" value="' + odds3 + '" class="form-control form-control-sm u3" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			}
			if ($("#cb_under_4").prop('checked') == true) {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_4" value="' + odds4 + '" class="form-control form-control-sm u4" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			} else {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_4" value="' + odds4 + '" class="form-control form-control-sm u4" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			}
			if ($("#cb_under_5").prop('checked') == true) {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_5" value="' + odds5 + '" class="form-control form-control-sm u5" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			} else {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_5" value="' + odds5 + '" class="form-control form-control-sm u5" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			}
			if ($("#cb_under_6").prop('checked') == true) {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_6" value="' + odds6 + '" class="form-control form-control-sm u6" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			} else {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_6" value="' + odds6 + '" class="form-control form-control-sm u6" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			}
			if ($("#cb_under_7").prop('checked') == true) {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_7" value="' + odds7 + '" class="form-control form-control-sm u7" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			} else {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_7" value="' + odds7 + '" class="form-control form-control-sm u7" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			}
			if ($("#cb_under_8").prop('checked') == true) {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_8" value="' + odds8 + '" class="form-control form-control-sm u8" style="width:100%;height:100%;background-color:#ffffff" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			} else {
				html = html + '<td class="border"><input type="text" id="odds_' + sr + '_8" value="' + odds8 + '" class="form-control form-control-sm u8" style="width:100%;height:100%;background-color:#e9e9e9" disabled onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" placeholder="odds"></td>';
			}
			html = html + '<td class="text-right" style="width:30px;cursor:pointer;"><img src="../images/ic-delete.png" onclick="removeOddsRow(' + sr + ')" style="width:70%" alt=""/><input type="hidden" id="drawId_' + sr + '" value="' + id + '"/></td></tr>';
			$("#tr_th_odds").parent().append(html);
		}

		function removeOddsRow(sr) {
			$("#tr_odds_" + sr).remove();
		}

		function emptyOddsTable() {
			var sr = $("#oddsRowCount").val();
			for (var i = 0; i <= sr; i++) {
				$("#tr_odds_" + i).remove();
			}
			$("#oddsRowCount").val("0");
		}
	</script>

	<script>
		$(":checkbox").change(function() {
			if ($("#cb_under_2").prop('checked') == true) {
				$(".u2").removeAttr('disabled');
				$(".u2").attr('style', 'background-color:#ffffff');
			} else {
				$(".u2").prop("disabled", true);
				$(".u2").attr('style', 'background-color:#e9e9e9');
			}
			if ($("#cb_under_3").prop('checked') == true) {
				$(".u3").removeAttr('disabled');
				$(".u3").attr('style', 'background-color:#ffffff');
			} else {
				$(".u3").prop("disabled", true);
				$(".u3").attr('style', 'background-color:#e9e9e9');
			}
			if ($("#cb_under_4").prop('checked') == true) {
				$(".u4").removeAttr('disabled');
				$(".u4").attr('style', 'background-color:#ffffff');
			} else {
				$(".u4").prop("disabled", true);
				$(".u4").attr('style', 'background-color:#e9e9e9');
			}
			if ($("#cb_under_5").prop('checked') == true) {
				$(".u5").removeAttr('disabled');
				$(".u5").attr('style', 'background-color:#ffffff');
			} else {
				$(".u5").prop("disabled", true);
				$(".u5").attr('style', 'background-color:#e9e9e9');
			}
			if ($("#cb_under_6").prop('checked') == true) {
				$(".u6").removeAttr('disabled');
				$(".u6").attr('style', 'background-color:#ffffff');
			} else {
				$(".u6").prop("disabled", true);
				$(".u6").attr('style', 'background-color:#e9e9e9');
			}
			if ($("#cb_under_7").prop('checked') == true) {
				$(".u7").removeAttr('disabled');
				$(".u7").attr('style', 'background-color:#ffffff');
			} else {
				$(".u7").prop("disabled", true);
				$(".u7").attr('style', 'background-color:#e9e9e9');
			}
			if ($("#cb_under_8").prop('checked') == true) {
				$(".u8").removeAttr('disabled');
				$(".u8").attr('style', 'background-color:#ffffff');
			} else {
				$(".u8").prop("disabled", true);
				$(".u8").attr('style', 'background-color:#e9e9e9');
			}
		});
	</script>


</body>

</html>
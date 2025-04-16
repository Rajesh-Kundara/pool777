
<?php

ini_set('max_execution_time', '300');
require_once 'lib/html5lib/Parser.php';
require_once '../config.php';
require 'vendor/autoload.php';
require_once 'autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
ini_set("display_errors","on");

// instantiate and use the dompdf class

$isTestMode=false;
		$flat_id = $_GET['flat'];
    	$flat_id = base64_decode($flat_id);
		$SId = $_SESSION['sId'];
			$sql = "Select * From society where id = $SId";
				$sql_query = $mysqli->query($sql);
				while($row2 = mysqli_fetch_array($sql_query)){
					$AccountHolderName=$row2['AccountHolderName'];
					$SocietyName=$row2['SocietyName'];
					$SocietyAddress=$row2['Address'];
					$SocoietyBank=$row2['BankName'];
					$QRcode=$row2['QR'];
					//QR code to base64
					$path = '../../SuperAdmin/uploads/'.$QRcode;
					$type = pathinfo($path, PATHINFO_EXTENSION);
					$data = file_get_contents($path);
					$qr_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

					$LastBillNo = $row2['LastBillNo'];
					$SocoietyBankAccountNo=$row2['AccountNo'];
					$SocoietyBankIFSCCode=$row2['IFSCCode'];
					$RegistrationNumber=$row2['RegistrationNumber'];
					$OldSid = $SId;
				
				}
		$maint_sql = "SELECT * FROM maintenance_rate ";    
		$maint_query = $mysqli->query($maint_sql);
		$row_m = $maint_query->fetch_assoc();
		$maintRate = $row_m['rate'];

		$penalty_sql = "SELECT * FROM penalty WHERE status=1 ORDER BY id DESC LIMIT 1";    
		$penalty_query = $mysqli->query($penalty_sql);
		$row_p = $penalty_query->fetch_assoc();
		$days = $row_p['days'];
		$isFixed = $row_p['isFixed'];
		$percent = $row_p['percent'];
		$fix = $row_p['fix'];
		$maintenanceDate=date('Y-m-d', strtotime('last day of last month'));
		// $maintenanceDate='2024-11-31';
		$billDtFrom=date('01-m-Y',strtotime("-1 months"));
		$billDtTo=date('t-m-Y',strtotime("-1 months"));
		
		$max_mid_sql = "select MAX(id) as id FROM maintenance_detail WHERE isSmsSent=1 AND maintenance_date='$maintenanceDate'";    
		$max_mid_query = $mysqli->query($max_mid_sql);
		$row_max_mid = $max_mid_query->fetch_assoc();
		$max_mid= $row_max_mid['id'];
		$sql="SELECT a.*,b.id as fId,b.owner_name,b.owner_mobile,b.flat_area,b.flat_number,
					b.owner_email,(select name FROM blocks WHERE id=a.block_id) as block_name
					FROM maintenance_detail a LEFT JOIN flats b
              		ON a.flat_id=b.id WHERE 
					-- a.maintenance_date='$maintenanceDate' AND
					b.id='$flat_id' ";
		//echo $sql;die;	
		$query = $mysqli->query($sql);
		if($query->num_rows > 0){
			$i = 1;
			while($row = mysqli_fetch_array($query)){
				$sr=1;
				$flat_area = $row['flat_area'];
				$OldSid = '0';
				 $id = $row['fId'];
				 
				 $LastBillNo++;
				$bill_no=$SId.date('Y').(str_pad($LastBillNo,5,"0",STR_PAD_LEFT));
				//$bill_no.=(str_pad($id,4,"0",STR_PAD_LEFT));
				/******************************/
				$total_dep_sql = "SELECT SUM(amount) FROM transaction WHERE flat_id=$id and status = 2";    
				$total_dep_row = mysqli_fetch_row($mysqli->query($total_dep_sql));
				$total_dep=$total_dep_row[0];
				
				$isEmailSent=false;
				$isSmsSent=false;
				$isNSentChecked=false;
				$mId=0;
				$last_due_sql = "SELECT id,amount,deposit,penalty,isEmailSent,isSmsSent FROM maintenance_detail WHERE flat_id=$id ORDER BY id DESC";    
				$last_due_query = $mysqli->query($last_due_sql);
				//$row_last_due = $last_due_query->fetch_assoc();
				$total_due=0;
				while($row2 = mysqli_fetch_array($last_due_query)){
					$total_due+= $row2['amount']+$row2['penalty'];
					
					if(!$isNSentChecked){
						$isNSentChecked=true;
						$isEmailSent=$row2['isEmailSent'];
						$isSmsSent=$row2['isSmsSent'];
						$mId=$row2['id'];
					}
				}

				 $total_due=$total_due-$total_dep;
				/******************************/
				
				$owner_name = ucwords($row['owner_name']);
				$owner_mobile= $row['owner_mobile'];
				$flat_area = ucwords($row['flat_area']);
				$flat_number = $row['flat_number'];
				$to = $row['owner_email'];
				
				$owner_email = $row['owner_email'];
				$block_name = $row['block_name'];
				
				
				$bill_amt = $flat_area*$maintRate;

				$prev_due=$total_due-$bill_amt;
				$amt_after_dd= (($isFixed)?$total_due+$fix:($total_due*((100+$percent)/100)));
				
				$amount_in_words = ucwords(getAmountInWords(round($total_due)));
				
				//$curr_date = date('Y-m-d');
				$bill_date = date('d-M-Y');
				$bill_month = date('M-Y', strtotime("-1 months"));
				$due_date = date('d-M-Y', strtotime("+".$days." days"));
				$due_date2 = date('d M', strtotime("+".$days." days"));
				
				 $bill_name = $block_name."_".$flat_number."_".$bill_no.".pdf";


				$str = "

								<!DOCTYPE html>
								<html>
								<head>
								<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
								<style>
									@page { size:  595.28pt 841.89pt; margin: 30px;  }
									table {
                                        border-collapse: collapse;
                                        width: 100%;
                                    }
                                    .no-border {
                                        border: none;
                                    }
									tr,th,td {
                                        border: none;
                                        padding: 6px;
                                    }
                                    .ba{
                                        border:1px #515151 solid;
                                    }
                                    .bt{
                                        border-top:0.5px #b6b6b6 solid;
                                    }
                                    .br{
                                        border-right:0.5px #b6b6b6 solid;
                                    }
                                    .bb{
                                        border-bottom:0.5px #b6b6b6 solid;
                                    }
                                    .bl{
                                        border-left:0.5px #b6b6b6 solid;
                                    }
                                    .no-border tr, .no-border td, .no-border th {
                                        border: none;
                                    }
                                    .border tr, .border td, .border th {
                                        border:0.5px #b6b6b6 solid;
                                    }
									.text-center{
										text-align: center;
									}
									.text-right{
										text-align: right;
									}
									table { border-collapse:collapse }
								</style>
								</head>
									<body>

										<table class='ba' width='100%' cellpadding='0' cellspacing='0' style='margin:0px auto; font-family: sans-serif;'>
												<tr style='visibility: collapse;'><th width='10%'></th><th width='10%'></th><th width='10%'></th><th width='10%'></th><th width='10%'></th><th width='10%'></th><th width='10%'></th><th width='10%'></th><th width='10%'></th><th width='10%'></th></tr>";
											$str .= "<tr class='ba'>
													<th colspan='10' align='center' style='font-size:26px;font-weight: 500;padding: 20px;'>".$SocietyName."
													<br>
													<span style='font-size:15px'>".$SocietyAddress."</span><br>
														<span style='font-size:15px'>Registration Number :".$RegistrationNumber." </span>
													
													</th>
												</tr>";
											
													$str .= "<tr style='font-size:14px'>
																
														
														<td class='ba' colspan='4' style='padding: 0px;'>

														
																	<table class='no-border' style='color:#464646;width:100%' cellpadding='0' cellspacing='0'>
																		<tr>
																			<td>To: $owner_name</td>
																		</tr>
																		<tr>
																			<td>Flat/Shop No : $block_name"."-"."$flat_number</td>
																		</tr>
																		
																	</table>
																
															
															
														</td>

														<td class='ba' colspan='6' style='padding: 0px;'>
															
																<table class='no-border' style='color:#464646;width:100%;' cellpadding='0' cellspacing='0'>
																	<tr >
																		<td colspan='1'> Bill No</td>
																		<td colspan='2'>: $bill_no</td>
																		<td colspan='1'>Date</td>
																		<td colspan='2'>: $bill_date</td>
																	</tr>
																	<tr>
																		<td colspan='1' >Area</td>
																		<td colspan='2'>: $flat_area sq.ft.</td>
																		<td colspan='1'>Due On</td>
																		<td colspan='2'>: $due_date</td>
																	</tr>
																	<tr>
																		<td colspan='1'>Billing Period</td>
																		<td colspan='5'>: $billDtFrom to $billDtTo</td>
																	</tr>
																	<tr style='visibility:collapse'><td width='25%'></td><td width='15%'></td><td width='15%'></td><td width='15%'></td><td width='15%'></td><td width='15%'></td></tr>
																</table>
															
																
															
														</td>
									
													</tr>";

														$str .= "<tr>
														<td colspan='10'  style='padding:0px;'>
															<table width='100%'  style='border-collapse: collapse; font-family: sans-serif;font-size:13px' cellpadding='0' cellspacing='0'>
																	<tr class='bb'>
																		<th class='br bb' colspan='1' width='8%'>Sr No.</th>
																		<th class='br bb' colspan='4' width='78%'>Description</th>
																		<th class='bb' colspan='1' class='text-center bottom-row' width='14%'>Amount</th>
																	</tr>
																	
																	<tr class='bb'>
																		<td class='br bb' colspan='1'>$sr</td>
																		<td class='br bb' colspan='4'>Present Maintenance Charges</td>
																		<td class='bb' colspan='1' class='text-right bottom-row'>".number_format($bill_amt,2)."</td>
																	</tr>";
																	$sr++;
																
																			
																	$str .= "<tr class='bb'>
																				<td class='br bb' >$sr</td>
																				<td class='br bb' colspan='4'>Previous Due </td>
																				<td class='text-right bottom-row'>".number_format($prev_due,2)."</td>
																			</tr>";
																			$sr++;
																	$str .= "<tr class='bb'>
																				<td class='br bb' >$sr</td>
																				<td class='br bb' colspan='4'>Total Due by Due Date </td>
																				<td class='text-right bottom-row'>".number_format($total_due,2)."</td>
																			</tr>";
																			$sr++;
																	$str .= 	"<tr class='bb'>
																				<td class='br bb' >$sr</td>
																				<td class='br bb' colspan='4'>Amount after Due Date ( Previous Due + Present Maintenance Charge + Penalty )</td>
																				<td class='text-right bottom-row'>".number_format($amt_after_dd,2)."</td>
																			</tr>";
																	
																	
																	
																	$str .="<tr class='bb' style='height:200px;'>
																		<td class='br bb' style='height:450px;'></td>
																		<td colspan='4' class='br bb'>

																		
																		
										<table cellpadding='0' cellspacing='0' style='border:0px;border-collapse: collapse; '>
										<tr>
										<td width='75%' >
										<table cellpadding='0' cellspacing='0' border='0' style='border:0px;border-collapse: collapse; '>
																				<tr>
											<td width='100%'>Bank Details</td>
										</tr>
																				<tr>
																				<td>A/c Name:".$AccountHolderName."</td>
																				</tr>
																				<tr>
																				<td>".$SocoietyBank."</td>
																				</tr>
																				<tr>
																				<td>A/c NO:".$SocoietyBankAccountNo."</td>
																				</tr>									<tr>
																				<td> IFSC :".$SocoietyBankIFSCCode."</td>
																				</tr>
																				<tr>
																					<td></td>
																				</tr>
																			</table>
										</td>
										<td width='25%'>
										<table style='border-left: #e6e6e6 0.5px solid;' cellpadding='0' cellspacing='0'>
										<tr><td width='100%' style='text-center:center'>Scan to Pay</td></tr>
										<tr><td>
										<img class='' src='$qr_base64' style='width: 100%;height: auto;min-height:100px;min-width:100px;margin:0px' alt='QR Code'></td></tr>
										</table>
										</tr>
										<tr>
										<td colspan='2'>This notice is being issued to those flat owners/tenants whose maintenance dues are more than one month. According to the Society/Apartment bye-laws of society, the supply of water, electricity and the maintenance facility may be cut at any time under this notice. The entire responsibility for this will be with the flat owner/tenant.<br> Please consider it as final notice. Please ignore this if already paid.</td>
										</tr>
										</table>
																	</td>
																		<td class='bb' style='height:450px;'>&nbsp;</td>
																	</tr>
																	<tr class='bb'>
																		<td class='right '></td>
																		<td class='right br' colspan='4' align='right'>Total Payable (rounded)</td>
																		<td class='text-right'>".number_format(round($total_due),2)."</td>
																	</tr>
																	
																	
															</table>

														</td>
													</tr>";
													$str .= "<tr>
																<td colspan='10'>Amount in words :<strong>$amount_in_words </strong></td>
																
															</tr>";	
													$str .= "<tr class='bt'>
																<td colspan='5' class='br' >

																	<table width= '100%' cellpadding='0' cellspacing='0'>
																		<tr>
																			<td style='font-size:0.70rem;'>Notes: 1. Cheque should be drawn in favour of society only.</td>
																		</tr>
																		<tr>
																			<td style='font-size:0.70rem;'>2. Penalty of ".(($isFixed)?"&#8377; ".$fix:$percent."%")." will be added after due date.</td>
																		</tr>
																		<tr>
																			<td style='font-size:0.70rem;'>3. This is computer generated bill, thus requires no signature.</td>
																		</tr>
																	</table>
																	
																</td>
																<td colspan='5' align='right'>Thanking you<br>Yours sincerely<br><strong>Gurushikhar Bhawan Rakh Rakhav Samiti</strong>
																</td>
															</tr>";	
													$str .= "
										</table>
									</body>
				</html>";
		
				// echo $str;die;
				$dompdf = new Dompdf();
				$dompdf->set_option('defaultFont', 'sans-serif');

				$dompdf->loadHtml($str );

				// (Optional) Setup the paper size and orientation
				$dompdf->setPaper('A4', 'landscape');

				// Render the HTML as PDF
				$dompdf->render();
                $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
				
			}
		}

?>
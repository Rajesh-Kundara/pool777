<?php
require 'vendor/autoload.php';
require_once 'autoload.inc.php';
require_once '../config.php';
ini_set("display_errors","on");
// reference the Dompdf namespace
use Dompdf\Dompdf;

$penalty_sql = "SELECT * FROM penalty WHERE status=1 ORDER BY id DESC LIMIT 1";    
$penalty_query = $mysqli->query($penalty_sql);
$row_p = $penalty_query->fetch_assoc();
$isFixed = $row_p['isFixed'];
$percent = $row_p['percent'];
$fix = $row_p['fix'];

$trans_id = base64_decode($_GET['trans_id']);

 $sql = "select t2.*,t1.owner_name,(select name FROM blocks WHERE id=t1.block_id) as block,t1.flat_number,t1.flat_area,t1.sId from flats as t1 inner join transaction as t2 on t1.id = t2.flat_id where t2.id = '$trans_id' order by t2.id desc";
$query = $mysqli->query($sql);
 if($query->num_rows> 0){

	while($row = mysqli_fetch_array($query)){
		$sr=1;
		$SId=$row['sId'];
		// *************************
		$sql = "Select * From society where id = $SId";
					$sql_query = $mysqli->query($sql);
					while($row2 = mysqli_fetch_array($sql_query)){
					
						

						$AccountHolderName=$row2['AccountHolderName'];
						$SocietyName=$row2['SocietyName'];
						$SocietyAddress=$row2['Address'];
						$SocoietyBank=$row2['BankName'];
						$SocoietyBankAccountNo=$row2['AccountNo'];
						$SocoietyBankIFSCCode=$row2['IFSCCode'];
						$RegistrationNumber=$row2['RegistrationNumber'];
			
					
					}
		// *************************

		$trId=$row['id'];
		$receiptNum=$row['receiptNum'];
		$flat_area=$row['flat_area'];
		 // Set Path to Font File
		$font_path = '../font/calibrib.ttf';

		// Set Text to Be Printed On Image
		$dateText = date('d-m-Y',strtotime($row['date']));
		$depDate = date('d-m-Y',strtotime($row['depositDate']));
		$name = ucwords($row['owner_name']);
		$fathern = "";
		$amount = $row['amount'];
		$amount_in_words = ucwords(getAmountInWords($row['amount']));
		$block = $row['block'];
		$flat_number = $row['flat_number'];
		$from = ($row['fromDate']!=null)?date('d-m-Y',strtotime($row['fromDate'])):"";
		$to = ($row['toDate']!=null)?date('d-m-Y',strtotime($row['toDate'])):"";
		$dateOfReceipt = ($row['dateOfReceipt']!=null)?date('d-m-Y',strtotime($row['dateOfReceipt'])):"";
		// $mode = $row['mode'];
		// $bank = $row['bank'];
		// $ref_no = $row['refNo'];
		// $ref_no = $row['TId'];
		$transactionId=$row['TId'];
				$refNo=$row['refNo'];
				$paymentMethod=$row['mode'];
				$paymentCreatedat=$row['depositDate'];
				$timestamp = strtotime($paymentCreatedat);
				$DateTime = date('d-m-Y H:i:s', $timestamp);

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

								.text-align{

									text-align: center;

								}

								table { border-collapse:collapse }

					</style>

				</head>

				<body>



					<table class='ba' width='100%' border='1' cellpadding='0' cellspacing='0' style='margin:0px auto; font-family: sans-serif;'>";



						$str .= "<tr class=''>

									<th colspan='6' align='center' style='font-size:26px;font-weight: 500;padding: 20px;'>".$SocietyName."

										<br>

										<span style='font-size:15px'>".$SocietyAddress."</span><br>

										<span style='font-size:15px'>Registration Number :".$RegistrationNumber." </span>
									</th>

								</tr>
								<tr>
									
									<td colspan='6' > Reciept No: $receiptNum</td>
								</tr>";
						$str .= "<tr class=''>
									<td class='bt bb br' colspan='3'style='padding: 0px;'>
										<table style='color:#464646;'>
											<tr><td>To: $name</td></tr>
											<tr><td>Flat/Shop No: $block"."-"."$flat_number</td></tr>
											<tr><td>Area: $flat_area ft.sq.</td></tr>
										</table>
									</td>
									<td class='bb bt' colspan='3' style='padding: 0px;'>
										<table style='color:#464646;width:100%;'>
											<tr >
												<td colspan='1' >Deposit Date</td>
												<td colspan='3' style=''>:$depDate</td>
											</tr>
											<tr>
												<td colspan='1' >Invoice Date</td>
												<td colspan='3' style=''>:$dateOfReceipt</td>
											</tr>

											<tr>
												<td colspan='1'>Billing Period </td>
												<td colspan='3'>:$from to $to</td>
											</tr>
										</table>
									</td>
								</tr>";

						$str .=	"<tr class='bb' style='font-family: sans-serif;font-size:13px;'>
									<td class='bt bb br' colspan='3'>Maintenance Deposited</td>
									<td class='bt bb 'class='text-align ' colspan='3'>".number_format($amount,2)."</td>
								</tr>"	;
						$str .=	"<tr class='bb' style='font-family: sans-serif;font-size:13px;'>
									<td class='bt bb br' colspan='3'>Payment Method</td>
									<td class='bt bb ' colspan='3' class='text-align '>".$paymentMethod."</td>
								</tr>"	;
						$str .=	"<tr class='bb' style='font-family: sans-serif;font-size:13px;'>
									<td class='bt bb br' colspan='3'>Transaction Id</td>
									<td class='bt bb' colspan='3' class='text-align '>".$transactionId."</td>
								</tr>"	;
						$str .=	"<tr class='bb' style='font-family: sans-serif;font-size:13px;'>
									<td class='bt bb br' colspan='3'>Date</td>
									<td class='bt bb ' colspan='3' class='text-align '>".$DateTime."</td>
								</tr>"	;
						$str .=	"<tr class='bb' style='font-family: sans-serif;font-size:13px;'>
									<td class='bt bb br' colspan='3'>Reference </td>
									<td class='bt bb ' colspan='3' class='text-align '>".$refNo."</td>
								</tr>"	;
						

						$str .= "<tr class='bb'>

									<td colspan='6'>Amount in words :<strong>$amount_in_words only </strong></td>
								</tr>";	

						$str .= "<tr class=''>

									<td colspan='3' class='br' >



										<table width= '100%'>

											<tr>

												<td style='font-size:0.70rem;'>Notes: 1. Cheque should be drawn in favour of society only.</td>

											</tr>

											<tr>

												<td style='font-size:0.70rem;'>2. Penalty of ".(($isFixed)?"&#8377; ".$fix:$percent."%")." will be added after due date.</td>

											</tr>

											<tr>

												<td style='font-size:0.70rem;'>3. This is computer generated receipt, thus requires no signature.</td>

											</tr>

										</table>

										

									</td>

									<td colspan='3' align='right'>Thanking you<br>Yours sincerely<br><strong>Gurushikhar Bhawan Rakh Rakhav Samiti</strong>

									</td>

								</tr>";	

						$str .= "

					</table>

				</body>

			</html>";

	echo $str;
		$dompdf = new Dompdf();
		$dompdf->set_option('defaultFont', 'sans-serif');

		$dompdf->loadHtml($str );

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		$dompdf->set_option('isHtml5ParserEnabled', true);
		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		//$dompdf->stream();
		$output = $dompdf->output();
		$fileName="$block"."_".$flat_number."_".$trId.".pdf";
		// Remove spaces and sanitize folder name
		$sanitizedSocietyName = explode(' ', trim($SocietyName))[0];

		// Define the folder path
		$folderPath = "../../pdf/invoices/$sanitizedSocietyName";

		// Create the folder if it doesn't exist
		if (!file_exists($folderPath)) {
			mkdir($folderPath, 0777, true);
		}

		file_put_contents("$folderPath/$fileName", $output);
		
		$query2 = $mysqli->query("update transaction set isInvoiceGenerated='1',invoiceName='$fileName' WHERE id=$trId");
	}
} 
?>
